<?php
	include 'includes/conn.php';
	session_start();
	
	// admin session for future
	//if(isset($_SESSION['admin'])){
	//	header('location: admin/home.php');
	//}

	if(isset($_SESSION['user'])) {
		try{
			$stmt = $conn->prepare("SELECT * FROM users WHERE id= ?");
			$stmt->bind_param("i", $_SESSION['user']);
			$stmt->execute();

			$user = $stmt->get_result()->fetch_assoc();
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

		mysqli_close($conn);
	}
?>
