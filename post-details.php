<!DOCTYPE html>
<html>
    <?php
        // TODO; llink backend
        include "includes/session.php";
        $errors = array();
        $post_id = $_POST['id'];

        $stmt = $conn->prepare("SELECT * FROM post WHERE post_id = ?;");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $post_data = $stmt->get_result();
        
        $comments = array();

        $stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = ?;");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $comments_data = $stmt->get_result();

        if (!$post_data) {
            array_push($errors, "This select post query is wrong");
        } else {
            $stmt = $mysqli->prepare("SELECT * FROM user WHERE user_id = (SELECT author_id FROM post WHERE post_id = ?);");
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            $user_data = $stmt->get_result();
        }
        if (!$comments_data) {
            array_push($errors, "This select comments query is wrong");
        }
        if (!$user_data) {
            array_push($errors, "This select user query is wrong");
        }

        // If the user already logged in then check if he got bookmark this already or not
        if (isset($user)) {
            $stmt = $mysqli->prepare("SELECT * FROM bookmark WHERE post_id = ? AND user_id = ?;");
            $stmt->bind_param("ii", $post_id, $user['user_id']);
            $stmt->execute();
            $bookmark_data = $stmt->get_result();

            $stmt = $mysqli->prepare("SELECT * FROM `like` WHERE post_id = ? AND user_id = ?;");
            $stmt->bind_param("ii", $post_id, $user['user_id']);
            $stmt->execute();
            $like_data = $stmt->get_result();
        }

        if (!$bookmark_data)
            array_push($erros, "This select bookmark query is wrong");
        if (!$like_data)
            array_push($erros, "This select like query is wrong");

        if(count($errors) == 0) {
            $post_row = mysqli_fetch_assoc($post_data);
            $title = $post_row["post_name"];
            $image = $post_row["image_name"];
            $description = $post_row["post_description"];
            $noOfLikes = $post_row["number_of_likes"];
            $noOfComments = $post_row["number_of_comments"];
            // The user does not bookmark this page
            if(mysqli_num_rows($bookmark_data) == 0) {
                $isBookmarked = false;
            } else {
                $isBookmarked = true;
                $bookmark_row = mysqli_fetch_assoc($bookmark_data);
                $bookmark_id = $bookmark_row['bookmark_id'];
            }

            if(mysqli_num_rows($like_data) == 0) {
                $isPostLiked = false;
            } else {
                $isPostLiked = true;
                $like_row = mysqli_fetch_assoc($like_row);
                $like_id = $like_row['like_id'];
            }

            if(mysqli_num_rows($comments_data) > 0) {
                while ($comment_row = mysqli_fetch_assoc($comments_data)) {
                    $comments[] = array($comment_row['comment_id'], $comment_row['comment_id'], 
                    $comment_row['comment_id'], $comment_row['comment_id'], $comment_row['comment_id'], 
                    $comment_row['comment_id'], $comment_row['comment_id']);
                }
            }
        }

        $title = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
        $image = "https://i.imgur.com/AYk0AyG.png";
        $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tristique velit nec ultricies efficitur. Vivamus dapibus erat metus. Vivamus sed porta augue. Curabitur pharetra facilisis feugiat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse eu pellentesque mauris. Integer at nibh quam. Proin enim lectus, cursus non augue vel, suscipit tincidunt mi. Aliquam tempus gravida felis, non volutpat ligula consectetur id. Nullam eu sapien pulvinar, interdum eros nec, molestie dui. Cras a eros ac arcu consequat laoreet. In semper massa purus. Etiam lacinia quis tellus tempor venenatis. Suspendisse nec elit quis eros tristique interdum.

        Sed lacinia lacinia felis, quis ornare augue efficitur non. Cras sit amet nulla quis dolor commodo maximus dictum ut turpis. Ut feugiat leo ac posuere consequat. Maecenas iaculis auctor mi at congue. Etiam quis turpis id metus egestas imperdiet quis ac nibh. Praesent lacinia magna eget eros feugiat, feugiat tincidunt enim porta. Nulla ut libero rutrum, vestibulum lacus et, commodo eros. Quisque faucibus ex a nisl scelerisque rhoncus. Sed pharetra justo quis finibus porttitor. Sed urna odio, imperdiet vel turpis vitae, vestibulum ultrices arcu. Vestibulum ac turpis sed massa lobortis scelerisque. Duis et ante eget arcu tempus efficitur. Donec ac facilisis tellus, euismod tempor sem. Nulla faucibus odio blandit tellus eleifend, vitae tempor odio posuere. Aenean a scelerisque est, non lacinia odio. Ut lobortis sit amet lectus fringilla accumsan.";
        // ?? 0 returns 0 for null handling
        $noOfLikes = 3 ?? 0;
        $noOfComments = 10 ?? 0;
        $isPostLiked = true;
        $isBookmarked = true;
        $comments[] = array("cm0001", "https://picsum.photos/200", "comment author", "12/12/2022", "comment desc", true, 30);
        $comments[] = array("cm0002", "https://picsum.photos/200", "comment author 1", "12/12/2022", "comment desc 1", false, 10);
        $comments[] = array("cm0001", "https://picsum.photos/200", "comment author 2", "12/12/2022", "comment desc 2", true, 30);
        $authorName = "Lim";
        $authorImage = "https://picsum.photos/200";
        $createdAt = "12/2/2016";
    ?>
    <head>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/global.css" />
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include "components/header.php" ?>
        <?php include "components/sidebar.php" ?>
        <div class="page-container">
            <article class="post-header">
                <h2 class="post-title"><?php echo $title; ?></h2>
                <div class="post-author"><img class="post-author-image" src="<?php echo $authorImage ?>" /><?php echo $authorName ?>, <?php echo $createdAt ?></div>
                <img class="post-image" src="<?php echo $image; ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
                <p class="post-description"><?php echo $description; ?></p>
            </article>
            <section class="post-actions">
                <div class="post-action" onclick="window.alert('TODO: backend add like');">
                    <span class="post-action-icon <?php
                        if ($isPostLiked)
                            echo 'liked';
                    ?> fas fa-thumbs-up"></span>
                    <?php echo $noOfLikes; ?>
                </div>
                <div class="post-action" onclick="document.getElementById('post-comment-input').focus();">
                    <span class="post-action-icon fas fa-comments"></span>
                    <?php echo $noOfComments; ?>
                </div>
                <span style="flex: 1;"></span>
                <div class="post-action" style="margin-right: 0;" onclick="window.alert('TODO: backend add bookmark');">
                    <span class="post-action-icon <?php
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
                            $isCommentLked = $comment[5];
                            if ($isCommentLked)
                                $likedClassName = "liked";
                            else
                                $likedClassName = "";
                            echo '
                            <div class="post-comment">
                                <div class="post-author">
                                    <img class="post-author-image" src="'.$comment[1].'" />'.$comment[2].'
                                    <span style="flex: 1;"></span>
                                    <div style="font-size: small;">'.$comment[3].'</div>
                                </div>
                                <p class="post-comment-desc">'.$comment[4].'</p>
                                <div class="post-comment-actions">
                                    <div class="post-action" onclick="window.alert("TODO: backend add like");">
                                        <span class="post-action-icon '.$likedClassName.' fas fa-thumbs-up"></span>'.$comment[6].'
                                    </div>
                                </div>
                            </div>';
                        }
                ?>
            </section>
            <form class="post-comment-input">
                <textarea id="post-comment-input"></textarea>
                <span style="width: 1em;"></span>
                <div class="post-comment-send-button" onclick="window.alert('TODO: backend add comment');">
                    <span class="fas fa-arrow-right"></span>
                </div>
            </form>
        </div>
    </body>
</html>