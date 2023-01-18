<!DOCTYPE html>
<html>
    <?php
    // include 'includes/session.php';
        $page_uri = $_SERVER['REQUEST_URI'];
        $options[] = array("home", "Home", "home", "home.php");
        $options[] = array("createPost", "Post", "plus", "create-post.php");
        if (isset($user)) {
            $options[] = array("profile", "Profile", "user", "edit-profile.php");
        } else if (isset($admin)) {
        $options[] = array("createCategory", "Category", "plus", "create-form.php?type=category");
        $options[] = array("createSubcategory", "Subcategory", "plus", "create-form.php?type=subcategory");
    }
        else {
            $options[] = array("login", "Log in", "key", "login.php");
            $options[] = array("register", "Sign up", "plus", "register.php");
        }
        if (isset($user) || isset($admin)) {
            $options[] = array("logout", "Log out", "door-open", "logout.php");
        }
        $lastOption = end($options);
    ?>
    <head>
        <link rel="stylesheet" href="css/sidebar.css" />
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <script>
            window.addEventListener('resize', function(event) {
                const curWidth = event.target.innerWidth;
                if (curWidth > 600) {
                    document.getElementById("sidebar").style.width = "10em";
                    document.getElementById("sidebar").style.display = "block";
                } else {
                    document.getElementById("sidebar").style.width = "100%";
                }
            });
        </script>
    </head>
    <body>
    <nav class="sidebar" id="sidebar">
        <form id="sidebar-search-bar-form" class="sidebar-search-bar" action="post-list.php">
            <input class="sidebar-search-input" type="text" name="search" placeholder="Search for post"/>
        </form>
        <?php
            foreach ($options as $option) {
                echo '
                <a href="'.$option[3].'">
                    <div class="sidebar-button';

                if (str_contains($page_uri, $option[3]))
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