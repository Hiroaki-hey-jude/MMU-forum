<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- css file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
        <img src="images/MMU-backgrou-transparent.png" class="login-register-img" alt="">
            <h3>Register Now For the MMU Forum!</h3>
            <input type="text" name="name" required placeholder="enter your name">
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="password" name="cpassword" required placeholder="confirm your password">
            <input type="submit" value="register now" class="reg-button">
            <p>already have an account? <a href="login_form.php">login now</a></p>
        </form>
    </div>
</body>
</html>