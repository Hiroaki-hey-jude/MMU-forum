<!DOCTYPE html>
<html>
    <?php
        $posts[] = array("p0000", "Announcement", 3, 10, "Lim", "12/12/2022", true);
        $posts[] = array("p0001", "Online Week", 3, 10, "Lim", "12/12/2022", false);

        $search = $_GET["search"];
        // passed from where the list was accessed
        $type = $_GET["type"];
        // TODO: (either one)
        // 1. based on the selected list type and id, query the name of the selected title
        // - id is already expected to be passed so no need to specifically pass title, but more steps on current page
        $parentTitle = "FCI";
        // 2. pass title directly from previous page
        // less steps, but everytime you need to pass title specifically to this page
        // $parentTitle = $_GET["title"];

        switch ($type) {
            case 'category':
                $title = "Subcategories in ".$parentTitle;
                break;
            case 'subcategory':
                $title = "Posts in ".$parentTitle;
                break;
            default:
                $title = "Posts";
                break;
        }
        if ($search) {
            $title = "Results of ".$search;
        }
    ?>
    <head>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/global.css" />
        <script src="components/post-item.js"></script>
    </head>
    <body>
        <?php include "components/header.php" ?>
        <?php include "components/sidebar.php" ?>
        <div class="page-container">
            <div class="post-list">
                <div class="list-title primary-background">
                    <?php echo $title ?>
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