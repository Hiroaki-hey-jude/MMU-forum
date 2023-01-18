<?php

include 'includes/session.php';
// include 'includes/conn.php'; // for testing use, use this when you want to try different user without session
$errors = array();

if (isset($user)) {
    array_push($errors, "You already logged in");
    header("Location: home.php");
}
if (isset($_GET['register'])) {
	echo '<script>alert("Registration completed! Please login to continue");</script>';
}
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; 
    
    $loginEntry = $conn->prepare("SELECT * from user WHERE email = ?");
    $loginEntry->bind_param("s", $email);
    $loginEntry->execute();
    
    $result = $loginEntry->get_result();
    if(mysqli_num_rows($result) == 0 || !$result) {
        array_push($errors, "Log in failed. This user (email) does not exists");
    }
    else {
        $row = $result->fetch_assoc();
        $hashed_password = $row['user_pass'];
        if(password_verify($password,$hashed_password)) {
            session_start();
            $_SESSION['user'] = $row['user_id'];
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
        <form action = "login.php" method="post">
        <img src="images/MMU-backgrou-transparent.png" class="login-register-img" alt="">
            <h3>Login Now For the MMU Forum!</h3>
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="submit" name = "submit" value="Login now" class="reg-button">
            <p>don't have an account? <a href="register.php">register now</a></p>
        </form>
    </div>
</body>
</html>

