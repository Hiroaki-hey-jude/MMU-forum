<?php

$conn = mysqli_connect('localhost', 'root', 'root', 'forum');

if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
}
?>
