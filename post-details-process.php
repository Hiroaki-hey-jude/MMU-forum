<?php
    include 'includes/session.php';
    $errors = array();
    $posts = array();
    if(isset($_GET['post'])) {
        $post_id = $_GET['post'];
        $query_get_to_get_post_details = "SELECT * FROM post 
                    WHERE `post_id` = ". $post_id. ";";
        $post_details_result = mysqli_query($conn, $query_get_to_get_post_details);
        if(mysqli_num_rows($post_details_result) == 0 || !$post_details_result) {
            array_push($errors, "This post does not exist"); 
        } else {
            $post_row = mysqli_fetch_assoc($post_details_result);
            
            $query_to_get_author_name = "SELECT username FROM user WHERE user_id = " . $post_row['author_id'] . ";";
            $author_name_data = mysqli_query($conn, $query_to_get_author_name);
            
            if(mysqli_num_rows($author_name_data) == 0)  
                array_push($errors, "Cannot get author name, user_id = " . $row['author_id'] . " doesn't exist in user table");
            else {
                $user_row = mysqli_fetch_assoc($author_name_data);
                $author_name = $user_row['username'];
            }

            $details[] = array(
                $row['post_id'], $row['post_name'], $row['number_of_likes'], $row['number_of_comments'],
                $author_name, $row['created_at'], false);
        }
    }
    include 'errors.php';
?>