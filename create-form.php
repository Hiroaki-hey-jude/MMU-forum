<!DOCTYPE html>
<html>
    <?php
	include "includes/session.php";
        include "includes/permission.php";
        $fieldKeys = [];
        $type = $_GET["type"];

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

        if ($type === "category") {
            $fieldKeys = array("title");
        }
        if ($type === "subcategory") {
            $fieldKeys = array("title", "category");
        }
        if ($type === "post") {
            $fieldKeys = array("title", "description", "category", "subcategory", "comments");
        }

        $subcategories_clone = $subcategories;
        $subcategories =  json_encode($subcategories);
    ?>
    <head>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/global.css" />
        <link rel="stylesheet" href="css/admin.css" />
        <script>
            let subcategoriesFromPHP = JSON.parse('<?php echo $subcategories; ?>');

            function onChangeSubCategory() {
                let selectedCategoryId = document.getElementById('category').value;
                let selectedSubcategoryId = document.getElementById('subcategory').value;

                for(let i = 0; i < subcategoriesFromPHP.length; i++) {
                    if(selectedCategoryId != subcategoriesFromPHP[i][2]) {
                        document.getElementById(subcategoriesFromPHP[i][1] + subcategoriesFromPHP[i][0]).style.display = "none";
                        // Removes the selected if selected subcategory is the removed one
                        if (selectedSubcategoryId == subcategoriesFromPHP[i][0]) {
                            document.getElementById('subcategory').value = "";
                        }
                    } else {
                        document.getElementById(subcategoriesFromPHP[i][1] + subcategoriesFromPHP[i][0]).style.display = "block";
                    }
                }
            }
        </script>
    </head>
    <body>
        <?php include "components/header.php" ?>
        <?php include "components/sidebar.php" ?>
        <div class="page-container">
            <form class="edit-form-container" method="post">
                <h2 class="edit-form-title">Create <?php echo ucfirst($type);?></h2>
                <?php
                    foreach ($fieldKeys as $key) {
                        if ($key === "title") 
                            echo '
                            <label class="edit-form-label">Title</label>
                            <input class="edit-form-input" name="title" type="text" required placeholder="Enter title" />
                            ';
                        if ($key === "description") 
                            echo '
                            <label class="edit-form-label">Description</label>
                            <input class="edit-form-input" name="description" type="text" required placeholder="Enter description" />
                            ';
                        if ($key === "category") {
                            echo '
                            <label class="edit-form-label">Category</label>
                            <select class="edit-form-input" name="category" id="category" required onchange="onChangeSubCategory()">
                            ';
                            foreach ($categories as $category) {
                                echo '<option value="'.$category[0].'">'.$category[1].'</option>';
                            }
                            echo '</select>
                            ';
                        }
                        if ($key === "subcategory") {
                            echo '
                            <label class="edit-form-label">Subcategory</label>
                            <select class="edit-form-input" name="subcategory" id="subcategory" required>
                            ';
                            foreach ($subcategories_clone as $subcategory) {
                                echo '<option id="'.$subcategory[1].$subcategory[0].'" value="'.$subcategory[0].'">'.$subcategory[1].'</option>';
                            }
                            echo '</select>
                            ';
                        }
                        if($key === "comments") {
                            echo '
                                <label class="edit-form-label">Comments</label>
                                <section class="post-comments">
                            ';
                            if (count($comments) === 0)
                                echo '
                                    <div class="list-empty">No comments.</div>
                                ';
                            else
                                foreach ($comments as $comment) {
                                    $isCommentLked = $comment[5];
                                    echo '
                                    <script>
                                        function onDelete() {
                                            if (window.confirm("Are you sure?"))
                                                location.href = "delete-comment.php?id='.$comment[0].'";
                                        }
                                    </script>
                                    <div class="post-comment">
                                        <div class="post-author">
                                            <img class="post-author-image" src="'.$comment[1].'" />'.$comment[2].'
                                            <span style="flex: 1;"></span>
                                            <div style="font-size: small;">'.$comment[3].'</div>
                                        </div>
                                        <p class="post-comment-desc">'.$comment[4].'</p>
                                        <div class="post-comment-actions">
                                            <div class="post-action">
                                                <span class="post-action-icon fas fa-thumbs-up"></span>'.$comment[6].'
                                            </div>
                                            <span style="flex: 1;"></span>
                                            <a onclick="onDelete()"><span class="post-action-icon fas fa-trash"></span></a>
                                        </div>
                                    </div>
                                ';
                                }
                            
                            echo '
                                </section>
                            ';
                        }
                    }
                ?>

		<?php
			$errors = array();
			if (isset($_POST['Submit']) && isset($_GET['type'])) {
				if ($_GET['type'] === "category") {
					$new_category = $_POST['title'];
					if(empty($new_category)) {
						array_push($errors, "Missing parameter! You must submit the new category name.");
					}
					if (count($errors) == 0) {
						$stmt = $conn->prepare("INSERT INTO category (category_name) VALUES (?)"); 
						$stmt->bind_param("s", $new_category);
						$stmt->execute();
						echo '<script>alert("Successfully added the category!")</script>';
					}
				}
				elseif ($_GET['type'] === "subcategory") {
					$new_subcategory = $_POST['title'];
					$category_id = $_POST['category'];
					if(empty($new_subcategory) || empty($category_id)) {
						array_push($errors, "Missing parameter! You must submit the new subcategory name.");
					}
					if (count($errors) == 0) {
						$stmt = $conn->prepare("INSERT INTO subcategory (subcategory_name, category_id) VALUES (?,?)"); 
						$stmt->bind_param("si", $new_subcategory, $category_id);
						$stmt->execute();
						echo '<script>alert("Successfully added the subcategory!")</script>';
					}
				}

			}

			include 'errors.php';
		?>
                <div class="form-submit-container">
                    <input class="form-submit-button" type="submit" name="Submit" />
                </div>
            </form>
        </div>
    </body>
</html>

