<?php

include 'includes/conn.php';
$errors = array();
session_start();
include 'includes/session.php';

$categories = array();
$query_get_all_categories = "SELECT * FROM category;";
$category_result = mysqli_query($conn, $query_get_all_categories);

if (!$category_result) {
	array_push($errors, "Cannot select category from table");
}

$subcategories = array();
$query_get_all_subcategories = "SELECT * FROM subcategory;";
$subcategory_result = mysqli_query($conn, $query_get_all_subcategories);
    
if(!$subcategory_result) {
    array_push($errors, "Cannot select subcategory from table");
}

if (count($errors) == 0) {
	while ($row = mysqli_fetch_assoc($category_result)) {
		$categories[] = array($row['category_id'], $row['category_name']);
	}	
	while ($row = mysqli_fetch_assoc($subcategory_result)) {
		$subcategories[] = array(
				$row['subcategory_id'],
				$row['subcategory_name'],
				$row['category_id'],
				$row['number_of_posts'],
				$row['number_of_comments']
		);
	}
}
include 'errors.php';

$subcategories_clone = $subcategories;
$subcategories =  json_encode($subcategories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/createpost.css">
    <link rel="stylesheet" href="css/header.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: #dae0e6;">
<div class="header-div"></div>
    <header class="primary-background">
        <a id="header-title" href="home.php">
            <img id="header-image" src="images/MMU.png" height="30px" />
            <span class="header-span"></span>
            MMU Forum
        </a>
        <span class="header-span"></span>
        <span class="header-span"></span>
        <div class="search-bar">
            <input class="search-input" type="text" name="search" placeholder="Search for post" />
            <!-- TODO: add search feature -->
            <a href="#search"><span class="fas fa-search search-icon"></span></a>
        </div>
        <span style="flex: 1;"></span>
        <a id="header-user" href="#user"><span class="fas fa-user user-icon"></span></a>
    </header>
    <div class="edit-post-container">
        <div class="top-h2">
            <h2>Create a Post</h2>
        </div>
        <form action="" method="post">
            <div class="choose-category">
                <div class="category">
                    <select name="category-names" id="category-names" style="width:200px;" onchange="changeSubCategory()">
                    <option value="" disabled selected>Select your Category</option>
                    <?php
                    foreach($categories as $category){
                        echo '
                        <option id="'.$category[0].'" value="'.$category[0].'">'.$category[1].'</option>
                            ';
                    }
                    ?>
                    </select>
                </div>
                <div class="subcategory">
                    <select name="subcategory-names" id="subcategory-names" style="width:200px;">
                        <option value="" disabled selected>Select your Subcategory</option>
                        <?php
                        foreach($subcategories_clone as $subcategory){
                            echo '
                            <option id="'.$subcategory[1].$subcategory[0].'" value="'.$subcategory[1].'">'.$subcategory[1].'</option>
                            ';
                        }    
                        ?>
                    </select>
                </div>
            </div>
            <input class="title-input" type="text" name="title" required placeholder="Enter Title">
            <input class="image-input" type="text" name="image" required placeholder="Put image link">
            <textarea name="description" id="" cols="30" rows="20" placeholder="Enter Description"></textarea>
            <div align="right" class="post-submit-button" id="text-area">
                <input type="submit" id="submit_btn" name="submit">
            </div>
        </form>
    </div>
</body>
<script>
    let subcategoriesFromPHP = JSON.parse('<?php echo $subcategories; ?>');
    //console.log('typeof: ' + typeof subcategoriesFromPHP);
    for (let i = 0; i < subcategoriesFromPHP.length; i++) {
        console.log('value: ' + subcategoriesFromPHP[i]);
    }
    function changeSubCategory() {
        let selectedCategoryIndex = document.getElementById('category-names').value;

        console.log(selectedCategoryIndex);
        for(let i = 0; i < subcategoriesFromPHP.length; i++) {
            if(selectedCategoryIndex != subcategoriesFromPHP[i][2]) {
                console.log(subcategoriesFromPHP[i][1]);
                document.getElementById(subcategoriesFromPHP[i][1] + subcategoriesFromPHP[i][0]).style.display = "none";
            } else {
                document.getElementById(subcategoriesFromPHP[i][1] + subcategoriesFromPHP[i][0]).style.display = "block";
            }
        }
    }
</script>

</html>
