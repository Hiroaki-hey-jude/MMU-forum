<!DOCTYPE html>
<html>
    <?php
        // TODO; llink backend
        include "includes/session.php";
        $errors = array();
        // echo $_POST['id'];
        if(isset($user)) {
            $user_id = $user['user_id'];
            
        } else {
            $user_id = null;
        }
        if(isset($_GET['id'])) {
            $post_id = $_GET['id'];

            $query_get_post = $conn->prepare("SELECT * FROM post WHERE post_id = ?;");
            $query_get_post->bind_param("i", $post_id);
            $query_get_post->execute();
            $post_data = $query_get_post->get_result();
            
            $comments = array();

            $query_get_comment = $conn->prepare("SELECT * FROM comment WHERE post_id = ?;");
            $query_get_comment->bind_param("i", $post_id);
            $query_get_comment->execute();
            $comments_data = $query_get_comment->get_result();

            if (!$post_data) {
                array_push($errors, "This select post query is wrong");
            }

            $query_get_author_data = $conn->prepare("SELECT * FROM user WHERE user_id = (SELECT author_id FROM post WHERE post_id = ?);");
            $query_get_author_data->bind_param("i", $post_id);
            $query_get_author_data->execute();
            $user_data = $query_get_author_data->get_result();
        

            if (!$comments_data) {
                array_push($errors, "This select comments query is wrong");
            }
            if (!$user_data) {
                array_push($errors, "This select user query is wrong");
            }

            // If the user already logged in then check if he got bookmark this already or not
            if (isset($user)) {
                $query_get_bookmark = $conn->prepare("SELECT * FROM bookmark WHERE post_id = ? AND user_id = ?;");
                $query_get_bookmark->bind_param("ii", $post_id, $user['user_id']);
                $query_get_bookmark->execute();
                $bookmark_data = $query_get_bookmark->get_result();

                $query_get_like = $conn->prepare("SELECT * FROM `like` WHERE post_id = ? AND user_id = ? AND comment_id is NULL;");
                $query_get_like->bind_param("ii", $post_id, $user['user_id']);
                $query_get_like->execute();
                $like_data = $query_get_like->get_result();
                
                if (!$bookmark_data)
                    array_push($erros, "This select bookmark query is wrong");
                if (!$like_data)
                    array_push($erros, "This select like query is wrong");
            }


        } else {
            array_push($errors, "post[id] isnt present");
        }

        if(count($errors) == 0) {
            // Get post details
            $post_row = mysqli_fetch_assoc($post_data);
            $title = $post_row["post_name"];
            $image = $post_row["image_name"];
            $description = $post_row["post_description"];
            $noOfLikes = $post_row["number_of_likes"];
            $noOfComments = $post_row["number_of_comments"];
            $createdAt = $post_row['created_at'];
            // Get post author details
            $author_row = mysqli_fetch_assoc($user_data);
            $authorName = $author_row['username'];
            $authorImage = $author_row['profile_pic_name'];
            $isBookmarked = false;
            $isPostLiked = false;

            if(isset($user)) {
                // The user haven't bookmark this post
                if(mysqli_num_rows($bookmark_data) != 0) {
                    $isBookmarked = true;
                    $bookmark_row = mysqli_fetch_assoc($bookmark_data);
                    $bookmark_id = $bookmark_row['bookmark_id'];
                }
                // The user haven't like this post
                if(mysqli_num_rows($like_data) != 0) {
                    $isPostLiked = true;
                    $like_row = mysqli_fetch_assoc($like_data);
                    $like_post_id = $like_row['like_id'];
                }
            } 

            

            // Get all comments for this post
            if (mysqli_num_rows($comments_data) > 0) {
                while ($comment_row = mysqli_fetch_assoc($comments_data)) {
                    $comment_id = $comment_row['comment_id'];
                    $comment_description = $comment_row['comment_description'];
                    $comment_time = $comment_row['comment_time'];
                    $comment_likes = $comment_row['number_of_likes'];
                    $liked_comment = false;
                    $like_comment_id = null;

                    // get commenter credentials
                    $query_to_get_commenter_data = "SELECT username, profile_pic_name FROM user WHERE user_id =" . $comment_row['commenter_id'] . ";";
                    $commenter_data = mysqli_query($conn, $query_to_get_commenter_data);
                    if (mysqli_num_rows($commenter_data) == 0 || !$commenter_data) {
                        array_push($errors, "Cannot get author name, user_id = " . $row['author_id'] . " doesn't exist in user table");
                        break;
                    }
                    $commenter_row = mysqli_fetch_assoc($commenter_data);
                    $commenter_name = $commenter_row['username'];
                    $commenter_pic = $commenter_row['profile_pic_name'];

                    // if the user already logged in, check if they like this comment
                    if (isset($user)) {
                        $query_check_liked_comment = "SELECT * FROM `like` WHERE user_id =" . $user['user_id'] .
                            " AND post_id =" . $post_id . " AND comment_id = " . $comment_id . ";";
                        $like_comment_data = mysqli_query($conn, $query_check_liked_comment);
                        if (!$like_comment_data) {
                            array_push($errors, "cannot select this comment like data");
                            break;
                        } else if (mysqli_num_rows($like_comment_data) != 0) {
                            $like_comment_row = mysqli_fetch_assoc($like_comment_data);
                            $liked_comment = true;
                            $like_comment_id = $like_comment_row['like_id'];
                        }
                    }

                    $comments[] = array(
                        $comment_id,
                        $commenter_pic,
                        $commenter_name,
                        $comment_time,
                        $comment_description,
                        $liked_comment,
                        $comment_likes,
                        $like_comment_id
                    );
                }
            }
            
        }

        // $title = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
        // $image = "https://i.imgur.com/AYk0AyG.png";
        // $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tristique velit nec ultricies efficitur. Vivamus dapibus erat metus. Vivamus sed porta augue. Curabitur pharetra facilisis feugiat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse eu pellentesque mauris. Integer at nibh quam. Proin enim lectus, cursus non augue vel, suscipit tincidunt mi. Aliquam tempus gravida felis, non volutpat ligula consectetur id. Nullam eu sapien pulvinar, interdum eros nec, molestie dui. Cras a eros ac arcu consequat laoreet. In semper massa purus. Etiam lacinia quis tellus tempor venenatis. Suspendisse nec elit quis eros tristique interdum.

        // Sed lacinia lacinia felis, quis ornare augue efficitur non. Cras sit amet nulla quis dolor commodo maximus dictum ut turpis. Ut feugiat leo ac posuere consequat. Maecenas iaculis auctor mi at congue. Etiam quis turpis id metus egestas imperdiet quis ac nibh. Praesent lacinia magna eget eros feugiat, feugiat tincidunt enim porta. Nulla ut libero rutrum, vestibulum lacus et, commodo eros. Quisque faucibus ex a nisl scelerisque rhoncus. Sed pharetra justo quis finibus porttitor. Sed urna odio, imperdiet vel turpis vitae, vestibulum ultrices arcu. Vestibulum ac turpis sed massa lobortis scelerisque. Duis et ante eget arcu tempus efficitur. Donec ac facilisis tellus, euismod tempor sem. Nulla faucibus odio blandit tellus eleifend, vitae tempor odio posuere. Aenean a scelerisque est, non lacinia odio. Ut lobortis sit amet lectus fringilla accumsan.";
        // // ?? 0 returns 0 for null handling
        // $noOfLikes = 3 ?? 0;
        // $noOfComments = 10 ?? 0;
        // $isPostLiked = true;
        // $isBookmarked = true;
        // $comments[] = array("cm0001", "https://picsum.photos/200", "comment author", "12/12/2022", "comment desc", true, 30);
        // $comments[] = array("cm0002", "https://picsum.photos/200", "comment author 1", "12/12/2022", "comment desc 1", false, 10);
        // $authorName = "Lim";
        // $authorImage = "https://picsum.photos/200";
        // $createdAt = "12/2/2016";
        $a = 'wefwefwef'; 
    include 'errors.php';
    ?>
    <head>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/global.css" />
        <script src="https://kit.fontawesome.com/f019d50a29.js" crossorigin="anonymous"></script>
       
    </head>
    <body>
        <?php include "components/header.php" ?>
        <?php include "components/sidebar.php" ?>
        <div class="page-container">
            <article class="post-header">
                <h2 class="post-title"><?php echo $title; ?></h2>
                <div class="post-author"><img class="post-author-image" src="images/<?php echo $authorImage ?>" /><?php echo $authorName ?>, <?php echo $createdAt ?></div>
                <img class="post-image" src="<?php echo $image; ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
                <p class="post-description"><?php echo $description; ?></p>
            </article>
            <section class="post-actions">
                <div class="post-action" onclick='process_like(<?php echo json_encode(array($user_id,$post_id,0)); ?>);'>
                    <span id="post-like-icon" class="post-action-icon <?php
                        if ($isPostLiked)
                            echo 'liked';
                    ?> fas fa-thumbs-up"></span>
                    <div id="post-number-of-likes"><?php echo $noOfLikes; ?></div>
                </div>
                <div class="post-action" onclick="document.getElementById('post-comment-input').focus();">
                    <span class="post-action-icon fas fa-comments"></span>
                    <div id="post-number-of-comments"><?php echo $noOfComments; ?></div>
                </div>
                <span style="flex: 1;"></span>
                <div class="post-action" style="margin-right: 0;" onclick='process_bookmark(<?php echo json_encode(array($user_id,$post_id)); ?>)'>
                    <span id="bookmark-icon" class="post-action-icon <?php
                        if ($isBookmarked)
                            echo 'bookmarked';
                    ?> fas fa-bookmark" style="margin-right: 0;"></span>
                </div>
            </section>
            <section class="post-comments">
                <?php
                    if ($noOfComments === 0)
                        echo '<div class="list-empty">No comments.</div>';
                    else
                        foreach ($comments as $comment) {
                            $js_argument = json_encode(array($user_id, $post_id, $comment[0]));
                            $isCommentLked = $comment[5];
                            if ($isCommentLked)
                                $likedClassName = "liked";
                            else
                                $likedClassName = "";

                            echo '
                            <div class="post-comment">
                                <div class="post-author">
                                    <img class="post-author-image" src="images/'.$comment[1].'" />'.$comment[2].'
                                    <span style="flex: 1;"></span>
                                    <div style="font-size: small;">'.$comment[3].'</div>
                                </div>
                                <p class="post-comment-desc">'.$comment[4].'</p>
                                <div class="post-comment-actions">
                                    <div class="post-action" onclick=\'process_like('.$js_argument.')\'>
                                        <span id="comment-'.$comment[0].'-like-icon" class="post-action-icon '. $likedClassName .' fas fa-thumbs-up"></span>
                                        <div id="comment-'.$comment[0].'-number-of-likes">' .$comment[6].'</div>
                                    </div>
                                </div>
                            </div>';
                        }
                ?>
            </section>
            <form class="post-comment-input">
                <textarea id="post-comment-input"></textarea>
                <span style="width: 1em;"></span>
                <div class="post-comment-send-button" onclick='process_comment(<?php echo json_encode(array($user_id,$post_id)); ?>)'>
                    <span class="fas fa-arrow-right"></span>
                </div>
            </form>
        </div>
    </body>
    <script src="process.js"></script>
</html>
