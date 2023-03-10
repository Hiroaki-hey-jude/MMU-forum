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
                <form name="form" action="register.php" method="post">
                <img src="images/MMU-backgrou-transparent.png" class="login-register-img" alt="">
                        <h3>Register Now For the MMU Forum!</h3>
                        <input type="text" name="username" minlength="2" required placeholder="enter your name">
                        <input type="email" name="email" required placeholder="enter your email">
                        <input type="password" name="password1" required placeholder="enter your password" pattern="[A-Za-z]{7,14}">
                        <input type="password" name="password2" required placeholder="confirm your password">
                        <input type="submit" name="submit" class="reg-button" onclick="CheckPassword(document.form.password1)">
                        <p>already have an account? <a href="login.php">login now</a></p>
                        <p>or</p>
                        <p><a href="home.php">continue as a guest</a></p>
                </form>
        </div>
</body>
<script>
function CheckPassword(inputtxt) 
{ 
        var passw=/^[A-Za-z]\w{7,14}$/;
        if(!inputtxt.value.match(passw)) 
        { 
            alert('7 to 15 characters which contain only characters')
            return false;
        }
}
</script>
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
        $email_check_query = $conn->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
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
                $stmt = $conn->prepare("insert into user (username, email, user_pass) values (?,?,?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                $stmt->execute();
                header('location: login.php?register=true');
        }
}

include('errors.php');
?>
