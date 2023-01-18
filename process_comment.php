<?php
include "includes/conn.php";
    
$errors = array();
if(isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['comment'])) {
    $user_id = $_POST['user_id'];
    $post_id = $_POST['post_id'];
    $comment_description = $_POST['comment'];
    $query_insert_comment = $conn->prepare("INSERT INTO comment (commenter_id, post_id, comment_description) VALUES (?,?,?);");
    $query_insert_comment->bind_param("iis", $user_id, $post_id, $comment_description);
    if($query_insert_comment->execute()){
        echo 'success';
    } else {
        echo 'error';
    }
    
} else {

}

include 'errors.php';
?>