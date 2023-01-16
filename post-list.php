<!DOCTYPE html>
<html>
    <?php
        include 'includes/session.php';
        $errors = array();
        // If the user redirected from selecting the subcategory
        // if the url has type and id
        $posts = array();
        if(isset($_GET['type'])) {
            $type = $_GET['type'];
        } else {
            $type = null;
        }
        if(isset($_GET['id']) && ($type == 'category' || $type == 'subcategory')) {
            $id = $_GET['id'];
            // check which type does it belong to, to determine the query
            if($_GET['type'] == 'category') {
                # mysqli query to select entry that has 
                $query_to_get_name = "SELECT category_name FROM category WHERE category_id = ". $id . "";;
                $query_to_get_post_list = "SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                            `number_of_comments`, `number_of_likes` FROM post 
                            WHERE subcategory_id IN (SELECT `subcategory_id` FROM subcategory WHERE category_id = ". $id.");";
            }
            else if($_GET['type'] == 'subcategory') {
                $query_to_get_name = "SELECT subcategory_name FROM subcategory WHERE subcategory_id = ". $id . "";;
                $query_to_get_post_list = "SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                            `number_of_comments`, `number_of_likes` FROM post 
                            WHERE `subcategory_id` = " . $id . ";";
            }
            
            $name_data = mysqli_query($conn, $query_to_get_name);
            
            if(mysqli_num_rows($name_data) == 0 || !$name_data) {
                array_push($errors, "No such category or subcategory"); 
            } else {
                $data_row = mysqli_fetch_assoc($name_data);
                if($_GET['type'] == 'category') {
                    $parentTitle = $data_row['category_name'] ;
                } else if ($_GET['type'] == 'subcategory') {
                    $parentTitle = $data_row['subcategory_name'];
                }
                $title = "All posts in ". $parentTitle . ":";
            }
        }
        else if ($type == 'bookmark') {
            $query_to_get_post_list = "SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                `number_of_comments`, `number_of_likes` FROM post WHERE post_id IN (SELECT `post_id` FROM bookmark
                WHERE user_id = ". $user['user_id']. ");";
            $title = "Your bookmark:";
        }
        else if ($type == 'recent') {
            $recents_number = 50;
            $query_to_get_post_list = "SELECT * FROM post ORDER BY created_at DESC LIMIT $recents_number;";
            $title = "Recent " . $recents_number . " Posts:";
        }
        // When the type is search, it mean this is for search result
        else if (isset($_GET['search'])) {
            $search_keyword = $_GET["search"];
            $title = "Search result of: ". $search_keyword;
            // $category_id = $_GET['filter'];
            $query_to_get_post_list = "SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                            `number_of_comments`, `number_of_likes` FROM post 
                             WHERE post_name LIKE '%" . $search_keyword . "%' ;";
        } else {
            array_push($errors, "There is no such type of post list");
        }

        if(isset($query_to_get_post_list)) {
            $post_list_result = mysqli_query($conn, $query_to_get_post_list);
            if(!$post_list_result) {
                array_push($errors, "The post list for this query is empty or query is wrong"); 
            } else {
                while($row = mysqli_fetch_assoc($post_list_result)) {
                    $query_to_get_author_name = "SELECT username FROM user WHERE user_id = " . $row['author_id'] . ";";
                    $author_name_data = mysqli_query($conn, $query_to_get_author_name);

                    if(mysqli_num_rows($author_name_data) == 0)  {
                        array_push($errors, "Cannot get author name, user_id = " . $row['author_id'] . " doesn't exist in user table");
                        break;
                    }

                    $user_row = mysqli_fetch_assoc($author_name_data);
                    $author_name = $user_row['username'];
                    $posts[] = array(
                        $row['post_id'], $row['post_name'], $row['number_of_likes'], $row['number_of_comments'],
                        $author_name, $row['created_at'], false);
                }
            }
        } else {
            $title = "Error, there is no such type to be passed into post-list!";
            array_push($errors, "Error, there is no such type to be passed into post-list!");
        }
        include('errors.php');
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
                    // if(count($posts) == 0) {
                    //     echo "There is no result.";
                    // }
                ?>
            </div>
        </div>
    </body>
</html>