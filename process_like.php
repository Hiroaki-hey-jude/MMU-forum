<?php
    include 'includes/redirect.php';
    $errors = array();
    if(isset($_POST['post_id']) && isset($_POST['user_id'])) {
        $post_id = $_POST['post_id'];
        if(isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
        } else {
            $comment_id = 0;
        }

        if($comment_id == 0) {
            $query_insert_like = "INSERT INTO `like` (user_id, post_id) VALUES (" . $user_id . "," . $post_id . ");";
        } else {
            $query_insert_like = "INSERT INTO `like` (user_id, post_id, comment_id) VALUES 
                                (" . $user_id . "," . $post_id . " " . $comment_id .");";
        }
    } else if(!isset($_POST['user_id'])) {
        // if the user is not logged in, redirect to homepage
        echo "Redirect to home page, not logged in";
    }

?>