<!DOCTYPE html>
<html>

<?php
    include 'includes/session.php';
    $errors = array();

    $category_table_data = array();
    $query_get_all_categories = "SELECT * FROM category;";
    $category_result = mysqli_query($conn, $query_get_all_categories);

    $subcategory_table_data = array();
    $query_get_all_subcategories = "SELECT * FROM subcategory;";
    $subcategory_result = mysqli_query($conn, $query_get_all_subcategories);
    
    $recentPosts = array();
    $query_get_recent_5_posts = "SELECT * FROM post ORDER BY created_at DESC LIMIT 5;";
    $recent_posts_result = mysqli_query($conn, $query_get_recent_5_posts);
    
    $bookmarked_posts = array();
    if(isset ($user)) {
        $query_get_bookmark = $conn->prepare("SELECT * FROM post WHERE post_id IN 
                (SELECT `post_id` FROM bookmark WHERE user_id = ?);");
        $query_get_bookmark->bind_param("i", $user["user_id"]);
        $query_get_bookmark->execute();
        $bookmark_data = $query_get_bookmark->get_result();
        // $query_get_bookmark = "SELECT * FROM post WHERE post_id IN (SELECT `post_id` FROM bookmark
        //         WHERE user_id = ". $user['user_id']. ");";
        // $bookmark_data = mysqli_query($conn, $query_get_bookmark);
    }

    if(!$recent_posts_result) {
        array_push($errors, "Cannot select latest 5 data");
    }
    if(!$subcategory_result) {
        array_push($errors, "Cannot select subcategory from table");
    }
    if(!$category_result) {
        array_push($errors, "Cannot select category from table");
    }
    if(!$bookmark_data) {
        array_push($errors, "Cannot select bookmark from table");
    }

    // If there is no error
    if (count($errors) == 0) {
        // get those data from tables
        while ($row = mysqli_fetch_assoc($category_result)) {
            $category_table_data[] = $row;
        }
        while ($row = mysqli_fetch_assoc($subcategory_result)) {
            $subcategory_table_data[] = $row;
        }
        // populate the data into $categories array
        for ($i = 0; $i < count($category_table_data); $i++) {
            $subcategories = array();
            for($j = 0; $j < count($subcategory_table_data); $j++) {
                if($category_table_data[$i]['category_id'] == $subcategory_table_data[$j]['category_id']) {
                    $subcategories[] = array(
                        $subcategory_table_data[$j]['subcategory_id'], 
                        $subcategory_table_data[$j]['subcategory_name'],
                        $subcategory_table_data[$j]['number_of_posts'],
                        $subcategory_table_data[$j]['number_of_comments']
                    );
                }
            } 
            $categories[] = array(
                $category_table_data[$i]['category_id'] , $category_table_data[$i]['category_name'], $subcategories
            );
        }
        
        // get all 5 recent post
        while($row = mysqli_fetch_assoc($recent_posts_result)) {
            $query_to_get_author_name = "SELECT username FROM user WHERE user_id = " . $row['author_id'] . ";";
            // $query_to_get_author_name = "SELECT username FROM user WHERE user_id = 300;";
            $author_name_data = mysqli_query($conn, $query_to_get_author_name);
            if(mysqli_num_rows($author_name_data) == 0)  {
                array_push($errors, "Cannot get author name, user_id = " . $row['author_id'] . " doesn't exist in user table");
                break;
            }
            $user_row = mysqli_fetch_assoc($author_name_data);
            $author_name = $user_row['username'];
            $recentPosts[] = array($row['post_id'], $row['post_name'] , $row['number_of_likes']
                                    , $row['number_of_comments'], $author_name);
        }

        // get all bookmark posts
        $limit = 5;
        $i = 0;
        while($row = mysqli_fetch_assoc($bookmark_data)) {
            if($i == $limit) {
                break;
            }
            $query_to_get_author_name = "SELECT username FROM user WHERE user_id = " . $row['user_id'] . ";";
            $author_name_data = mysqli_query($conn, $query_to_get_author_name);
            if(mysqli_num_rows($author_name_data) == 0)  {
                array_push($errors, "Cannot get author name, user_id = " . $row['author_id'] . " doesn't exist in user table");
                break;
            }
            $user_row = mysqli_fetch_assoc($author_name_data);
            $author_name = $user_row['username'];
            $bookmarked_posts[] = array($row['post_id'], $row['post_name'],
                        $row['number_of_likes'], $row['number_of_comments'], true);
            $i++;
        }
    }
    
    // $bookmarked_posts[] = array("p0001", "Online Week", 3, 10, "Lim", "12/12/2022", false);
    // if the user already logged in
    include 'errors.php';
?>

<head lang="en">
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/home.css" />
</head>

<body>
    <?php include "components/header.php" ?>
    <?php include "components/sidebar.php" ?>
    <aside id="right-pane">
        <div class="post-list recent-list">
            <div class="list-title">
                Recent Posts
                <a class="view-all" href="post-list.php?type=recent">View All</a>
            </div>
            <?php
                if (count($recentPosts) === 0)
                    include 'components/placeholder.php';
                else
                    foreach($recentPosts as $post)
                        $post_item_type = "post";
                        $post_item_href = "post-details.php?id=".$post[0];
                        $post_item_title = $post[1];
                        $post_item_noOfLikes = $post[2];
                        $post_item_noOfComments = $post[3];
                        $post_item_author = $post[4];
                        include "components/post-item.php";
            ?>
        </div>
        <div class="post-list bookmark-list">
            <div class="list-title bookmark-title">
                Bookmarked Posts
                <a class="view-all" href="post-list.php?type=bookmark">View All</a>
            </div>
            <?php
                if (count($bookmarked_posts) === 0)
                    include 'components/placeholder.php';
                else 
                    foreach($bookmarked_posts as $post){
                        $post_item_type = "post";
                        $post_item_href = "post-details.php?id=".$post[0];
                        $post_item_title = $post[1];
                        $post_item_noOfLikes = $post[2];
                        $post_item_noOfComments = $post[3];
                        $post_item_bookmarked = $post[4];
                        include "components/post-item.php";
                    }
            ?>
        </div>
    </aside>
    <div id="home-container" class="page-container">
        <?php
            if (count($categories) === 0)
                include 'components/placeholder.php';
            else
                foreach ($categories as $category) {
                    echo '
                        <div class="post-list">
                            <div class="list-title">
                                '.$category[1].'
                                <a class="view-all" href="post-list.php?id='.$category[0].'&type=category">View All</a>
                            </div>
                    ';
                    if (empty($category[2])) 
                        include 'components/placeholder.php';
                    else if (count($category[2]) === 0) 
                        include 'components/placeholder.php';
                    else
                        foreach($category[2] as $subcategory){
                            $post_item_type = "subcategory";
                            $post_item_href = "post-list.php?id=".$subcategory[0]."&type=subcategory";
                            $post_item_title = $subcategory[1];
                            $post_item_noOfPosts = $subcategory[2];
                            $post_item_noOfComments = $subcategory[3];
                            include "components/post-item.php";
                        }
                    
                    echo '
                        </div>
                    ';
                };
        ?>
        
    </div>
</body>

</html>