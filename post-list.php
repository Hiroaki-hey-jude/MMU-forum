<!DOCTYPE html>
<html>
    <?php
        $posts[] = array("p0000", "Announcement", 3, 10, "Lim", "12/12/2022", true);
        $posts[] = array("p0001", "Online Week", 3, 10, "Lim", "12/12/2022", false);
    ?>
    <head>
        <link rel="stylesheet" link="css/reset.css" />
        <link rel="stylesheet" link="css/global.css" />
    </head>
    <body>
        <?php include "components/header.php" ?>
        <a href="home.php">home</a>
        <div class="post-list">
            <div class="list-title primary-background">
                Result
            </div>
            <?php
                foreach($posts as $item){
                    echo '
                        <post-item
                            href="post-details.php?id='.$item[0].'" 
                            title="'.$item[1].'" 
                            likes="'.$item[2].'" 
                            comments="'.$item[3].'" 
                            author="'.$item[4].'" 
                            createdAt="'.$item[5].'" 
                            pinned="'.$item[6].'" />';
                }
            ?>
        </div>
    </body>
</html>