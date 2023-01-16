<!DOCTYPE html>
<html>
    <?php
    // include 'includes/session.php';
        $options[] = array("home", "Home", "home", "home.php");
        $options[] = array("profile", "Profile", "user", "edit-profile.php");
        $options[] = array("logout", "Log out", "door-open", "logout.php");
        $lastOption = end($options);
    ?>
    <head>
        <link rel="stylesheet" href="css/sidebar.css" />
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <nav class="sidebar">
        <?php
            foreach ($options as $option) {
                echo '
                <a href="'.$option[3].'">
                    <div class="sidebar-button';
                
                if ($option[0] == "logout")
                    echo ' logout-button';
                
                echo '">
                        <span class="sidebar-icon fas fa-'.$option[2].'"></span>
                        <div>'.$option[1].'</div>
                    </div>
                </a>';
            }
        ?>
    </nav>
    </body>
</html>