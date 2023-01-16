<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/header.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body class="profile-body">
<?php include "components/header.php" ?>
<div class="wrapper">
        <div class="profile">
        <div class="profile-image">
            <h1>Profile</h1>
	    <img src="images/<?php echo $user['profile_pic_name']; ?>" class="rounded-profile-image" style="width:150px; object-fit:cover">
        </div>
            <div class="profile-description">
                <div class="box">
                    <p class="label" style="font-size: 1.2em;">Username</p>
                    <!-- <label for="username" style="font-size: 1.2em;">Username</label> -->
                    <!-- <p><?php echo $user['username'] ?></p> -->
                    <p class="profile-data">Hiroaki Ueda</p>
                </div>
                <div class="box">
                <p class="label" style="font-size: 1.2em;">Email address</p>
                    <!-- <p><?php echo $user['username'] ?></p> -->
                    <p class="profile-data">1191302145@student.mmu.edu.my</p>
                </div>
                <div class="box">
                    <p class="label" style="font-size: 1.2em;">number of posts</p>
                    <!-- <p><?php echo $user['username'] ?></p> -->
                    <p class="profile-data">2</p>
                </div>
                <div class="box">
                    <p class="label" style="font-size: 1.2em;">number of comments</p>
                    <!-- <p><?php echo $user['username'] ?></p> -->
                    <p class="profile-data">3</p>
                </div>
            </div>
            <p>wanna edit profile data? <a href="edit-profile.php">edit now</a></p>
        </div>
    </div>
</body>
</html>