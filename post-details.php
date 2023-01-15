<!DOCTYPE html>
<html>
    <?php
        // TODO; llink backend
        $title = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
        $image = "https://i.imgur.com/AYk0AyG.png";
        $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tristique velit nec ultricies efficitur. Vivamus dapibus erat metus. Vivamus sed porta augue. Curabitur pharetra facilisis feugiat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse eu pellentesque mauris. Integer at nibh quam. Proin enim lectus, cursus non augue vel, suscipit tincidunt mi. Aliquam tempus gravida felis, non volutpat ligula consectetur id. Nullam eu sapien pulvinar, interdum eros nec, molestie dui. Cras a eros ac arcu consequat laoreet. In semper massa purus. Etiam lacinia quis tellus tempor venenatis. Suspendisse nec elit quis eros tristique interdum.

        Sed lacinia lacinia felis, quis ornare augue efficitur non. Cras sit amet nulla quis dolor commodo maximus dictum ut turpis. Ut feugiat leo ac posuere consequat. Maecenas iaculis auctor mi at congue. Etiam quis turpis id metus egestas imperdiet quis ac nibh. Praesent lacinia magna eget eros feugiat, feugiat tincidunt enim porta. Nulla ut libero rutrum, vestibulum lacus et, commodo eros. Quisque faucibus ex a nisl scelerisque rhoncus. Sed pharetra justo quis finibus porttitor. Sed urna odio, imperdiet vel turpis vitae, vestibulum ultrices arcu. Vestibulum ac turpis sed massa lobortis scelerisque. Duis et ante eget arcu tempus efficitur. Donec ac facilisis tellus, euismod tempor sem. Nulla faucibus odio blandit tellus eleifend, vitae tempor odio posuere. Aenean a scelerisque est, non lacinia odio. Ut lobortis sit amet lectus fringilla accumsan.";
    ?>
    <head>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/global.css" />
    </head>
    <body>
        <?php include "components/header.php" ?>
        <?php include "components/sidebar.php" ?>
        <div class="page-container">
            <article class="post-header">
                <h2 class="post-title"><?php echo $title; ?></h2>
                <img class="post-image" src="<?php echo $image; ?>" />
                <p><?php echo $description; ?></p>
            </article>
        </div>
    </body>
</html>