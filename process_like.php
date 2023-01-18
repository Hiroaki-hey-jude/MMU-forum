<?php
    // echo 'error';
    include "includes/conn.php";
    
    $errors = array();
    if(isset($_POST['post_id']) && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        $post_id = $_POST['post_id'];
        
        // check if comment_id is passed into here
        if(isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
        } else {
            $comment_id = 0;
        }

        // check if the user already like this thing 
        if($comment_id == 0) {
            // $query_get_like = $conn->prepare("SELECT * FROM `like` WHERE 
            //                     user_id = ? AND post_id = ? AND comment_id IS NULL) ;");
            // $query_get_like->bind_param("ii", $user_id, $post_id);
            $query_get_like = "SELECT * FROM `like` WHERE user_id = " . $user_id . " AND post_id = " . $post_id. " AND
                                comment_id IS NULL ;";
        } else {
            // $query_get_like = $conn->prepare("SELECT * FROM `like` WHERE
                        // user_id = ? AND post_id = ?, comment_id = ?);");
            // $query_get_like->bind_param("iii", $user_id, $post_id, $comment_id);
            $query_get_like = "SELECT * FROM `like` WHERE user_id = " .$user_id . " AND post_id = " . $post_id .
                                " AND comment_id = " .$comment_id;           
        }

        $like_data = mysqli_query($conn, $query_get_like);

        if(!$like_data) {
            echo 'error2';
        } else if (mysqli_num_rows($like_data) > 0){
            // if the user already like this thing, then delete it from database
            echo 'unlike';
            $like_row = mysqli_fetch_assoc($like_data);
            $query_delete_like = "DELETE FROM `like` WHERE `like_id` =" .$like_row['like_id']. ";";
            mysqli_query($conn,$query_delete_like);
        } else {
            // if the comment_id is 0, mean the user is liking a post
            if($comment_id == 0) {
                $query_insert_like = "INSERT INTO `like` (user_id, post_id) VALUES (" . $user_id . "," . $post_id . ");";
                // $query_insert_like = $conn->prepare("INSERT INTO `like` (user_id, post_id) VALUES (?,?);");
                // $query_insert_like->bind_param("ii", $user_id, $post_id);
            } else {
                $query_insert_like = "INSERT INTO `like` (user_id, post_id, comment_id) VALUES 
                                     (" . $user_id . "," . $post_id . "," . $comment_id .");";
                // $query_insert_like = $conn->prepare("INSERT INTO `like` (user_id, post_id, comment_id) VALUES (?,?,?);");
                // $query_insert_like->bind_param("iii", $user_id, $post_id, $comment_id);
            }
            
            // execute the query
            if(mysqli_query($conn,$query_insert_like)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    } else {

    }

    include 'errors.php';
?>