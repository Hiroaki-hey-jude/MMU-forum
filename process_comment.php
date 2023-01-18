<?php
include "includes/conn.php";
    
$errors = array();
if(isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['comment'])) {
    $user_id = $_POST['user_id'];
    $post_id = $_POST['post_id'];
    $comment_description = $_POST['comment'];
    $query_insert_comment = "INSERT INTO comment (commenter_id, post_id, comment_description) VALUES (
        ".$user_id.",".$post_id.", '".$comment_description."');";
    if(mysqli_query($conn, $query_insert_comment)){
        echo 'success';
    } else {
        echo 'error';
    }
    
} else {

}

include 'errors.php';
?>