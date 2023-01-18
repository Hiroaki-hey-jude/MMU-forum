<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/header.css" />
    <script src="https://kit.fontawesome.com/f019d50a29.js" crossorigin="anonymous"></script>
</head>
<body class="edit-profile-body">
	<?php 
		include 'includes/redirect.php';
		include "components/header.php"
	?>
	
    <div class="wrapper">
        <div class="edit-profile">
        <div class="profile-image">
            <h1>Profile</h1>
	    <img src="images/<?php echo $user['profile_pic_name']; ?>" class="rounded-profile-image" style="width:150px; object-fit:cover">
        </div>
        <form action="edit-profile.php" method="post" enctype="multipart/form-data">
            <div class="input-box">
                <label for="username" style="font-size: 1.2em;">Username</label>
		<input type="text" minlength="2" name="username" value="<?php echo $user['username'] ?>"> 
            </div>
            <div class="input-box">
                <label for="email" style="font-size: 1.2em;">Email Address</label>
		<input type="email" name="email" value="<?php echo $user['email'] ?>" disabled>
            </div>
            <div class="input-box">
                <label for="password1" style="font-size: 1.2em;">New Password</label>
                <!-- placeholder will be the user's infomation -->
                <input type="password" minlength="6" name="password1" placeholder="Optional">
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
                <input type="password" name="curr_password" placeholder="Enter current password to confirm">
            </div>
            <input type="submit" value="update profile" accept="images/*" name="edit" class="edit-profile-button">
        </form>
        </div>
    </div>
</body>
</html>

<?php

$errors = array();

if(isset($_GET['success'])) {
	echo '<script>alert("Successfully updated your profile!");</script>';
}

if(isset($_POST['edit'])){
	$curr_password = $_POST['curr_password'];
   	//$email = $_POST['email'];
 	$password1 = $_POST['password1'];
 	$password2 = $_POST['password2'];
	$username = $_POST['username'];
	$photo = $_FILES['photo']['name'];
	$target_dir = "images/";

	if(password_verify($curr_password, $user['user_pass'])){
		if(!empty($photo)){
			// file upload validation here
			$uploaded_ext = substr( $photo, strrpos( $photo, '.' ) + 1);
			$uploaded_size = $_FILES[ 'photo' ][ 'size'];
			$uploaded_type = $_FILES[ 'photo' ][ 'type'];
			// change filename to avoid collision and sensitive filename
			$target_file = md5( uniqid() . $photo ) . '.' . $uploaded_ext;
			// check file extension, size, type
			if( ( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) && ( $uploaded_size < 100000 ) && ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) ) {
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir . $target_file)) {
					echo "The file has been uploaded.";
				}
				else {
					array_push($errors, "Sorry, there was an error uploading your image.");
				}
				$filename = $target_file;
			}
			else {
				array_push($errors, "Edit failed! Your image was not accepted. We can only accept JPEG or PNG images.");
			}
		}
		else{
			$filename = $user['profile_pic_name'];
		}

		if(empty($password1) && empty($password2)){
			$new_password = $user['user_pass'];
		}
		else{
			if($password1 != $password2) {
				array_push($errors, "The two passwords do not match, your password is not changed!");
			}
			$new_password = password_hash($password1, PASSWORD_DEFAULT);
		}
	}
	else {
		array_push($errors, "Current password is incorrect");
	}

	if (count($errors) == 0) {
		$stmt = $conn->prepare("UPDATE user SET user_pass= ?, username= ?, profile_pic_name= ? WHERE user_id=?");
		$stmt->bind_param("sssi", $new_password, $username, $filename, $user['user_id']);
		$stmt->execute();
		echo '<script>window.location.href="edit-profile.php?success=true"</script>';
	}
}

include('errors.php');
?>

