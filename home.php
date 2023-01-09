<!DOCTYPE html>
<html>

<?php
    //  TODO: bacckend data
    $categories[] = array(
        "Announcement", 
        array(
            array("sc01", "Online Week", 3, 10), 
            array("sc02", "Registration starts", 5, 40)
        )
    );
    $categories[] = array(
        "FCI", 
        array(
            array("sc003", "No Online Week", 3, 10), 
            array("sc004", "Registration no more", 5, 40)
        )
    );
?>

<head lang="en">
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/home.css" />
    <script src="components/post-item.js"></script>
</head>

<body>
    <?php include "components/header.php" ?>
    <?php include "components/sidebar.php" ?>
    <aside id="right-pane"></aside>
    <div id="home-container">
        <?php
            foreach ($categories as $category) {
                echo '
                    <div class="post-list">
                        <div class="list-title primary-background">
                            '.$category[0].'
                        </div>
                ';
                foreach($category[1] as $subcategory){
                    echo '
                        <post-item
                            type="subcategory"
                            href="post-details.php?id='.$subcategory[0].'" 
                            title="'.$subcategory[1].'" 
                            posts="'.$subcategory[2].'" 
                            comments="'.$subcategory[3].'" 
                        />';
                }
                echo '
                    </div>
                ';
            };
        ?>
        
    </div>
</body>

</html>