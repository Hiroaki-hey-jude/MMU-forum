<?php

$conn = mysqli_connect('110.238.105.156', 'forum_dev', 'forum_devpass', 'forum');

if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
}
?>
