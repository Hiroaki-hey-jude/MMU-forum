<!DOCTYPE html>
<html>
    <?php
        include 'includes/conn.php';
        $errors = array();
        session_start();
        include 'includes/session.php';

        $posts = array();
        if(isset($_GET['subcategory'])) {
            $subcategory_id = $_GET['subcategory'];
            $query_get_to_get_post_list = "SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                         `number_of_comments`, `number_of_likes` FROM post 
                        WHERE `subcategory_id` = ".$subcategory_id.";";
            $post_list_result = mysqli_query($conn, $query_get_to_get_post_list);
            if(mysqli_num_rows($post_list_result) == 0 || !$post_list_result) {
                array_push($errors, "The post list for this subcategory is empty or query is wrong"); 
            } else {
                
                while($row = mysqli_fetch_assoc($post_list_result)) {
                    $query_to_get_author_name = "SELECT username FROM user WHERE user_id = " . $row['author_id'] . ";";
                    // $query_to_get_author_name = "SELECT username FROM user WHERE user_id = 300;";
                    $author_name_data = mysqli_query($conn, $query_to_get_author_name);
                    if(mysqli_num_rows($author_name_data) == 0)  {
                        array_push($errors, "Cannot get author name, user_id = " . $row['author_id'] . " doesn't exist in user table");
                        echo "ssssssssssssssd\n\n\nsaaaaaaaaa\n\n\nerror";
                        break;
                    }
                    $user_row = mysqli_fetch_assoc($author_name_data);
                    $author_name = $user_row['username'];
                    $posts[] = array(
                        $row['post_id'], $row['post_name'], $row['number_of_likes'], $row['number_of_comments'],
                        $author_name, $row['created_at']);
                }
            }
        }
        // $posts[] = array("p0000", "Announcement", 3, 10, "Lim", "12/12/2022", true);
        // $posts[] = array("p0001", "Online Week", 3, 10, "Lim", "12/12/2022", false);
        include('errors.php');
    ?>
    <head>
        <link rel="stylesheet" link="css/reset.css" />
        <link rel="stylesheet" link="css/global.css" />
    </head>
    <body>
        <?php include "components/header.php" ?>
        <a href="home.php">home</a>
        <div class="post-list">
            <div class="list-title primary-background">
                Result
            </div>
            <?php
                foreach($posts as $item){
                    echo '
                        <post-item
                            href="post-details.php?id='.$item[0].'" 
                            title="'.$item[1].'" 
                            likes="'.$item[2].'" 
                            comments="'.$item[3].'" 
                            author="'.$item[4].'" 
                            createdAt="'.$item[5].'" 
                            />';
                }
            ?>
        </div>
    </body>
</html>