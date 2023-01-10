<!DOCTYPE html>
<html>

<?php
    // TODO: backend data
    $categories[] = array(
        "c0001",
        "Announcement", 
        array(
            array("sc001", "Online Week", 3, 10), 
            array("sc002", "Registration starts", 5, 40)
        )
    );
    $categories[] = array(
        "c0002",
        "FCI", 
        array(
            array("sc003", "No Online Week", 3, 10), 
            array("sc004", "Registration no more", 5, 40)
        )
    );
    $categories[] = array(
        "c0003",
        "FCI", 
        []
    );

    // TODO: backend, cut to first 3 or 5
    $recentPosts[] = array("p0000", "Announcement", 3, 10, "Lim", "12/12/2022", true);
    $bookmarkedPosts[] = array("p0001", "Online Week", 3, 10, "Lim", "12/12/2022", false);
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
    <aside id="right-pane">
        <div class="post-list recent-list">
            <div class="list-title">
                Recent Posts
                <a class="view-all" href="post-list.php?type=recent">View All</a>
            </div>
            <?php
                foreach($recentPosts as $post){
                    echo '
                        <post-item
                            type="post"
                            href="post-details.php?id='.$post[0].'" 
                            title="'.$post[1].'" 
                            posts="'.$post[2].'" 
                            comments="'.$post[3].'" 
                            pinned="'.$post[4].'" 
                        />';
                }
            ?>
        </div>
        <div class="post-list bookmark-list">
            <div class="list-title bookmark-title">
                Bookmarked Posts
                <a class="view-all" href="post-list.php?type=bookmark">View All</a>
            </div>
            <?php
                foreach($bookmarkedPosts as $post){
                    echo '
                        <post-item
                            type="post"
                            href="post-details.php?id='.$post[0].'" 
                            title="'.$post[1].'" 
                            posts="'.$post[2].'" 
                            comments="'.$post[3].'" 
                            pinned="'.$post[4].'" 
                        />';
                }
            ?>
        </div>
    </aside>
    <div id="home-container">
        <?php
            foreach ($categories as $category) {
                echo '
                    <div class="post-list">
                        <div class="list-title">
                            '.$category[1].'
                            <a class="view-all" href="post-list.php?id='.$category[0].'&type=category">View All</a>
                        </div>
                ';

                if (empty($category[2])) {
                    echo '<div class="list-empty">List is empty.</div>';
                } else {
                    foreach($category[2] as $subcategory){
                        echo '
                            <post-item
                                type="subcategory"
                                href="post-details.php?id='.$subcategory[0].'" 
                                title="'.$subcategory[1].'" 
                                posts="'.$subcategory[2].'" 
                                comments="'.$subcategory[3].'" 
                            />';
                    }
                }
                
                echo '
                    </div>
                ';
            };
        ?>
        
    </div>
</body>

</html>