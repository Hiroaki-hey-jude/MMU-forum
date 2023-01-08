<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="edit-profile-body">
	<?php 
        	session_start();
		include 'includes/session.php'; 
		if (!isset($_SESSION['user'])) {
			header('location: login.php');
		}
	?>
	
    <div class="wrapper">
        <div class="edit-profile">
        <div class="profile-image">
            <h1>Profile</h1>
            <img src="images/c++.png" class="rounded-profile-image" style="width:150px; object-fit:cover">
        </div>
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
            <div class="input-box">
                <label for="username" style="font-size: 1.2em;">Username</label>
		<input type="text" name="username" value="<?php echo $user['username'] ?>"> 
            </div>
            <div class="input-box">
                <label for="email" style="font-size: 1.2em;">Email Address</label>
		<input type="email" name="email" value="<?php echo $user['email'] ?>">
            </div>
            <div class="input-box">
                <label for="password1" style="font-size: 1.2em;">New Password</label>
                <!-- placeholder will be the user's infomation -->
                <input type="password" name="password1" placeholder="Optional">
            </div>
            <div class="input-box">
                <label for="password2" style="font-size: 1.2em;">Confirm New Password</label>
                <!-- placeholder will be the user's infomation -->
                <input type="password" name="password2" placeholder="Optional">
            </div>
            <div class="input-box">
                <label for="photo" style="font-size: 1.2em;">Profile Picture</label>
                <input type="file" name="photo">
            </div>
            <div class="input-box">
                <label for="password1" style="font-size: 1.2em;">Current Password</label>
                <!-- placeholder will be the user's infomation -->
                <input type="password" name="password" placeholder="Enter current password to confirm">
            </div>
            <input type="submit" value="update profile" accept="images/*" name="submit" class="edit-profile-button">
        </form>
        </div>
    </div>
</body>
</html>

