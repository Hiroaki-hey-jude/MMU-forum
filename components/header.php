<!DOCTYPE html>
<html>

<?php
    // TODO: link backend
    $user = array("u0001", "Tian Hee", "Lim", "user_image_src");

?>

<head>
    <link rel="stylesheet" href="css/header.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
            <!-- TODO: add search feature -->
            <a onclick="document.getElementById('header-search-bar-form').submit();"><span class="fas fa-search search-icon"></span></a>
        </form>
        <span style="flex: 1;"></span>
        <?php
            if ($user[3]) {
                echo '<img src="https://picsum.photos/200" class="header-user" />';
            } else {
                echo '<a class="header-user" href="#user"><span class="fas fa-user header-user-icon"></span></a>';
            }
        ?>
        <span class="header-span"></span>
        <div class="header-user-name"><?php echo $user[1]; ?></div>
        
    </header>
</body>

</html>