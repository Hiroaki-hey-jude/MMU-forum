<?php
include "includes/session.php";
include "includes/permission.php";
include "includes/conn.php";
$errors = array();
if (isset($admin)) {
    if(isset($_GET['id'])) {
        $post_id = $_GET['id'];
        $query_delete_post = $conn->prepare("DELETE FROM post WHERE post_id = ?");
        $query_delete_post->bind_param("i", $post_id);
        if ($query_delete_post->execute()) {
            echo "<script>alert('Delete post ".$post_id." sucessfully');</script>";
            header("Location: {$_SERVER['HTTP_REFERER']}");
        } else {
            echo "<script>alert('Cannot execute delete post query');</script>";
        }
    }
} 
else {
    array_push($errors, "You have no privilege");
}
include 'errors.php';

?>

