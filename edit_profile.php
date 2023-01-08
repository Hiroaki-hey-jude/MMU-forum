<?php

include 'includes/conn.php';
$errors = array();

if(isset($_POST['edit'])){
	$curr_password = $_POST['curr_password'];
   	//$email = $_POST['email'];
 	$password1 = $_POST['password1'];
 	$password2 = $_POST['password2'];
	$username = $_POST['username'];
	$photo = $_FILES['photo']['name'];
	
	if(password_verify($curr_password, $user['user_pass'])){
		if(!empty($photo)){
			// file upload validation here
			$uploaded_ext = substr( $photo, strrpos( $photo, '.' ) + 1);
			$uploaded_size = $_FILES[ 'photo' ][ 'size'];
			$uploaded_type = $_FILES[ 'photo' ][ 'type'];
			// change file name to avoid collision
			$target_file = md5( uniqid() . $photo ) . '.' . $uploaded_ext;
			// check file extension, size, type
			if( ( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) && ( $uploaded_size < 100000 ) && ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) ) {
				move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$target_file);
				$filename = $target_file;
			}
			else {
				array_push($errors, "Edit failed! Your image was not accepted. We can only accept JPEG or PNG images.");
			}
		}
		else{
			$filename = $user['profile_pic_name'];
		}

		if(empty($password1) && empty($password2){
			$password = $user['user_pass'];
		}
		else{
			if($password1 != $password2) {
				array_push($errors, "The two passwords do not match");
			}
			$password = password_hash($password1, PASSWORD_DEFAULT);
		}
	}
	else {
		array_push($errors, "Current password is incorrect");
	}

	if (count($errors) == 0) {
		$stmt = $conn->prepare("UPDATE users SET user_pass=:password, username=:username, profile_pic_name=:photo WHERE user_id=:id");
		$stmt->execute(['password'=>$password, 'username'=>$username, 'photo'=>$filename, 'id'=>$user['id']]);
	}
}

include('errors.php');
?>
