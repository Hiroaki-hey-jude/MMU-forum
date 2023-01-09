<?php

include 'includes/conn.php';
$errors = array();
session_start();
include 'includes/session.php';

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
	}
}

include('errors.php');
?>
