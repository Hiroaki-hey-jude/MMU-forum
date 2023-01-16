<!DOCTYPE html>
<html>

<?php
    include 'includes/session.php';
    $errors = array();

    $category_table_data = array();
    $query_get_all_categories = "SELECT * FROM category;";
    $category_result = mysqli_query($conn, $query_get_all_categories);

    if(!$category_result) {
        array_push($errors, "Cannot select category from table");
    }
    
    $subcategory_table_data = array();
    $query_get_all_subcategories = "SELECT * FROM subcategory;";
    $subcategory_result = mysqli_query($conn, $query_get_all_subcategories);
    
    if(!$subcategory_result) {
        array_push($errors, "Cannot select subcategory from table");
    }
    
    $recentPosts = array();
    $query_get_recent_5_posts = "SELECT * FROM post ORDER BY created_at DESC LIMIT 5;";
    $recent_posts_result = mysqli_query($conn, $query_get_recent_5_posts);

    if(!$recent_posts_result) {
        array_push($errors, "Cannot select latest 5 data");
    }

    // If there is no error
    if (count($errors) == 0) {
        // get those data from tables
        while ($row = mysqli_fetch_assoc($category_result)) {
            $category_table_data[] = $row;
            // echo "safdfffffffffffffffffffffffffffffffffffffffffffffff sdfsdf    " . $category_table_data[0]['category_id'];
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
    }
    
    // $bookmarkedPosts[] = array("p0001", "Online Week", 3, 10, "Lim", "12/12/2022", false);
    // if the user already logged in
    $bookmarked_posts = array();
    if(isset ($user)) {
        $query_get_bookmark = "SELECT * FROM post WHERE post_id IN (SELECT `post_id` FROM bookmark
                WHERE user_id = ". $user['user_id']. ");";
        $bookmark_data = mysqli_query($conn, $query_get_bookmark);
        if($bookmark_data || mysqli_num_rows($bookmark_data) > 0) {
            $limit = 5;
            $i = 0;
            while($row = mysqli_fetch_assoc($bookmark_data)) {
                if($i == $limit) {
                    break;
                }
                $bookmarked_posts[] = array($row['post_id'], $row['post_name'],
                            $row['number_of_likes'], $row['number_of_comments'], true);
                $i++;
            }

        }
    }
    include 'errors.php';
?>

<head lang="en">
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/home.css" />
    <script src="components/post-item.js"></script>
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
                if (empty($recentPosts))
                    include 'components/placeholder.php';
                else
                    foreach($recentPosts as $post)
                        echo '
                            <post-item
                                type="post"
                                href="post-details.php?id='.$post[0].'"
                                title="'.$post[1].'"
                                likes="'.$post[2].'"
                                comments="'.$post[3].'"
                                author="'.$post[4].'"
                            />';
            ?>
        </div>
        <div class="post-list bookmark-list">
            <div class="list-title bookmark-title">
                Bookmarked Posts
                <a class="view-all" href="post-list.php?type=bookmark">View All</a>
            </div>
            <?php
                if (empty($bookmarkedPosts))
                    include 'components/placeholder.php';
                else 
                    foreach($bookmarkedPosts as $post){
                        echo '
                            <post-item
                                type="post"
                                href="post-details.php?id='.$post[0].'"
                                title="'.$post[1].'"
                                posts="'.$post[2].'"
                                comments="'.$post[3].'"
                            />';
                    }
            ?>
        </div>
    </aside>
    <div id="home-container" class="page-container">
        <?php
            if (empty($categories))
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
                    else
                        foreach($category[2] as $subcategory){
                            echo '
                                <post-item
                                    type="subcategory"
                                    href="post-list.php?id='.$subcategory[0].'&type=subcategory" 
                                    title="'.$subcategory[1].'"
                                    posts="'.$subcategory[2].'"
                                    comments="'.$subcategory[3].'"
                                />';
                        }
                    
                    echo '
                        </div>
                    ';
                };
        ?>
        
    </div>
</body>

</html>