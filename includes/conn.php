<?php

$conn = mysqli_connect('127.0.0.1', 'forum_dev', 'forum_devpass', 'forum');

if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
}
?>
