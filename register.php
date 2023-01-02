<!DOCTYPE html> <html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register Form</title>

        <!-- css file -->
        <link rel="stylesheet" href="css/style.css">
</head>
<body>
        <div class="form-container">
                <form action="register.php" method="post">
                <img src="images/MMU-backgrou-transparent.png" class="login-register-img" alt="">
                        <h3>Register Now For the MMU Forum!</h3>
                        <input type="text" name="username" required placeholder="enter your name">
                        <input type="email" name="email" required placeholder="enter your email">
                        <input type="password" name="password1" required placeholder="enter your password">
                        <input type="password" name="password2" required placeholder="confirm your password">
                        <input type="submit" name="submit" class="reg-button">
                        <p>already have an account? <a href="login_form.php">login now</a></p>
                </form>
        </div>
</body>
</html>

<?php

// include this to connect to the database
include 'includes/conn.php';
$errors = array();

// Process POST data
if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if ($password1 != $password2) {
                array_push($errors, "The two passwords do not match");
        }

        // check duplicate entry
        $email_check_query = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $email_check_query->bind_param("s", $email);
        $email_check_query->execute();

        // get value
        $result = $email_check_query->get_result()->fetch_assoc();

        if ($result) {
                array_push($errors, "Email already exists");
        }

        // if no error
        if (count($errors) == 0) {
                $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("insert into users (username, email, password) values (?,?,?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                $stmt->execute();
                header('location: login.php');
        }
}

include('errors.php');
?>
