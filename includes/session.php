<?php
	include 'includes/conn.php';
	session_start();
	
	if(isset($_SESSION['admin'])){
		try { 
			$stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id= ?");
			$stmt->bind_param("i", $_SESSION['admin']);
			$stmt->execute();

			$admin = $stmt->get_result()->fetch_assoc();
		}
		catch(PDOException $e) {
			echo "There is some problem in connection: " . $e->getMessage();
		}
	}

	if(isset($_SESSION['user'])) {
		try{
			$stmt = $conn->prepare("SELECT * FROM user WHERE user_id= ?");
			$stmt->bind_param("i", $_SESSION['user']);
			$stmt->execute();

			$user = $stmt->get_result()->fetch_assoc();
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}
	}
?>
