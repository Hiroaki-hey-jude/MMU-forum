<!DOCTYPE html>
<html>

<?php
    // The session file need to be included before the header.php
    // include "includes/session.php";
    if (isset($user)) {
        $user_data = array($user['user_id'], $user['username'], "images/".$user['profile_pic_name']);
    } else if (isset($admin)) {
    $user_data = array($admin['admin_id'], $admin['admin_name']);
    }
    else {
        $user_data = array("-1", "Guest");
    }

    $websiteImage = parse_url($_SERVER['HTTP_HOST'].strstr($_SERVER['PHP_SELF'], "webapp-forum", true)."webapp-forum/images/MMU.png", PHP_URL_PATH);
?>

<head>
    <link rel="stylesheet" href="css/header.css" />
    <script src="https://kit.fontawesome.com/f019d50a29.js" crossorigin="anonymous"></script>
    <script>
        function toggleNav() {
            sidebarDisplay = document.getElementById("sidebar").style.display;
            if (sidebarDisplay === "block") {
                document.getElementById("sidebar").style.display = "none";
                document.getElementById("header-menu-icon").className = "fas fa-bars";
            } else {
                document.getElementById("sidebar").style.display = "block";
                document.getElementById("header-menu-icon").className = "fas fa-close";
            }
        }
    </script>
</head>
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
            <a onclick="document.getElementById('header-search-bar-form').submit();"><span class="fas fa-search search-icon"></span></a>
        </form>
        <span style="flex: 1;"></span>
        <?php
            if (isset($user) && $user_data[2]) {
                echo '<a class="header-user" href="profile.php"><img src="'. $user_data[2] .'" class="header-user" /></a>';
            } else {
                echo '<a class="header-user" href="profile.php"><span class="fas fa-user header-user-icon"></span></a>';
            }
        ?>
        <span class="header-span"></span>
        <div class="header-user-name"><?php echo $user_data[1]; ?></div>
        <div class="header-menu" onclick="toggleNav()"><span id="header-menu-icon" class="fas fa-bars"></span></div>
    </header>
</body>

</html>
