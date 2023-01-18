<?php

include 'includes/session.php';
$errors = array();

if (isset($admin)) {
    header("Location: home.php");
}
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; 
    
    $loginEntry = $conn->prepare("SELECT * from admin WHERE email = ?");
    $loginEntry->bind_param("s", $email);
    $loginEntry->execute();
    
    $result = $loginEntry->get_result();
    if(mysqli_num_rows($result) == 0 || !$result) {
        array_push($errors, "Log in failed. This admin (email) does not exists");
    }
    else {
        $row = $result->fetch_assoc();
        $retrieved_password = $row['admin_pass'];
        if($password === $retrieved_password) {
            session_start();
            $_SESSION['admin'] = $row['admin_id'];
            // direct to home page 
            header("Location: home.php");
            exit;
        } else {
            array_push($errors, "Log in failed. Please check your password");
        }
    }
}
include "errors.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
        <form action = "admin-login.php" method="post">
        <img src="images/MMU-backgrou-transparent.png" class="login-register-img" alt="">
            <h3>MMU Admin Panel</h3>
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="submit" name = "submit" value="Login now" class="reg-button">
        </form>
    </div>
</body>
</html>

