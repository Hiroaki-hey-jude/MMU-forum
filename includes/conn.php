<?php

$conn = mysqli_connect('localhost', 'forum_dev', 'forum_devpass', 'forum');

if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
}
?>
