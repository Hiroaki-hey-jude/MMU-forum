<?php
$errors = array();
include 'includes/session.php';
    if(isset($user) || isset($admin)) {
        session_destroy();
    }
    header("Location: login.php");
    exit;
?>