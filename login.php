<?php

include 'includes/conn.php';

$email = $_POST['email'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$login = $conn->prepare("SELECT * from users WHERE email = ? AND password = ?");
$login->bind_param("ss", $email, $hashed_password);
$login->execute();

$result = $login->get_result();

if(mysqli_num_rows($result) > 0) {
    echo "The user is exist <br>";
    session_start();
    if($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . "<br>";
        echo "Username: " . $row['username'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Password : " . $row['password'] . "<br>";
        echo "<h2> Here will show homepage with logged in details and established session</h2>";
        $_SESSION['userid'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['userrole'] = 'user';
      }
} else {
    // Go back to the login page and show erry
    header('Location: login_form.php?error=invalidUser') ;
    exit;
}

?>