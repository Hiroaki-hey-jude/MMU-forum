<?php
include "includes/conn.php";
    
$errors = array();
if(isset($_POST['post_id']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $post_id = $_POST['post_id'];

    $query_get_boomark = "SELECT * FROM `bookmark` WHERE user_id = " . $user_id . " AND post_id = " . $post_id . ";";
    $bookmark_data = mysqli_query($conn, $query_get_boomark);

    if(!$bookmark_data) {
        echo 'error2';
    } else if (mysqli_num_rows($bookmark_data) > 0){
        $bookmark_row = mysqli_fetch_assoc($bookmark_data);
        $query_delete_like = "DELETE FROM `bookmark` WHERE bookmark_id =" .$bookmark_row['bookmark_id']. ";";
        if (mysqli_query($conn, $query_delete_like)) {
            echo 'unbookmark';
        } else {
            echo 'error';
        }
    } else {
        $query_insert_bookmark = "INSERT INTO `bookmark` (user_id, post_id) VALUES (" . $user_id . "," . $post_id . ");";
        if(mysqli_query($conn,$query_insert_bookmark)){
            echo 'success';
        } else {
            echo 'error';
        }
    }

    
}

include 'errors.php';
?>