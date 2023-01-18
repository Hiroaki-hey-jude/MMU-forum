<?php

include 'includes/redirect.php';
include 'components/header.php';
$errors = array();

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
$subcategories = json_encode($subcategories);

if (isset($_POST['submit'])) {
	$errors = array();
	$title = $_POST['title'];
	$image_link = $_POST['image'];
	$description = $_POST['description'];
	//$category_id = $_POST['category-names'];
	$subcategory_id = $_POST['subcategory-names'];

	if(empty($image_link)) {
		$image_link = "";
	}

	if(empty($title) || empty($description) || empty($subcategory_id) || empty($title)) {
    		array_push($errors, "Missing parameter! You must submit the post title, description, category and subcategory.");
	}

	if (count($errors) == 0) {
		$stmt = $conn->prepare("INSERT INTO post (author_id, subcategory_id, post_name, post_description, image_name) VALUES (?,?,?,?,?)"); 
		$stmt->bind_param("iisss", $_SESSION['user'], $subcategory_id, $title, $description, $image_link);
		$stmt->execute();
		echo '<script>alert("Successfully posted!")</script>';
	}
}

include 'errors.php';
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
    <script src="https://kit.fontawesome.com/f019d50a29.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: #dae0e6;">
<?php include "components/header.php" ?>
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
                        <option id="subcategory-display" value="" disabled selected></option>
                        <?php
                        foreach($subcategories_clone as $subcategory){
                            echo '
                            <option class="subcategory-diplay-none" id="'.$subcategory[1].$subcategory[0].'" value="'.$subcategory[0].'">'.$subcategory[1].'</option>
                            ';
                        }    
                        ?>
                    </select>
                </div>
            </div>
            <input minlength="5" class="title-input" type="text" name="title" required placeholder="Enter Title">
            <input class="image-input" type="text" name="image" required placeholder="Put image link">
            <textarea name="description" id="" cols="30" rows="20" required placeholder="Enter Description"></textarea>
            <div align="right" class="post-submit-button" id="text-area">
                <input type="submit" id="submit_btn" name="submit">
            </div>
        </form>
    </div>
</body>
<script>
    let subcategoriesFromPHP = JSON.parse('<?php echo $subcategories; ?>');
    function changeSubCategory() {
        let selectedCategoryIndex = document.getElementById('category-names').value;
        var changeSubategoryDisplay = document.getElementById('subcategory-display');
        changeSubategoryDisplay.innerHTML = "<option id='subcategory-display' value='' disabled selected>Select your Subcategory</option>";

        for(let i = 0; i < subcategoriesFromPHP.length; i++) {
            if(selectedCategoryIndex != subcategoriesFromPHP[i][2]) {
                document.getElementById(subcategoriesFromPHP[i][1] + subcategoriesFromPHP[i][0]).style.display = "none";
            } else {
                document.getElementById(subcategoriesFromPHP[i][1] + subcategoriesFromPHP[i][0]).style.display = "block";
            }
        }
    }
</script>

</html>

