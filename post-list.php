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
        if(isset($_GET['id']) && ($type == 'category' || $type == 'subcategory') && !($type == 'advancedsearch')) {
            $id = $_GET['id'];
            // check which type does it belong to, to determine the query
            if($_GET['type'] == 'category') {
                # mysqli query to select entry that has 
                $query_to_get_name = $conn->prepare("SELECT category_name FROM category WHERE category_id = ?;");
                $query_to_get_name->bind_param("s", $id);

                $query_to_get_post_list = $conn->prepare("SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                        `number_of_comments`, `number_of_likes` FROM post WHERE subcategory_id IN 
                        (SELECT `subcategory_id` FROM subcategory WHERE category_id = ?)");
                $query_to_get_post_list->bind_param("s", $id);

            }
            else if($_GET['type'] == 'subcategory') {
                $query_to_get_name = $conn->prepare("SELECT subcategory_name FROM subcategory WHERE subcategory_id = ?");
                $query_to_get_name->bind_param("s", $id);

                $query_to_get_post_list = $conn->prepare("SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                            `number_of_comments`, `number_of_likes` FROM post 
                            WHERE `subcategory_id` = ?");
                $query_to_get_post_list->bind_param("s", $id);
            }

            $query_to_get_name->execute();
            $name_data = $query_to_get_name->get_result();
            
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
        else if (isset($user) && $type == 'bookmark') {
            $query_to_get_post_list = $conn->prepare("SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                    `number_of_comments`, `number_of_likes` FROM post WHERE post_id IN 
                    (SELECT `post_id` FROM bookmark WHERE user_id = ?;");
            $query_to_get_post_list->bind_param("i", $user_id);
            $title = "Your bookmark:";
        }
        else if ($type == 'recent') {
            $recents_number = 50;
            $query_to_get_post_list = $conn->prepare( "SELECT * FROM post ORDER BY created_at DESC LIMIT ?;");
            $query_to_get_post_list->bind_param("i", $recents_number);
            $title = "Recent " . $recents_number . " Posts:";
        }
        // When the type is search, it mean this is for search result
        else if (isset($_GET['search'])) {
            $search_keyword = $_GET["search"];
            $title = "Search result of: ". $search_keyword;
            $search_term = "%".$search_keyword."%";
            $query_to_get_post_list = $conn->prepare("SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                `number_of_comments`, `number_of_likes` FROM post 
                WHERE post_name LIKE ? ;");
            $query_to_get_post_list->bind_param("s", $search_term);
        // When the type is advancedsearch
        } else if($type == 'advancedsearch'){

            $query = "SELECT `post_id`, `author_id`, `post_name`, `created_at`,
            `number_of_comments`, `number_of_likes` FROM post 
            WHERE ";
            
            $search_keyword = $_POST["advancedsearch"]; // string type
            $search_condition = array();
            $parameter = array();
            if(isset($_POST["category-names"])) {
                $category_id = $_POST["category-names"];
                array_push($search_condition, "subcategory_id IN 
                (SELECT `subcategory_id` FROM subcategory WHERE category_id = ?)");
                array_push($parameter,$category_id);
            }
            if(isset($_POST["subcategory-names"])) {
                $subcategory_id = $_POST["subcategory-names"];
                array_push($search_condition, "subcategory_id=?");
                array_push($parameter,$subcategory_id);
            }
            // if the user select desc only
            if(isset($_POST['desc']) && !isset($_POST['title'])){
                array_push($search_condition, "post_description LIKE ?");
                array_push($parameter,"%".$search_keyword."%");
            }
            // if the user select title only
            else if(isset($_POST['title']) && !isset($_POST['desc'])){
                array_push($search_condition, "post_name LIKE ?");
                array_push($parameter,"%".$search_keyword."%");
            } else {
                array_push($search_condition, "(post_description LIKE ? OR post_name LIKE ?)");
                array_push($parameter,"%".$search_keyword."%");
                array_push($parameter,"%".$search_keyword."%");
            }

            for ($i = 0; $i < count($search_condition); $i++) {
                if($i == 0) {
                    $query .= $search_condition[$i];
                } else {
                    $query .= " AND " . $search_condition[$i];
                }
                if ($i == count($search_condition) - 1) {
                    $query .= ";";
                }
            }
        $query_to_get_post_list = $conn->prepare($query);
        switch (count($parameter)) {
            case 1:
                $query_to_get_post_list->bind_param("s", $parameter[0]);
                break;
            case 2:
                $query_to_get_post_list->bind_param("ss", $parameter[0], $parameter[1]);
                break;
            case 3:
                $query_to_get_post_list->bind_param("sss", $parameter[0], $parameter[1], $parameter[2]);
                break;
            case 4:
                $query_to_get_post_list->bind_param("ssss", $parameter[0], $parameter[1], $parameter[2], $parameter[3]);
                break;
            case 5:
                $query_to_get_post_list->bind_param("sssss", $parameter[0], $parameter[1], $parameter[2], $parameter[3], $parameter[4]);
                break;
            default:
                array_push($errors, "Error in advanced search");
                break;
        }
        $title = "Search result of: ". $search_keyword;
        }
         else {
            array_push($errors, "There is no such type of post list");
        }

        if(isset($query_to_get_post_list) && count($errors) == 0) {
            $query_to_get_post_list->execute();
            $post_list_result = $query_to_get_post_list->get_result();
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
            $title = "No result!";
            array_push($errors, "Error, there is no such type to be passed into post-list!");
        }
        include('errors.php');
    ?>
    <head>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/global.css" />
    </head>
    <body>
        <?php include "components/header.php" ?>
        <?php include "components/sidebar.php" ?>
        <?php include "components/advanced-search.php" ?>
        <div class="page-container">
            <div class="post-list">
                <div class="list-title primary-background">
                    <?php echo $title ?>
                </div>
                <?php
                    if (count($posts) === 0)
                        include 'components/placeholder.php';
                    else
                        foreach($posts as $item){
                            $post_item_id = $item[0];
                            $post_item_href = "post-details.php?id=".$item[0];
                            $post_item_title = $item[1];
                            $post_item_noOfLikes = $item[2];
                            $post_item_noOfComments = $item[3];
                            $post_item_author = $item[4];
                            $post_item_createdAt = $item[5];
                            include "components/post-item.php";
                        }
                ?>
            </div>
        </div>
    </body>
</html>