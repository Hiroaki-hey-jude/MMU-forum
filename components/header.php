<!DOCTYPE html>
<html>

<?php
    // The session file need to be included before the header.php
    // include "includes/session.php";
    if (isset($user)) {
        $user_data = array($user['user_id'], $user['username'], "images/".$user['profile_pic_name']);
    } else {
        $user_data = array("-1", "Guest");
    }

?>

<head>
    <link rel="stylesheet" href="css/header.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<!-- TODO:
    - reponsive header
    - login and sign in button
-->
<body>
    <div class="header-div"></div>
    <header class="primary-background">
        <a id="header-title" href="home.php">
            <img id="header-image" src="images/MMU.png" height="30px" />
            <span class="header-span"></span>
            MMU Forum
        </a>
        <span class="header-span"></span>
        <span class="header-span"></span>
        <form id="header-search-bar-form" class="search-bar" action="post-list.php">
            <input id="header-search-bar" class="search-input" type="text" name="search" placeholder="Search for post"/>
            <!-- TODO: add search feature -->
            <a onclick="document.getElementById('header-search-bar-form').submit();"><span class="fas fa-search search-icon"></span></a>
        </form>
        <span style="flex: 1;"></span>
        <?php
            if (isset($user) && $user_data[2]) {
                echo '<a class="header-user" href="edit-profile.php"><img src="'. $user_data[2] .'" class="header-user" /></a>';
            } else {
                echo '<a class="header-user" href="edit-profile.php"><span class="fas fa-user header-user-icon"></span></a>';
            }
        ?>
        <span class="header-span"></span>
        <div class="header-user-name"><?php echo $user_data[1]; ?></div>
        
    </header>
</body>

</html>