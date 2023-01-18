<!DOCTYPE html>
<html lang="en">
<?php

$errors = array();

$categories = array();
$subcategories = array();

$query_get_categories = "SELECT * FROM category;";
$categories_data = mysqli_query($conn, $query_get_categories);

$query_get_subcategories = "SELECT * FROM subcategory;";
$subcategories_data = mysqli_query($conn, $query_get_subcategories);

if(!$categories_data) {
    array_push($erros, "Cannot get categories");
}

if(!$subcategories_data) {
    array_push($erros, "Cannot get subcategories");
}

if(count($errors) == 0) {
    while($row = mysqli_fetch_assoc($categories_data)) {
        $categories[] = array($row['category_id'], $row['category_name']);
    }
    while($row = mysqli_fetch_assoc($subcategories_data)) {
        $subcategories[] = array($row['subcategory_id'], $row['subcategory_name'], $row['category_id']
                            , $row['number_of_posts'], $row['number_of_comments']);
    }
    $subcategories_clone = $subcategories;
    $subcategories =  json_encode($subcategories);
}

include "errors.php";


?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/advanced-search.css">
</head>
<body>
    <div id="advanced-search-container" class="advanced-search-container">
        <form action="post-list.php?type=advancedsearch" method="post">
            <section class="panel">
                <input id="block-01" type="checkbox" class="toggle">
                <label class="Label" for="block-01">Advanced search</label>
                    <div class="content">
                    <input class="advancedsearch" type="text" name="advancedsearch" required placeholder="advanced search">
                            <div class="category">
                                <label class="select-label" for="category-names"> Category </label>
                                <select class="select-select" name="category-names" id="category-names" onchange="changeSubCategory()">
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
                                <label class="select-label" for="subcategory-names"> Subcategory </label>
                                    <select class="select-select" name="subcategory-names" id="subcategory-names" >
                                        <option value="" disabled selected>Select your Subcategory</option>
                                        <?php
                                        foreach($subcategories_clone as $subcategory){
                                            echo '
                                            <option id="'.$subcategory[1].$subcategory[0].'" value="'.$subcategory[0].'">'.$subcategory[1].'</option>
                                            ';
                                        }    
                                        ?>
                                    </select>
                            </div>
                            <div class="checkbox">
                                <p class="select-label" for="toggle"> Post </p>
                                <label for="toggle" class="toggle_label">title</label>
                                <input id="toggle" class="toggle_input" name="title" value="1" type='checkbox' checked/>
                                <label for="toggle" class="toggle_label">decscription</label>
                                <input id="toggle" class="toggle_input" name="desc" value="1" type='checkbox' />
                            </div>
                            <div align="right" class="advanced-search-button" id="text-area">
                                <input value="Search" type="submit" id="search_btn" name="submit">
                            </div>
                    </div>
            </section>
        </form>
    </div>
</body>
<script>
    let subcategoriesFromPHP = JSON.parse('<?php echo $subcategories; ?>');
    function changeSubCategory() {
        let selectedCategoryIndex = document.getElementById('category-names').value;

        for(let i = 0; i < subcategoriesFromPHP.length; i++) {
            if(selectedCategoryIndex != subcategoriesFromPHP[i][2]) {
                document.getElementById(subcategoriesFromPHP[i][1] + subcategoriesFromPHP[i][0]).style.display = "none";
            } else {
                document.getElementById(subcategoriesFromPHP[i][1] + subcategoriesFromPHP[i][0]).style.display = "block";
            }
        }
    }
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        /* Toggle between adding and removing the "active" class,
        to highlight the button that controls the panel */
        this.classList.toggle("active");

        /* Toggle between hiding and showing the active panel */
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
        panel.style.display = "none";
        } else {
        panel.style.display = "block";
        }
    });
    }
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
        } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
    }
</script>
</html>