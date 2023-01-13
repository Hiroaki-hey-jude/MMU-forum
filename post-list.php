<!DOCTYPE html>
<html>
    <?php
        $posts[] = array("p0000", "Announcement", 3, 10, "Lim", "12/12/2022", true);
        $posts[] = array("p0001", "Online Week", 3, 10, "Lim", "12/12/2022", false);
    ?>
    <head>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/global.css" />
        <script src="components/post-item.js"></script>
    </head>
    <body>
        <?php include "components/header.php" ?>
        <?php include "components/sidebar.php" ?>
        <div id="page-container">
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
        </div>
    </body>
</html>