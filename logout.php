<?php
$errors = array();
include 'includes/session.php';
    if(isset($user)) {
        session_destroy();
    }
    header("Location: login.php");
    include 'errors.php';
    exit;
?>