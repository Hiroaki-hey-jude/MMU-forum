<!DOCTYPE html>
<html>
    <?php
        // default handling
        $post_item_id = $post_item_id ?? "";
        $post_item_type = $post_item_type ?? "post";
        $post_item_title = $post_item_title ?? "&nbsp";
        $post_item_href = $post_item_href ?? "";
        $post_item_noOfLikes = $post_item_noOfLikes ?? 0;
        $post_item_noOfComments = $post_item_noOfComments ?? 0;
        $post_item_author = $post_item_author ?? "";
        $post_item_createdAt = $post_item_createdAt ?? "";
        $post_item_bookmarked = $post_item_bookmarked ?? false;
        
    ?>
    <head>
        <link rel="stylesheet" href="css/global.css" />
        <script src="https://kit.fontawesome.com/f019d50a29.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="post-item" onclick="location.href = '<?php echo $post_item_href; ?>';">
            <?php
                if ($post_item_type === "post" && $post_item_bookmarked)
                    echo '<span class="fas fa-bookmark" style="float: right; margin: 0.5em 0.5em 0 0;"></span>';
            ?>
            <p class="list-item-title"><?php echo $post_item_title; ?></p>
            <div class="list-item-subtitle">
                <?php
                    if ($post_item_type === "subcategory")
                        echo '<a class="post-action"><span class="post-action-icon fas fa-list"></span> '.$post_item_noOfPosts.'</a>';
                    else
                        echo '<a class="post-action"><span class="post-action-icon fas fa-thumbs-up"></span> '.$post_item_noOfLikes.'</a>';
                ?>
                <a class="post-action"><span class="post-action-icon fas fa-comments"></span> <?php echo $post_item_noOfComments; ?></a>
                <span style="flex: 1"></span>
                <?php
                    // TODO: backend delete item, post, subcategory
                    // stopPropagation prevents triggering parent onclick
                    if (isset($admin))
                        echo '
                            <a href="edit-form.php?id='.$post_item_id.'&type='.$post_item_type.'" onclick="event.stopPropagation()"><span class="post-action-icon fas fa-pen"></span></a>
                            <a href="delete-post.php?id='.$post_item_id.'" onclick="event.stopPropagation()"><span class="post-action-icon fas fa-trash"></span></a>';
                    else if ($post_item_type === "post")
                        echo '<div style="color: gray; font-size: small;">'.$post_item_author.' '.$post_item_createdAt.'</div>';
                ?>
            </div>
        </div>
    </body>
</html>
