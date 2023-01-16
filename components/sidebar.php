<!DOCTYPE html>
<html>
    <?php
    // include 'includes/session.php';
        $test = $_SERVER['REQUEST_URI'];
        $options[] = array("home", "Home", "home", "home.php");
        if (isset($user)) {
            $options[] = array("profile", "Profile", "user", "edit-profile.php");
            $options[] = array("logout", "Log out", "door-open", "logout.php");
        }
        else {
            $options[] = array("login", "Log in", "key", "login.php");
            $options[] = array("register", "Sign up", "plus", "register.php");
        }
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
                
                if(str_contains($test, $option[3]))
                    echo ' sidebar-button-selected ';
                if ($option[0] == "logout" || $option[0] == "login" || $option[0] == "register")
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