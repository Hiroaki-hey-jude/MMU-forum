<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Edit Profile</h2>
        <form action="" method="post">
            <div class="input-box">
                <label for="username">User Name</label>
                <input type="text" name="username">
            </div>
            <div class="input-box">
                <label for="email">Email</label>
                <input type="email" name="email">
            </div>
            <div class="input-box">
                <label for="photo">profile picture</label>
                <input type="file" name="photo">
            </div>
            <input type="submit" accept="images/*" name="submit" class="edit-profile-button">
        </form>
    </div>
</body>
</html>