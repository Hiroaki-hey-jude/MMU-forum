<?php

include 'includes/conn.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    
    $loginEntry = $conn->prepare("SELECT * from users WHERE email = ?");
    $loginEntry->bind_param("s", $email);
    $loginEntry->execute();
    
    $result = $loginEntry->get_result();
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    if(password_verify($password,$hashed_password)) {
        echo "The user is exist <br>";
        session_start();
        echo "ID: " . $row['id'] . "<br>";
        echo "Username: " . $row['username'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Password : " . $row['password'] . "<br>";
        echo "<h2> Here will show homepage with logged in details and established session</h2>";
        $_SESSION['userid'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['userrole'] = 'user';
        // direct to home page 
        exit;
    } else {
        // Go back to the login page and show erry
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=invalidUser");
        exit;
    }
}

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
            <?php
                if(isset($_GET['error']) && $_GET['error'] == 'invalidUser') {
                echo "<div class = 'login-failed'>Log in failed. Please check your email or password</div>";
                }
            ?>
        </form>
    </div>
</body>
</html>

