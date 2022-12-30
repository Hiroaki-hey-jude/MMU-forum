<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
        <form action="login.php" method="post">
        <img src="images/MMU-backgrou-transparent.png" class="login-register-img" alt="">
            <h3>Login Now For the MMU Forum!</h3>
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="submit" value="Login now" class="reg-button">
            <p>don't have an account? <a href="register_form.php">register now</a></p>
            <?php
                if(isset($_GET['error']) && $_GET['error'] == 'invalidUser') {
                echo "<div class = 'login-failed'>Log in failed. Please check your email or password</div>";
                }
            ?>
        </form>
    </div>
</body>
</html>