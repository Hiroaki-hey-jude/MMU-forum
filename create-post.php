<?php
//backend data
$categories[] = array(
    //`category_id`, `category_name`
    "1",
    "GENERAL", 
);
$categories[] = array(
    "2",
    "aculty of Computing and Informatics (FCI)", 
);
$categories[] = array(
    "3",
    "Faculty of Engineering (FOE) & Faculty of Engineering & Technology (FET)", 
);
$categories[] = array(
    "4",
    "Faculty of Management (FOM) & Faculty of Business (FOB)", 
);
$categories[] = array(
    "5",
    "Faculty of Creative Multimedia (FCM)", 
);
$categories[] = array(
    "6",
    "Faculty of Applied Communication (FAC)", 
);
$categories[] = array(
    "7",
    "Fad (FED)", 
);

// $subcategories[] = array(
//     "1", "Annoucement", "1", "18", "46"
// );
$subcategories[] = array(
    //`subcategory_id`, `subcategory_name`, `category_id`, `number_of_posts`, `number_of_comments`
    "1", "Annoucement", "1", "18", "46"
);
$subcategories[] = array(
    "2", "Club Activities", "1", "16", "46"
);
$subcategories[] = array(
    "3", "Feedback and Helpdesk", "1", "16", "46"
);
$subcategories[] = array(
    "4", "Admission & Enrollment", "1", "22", "72"
);
$subcategories[] = array(
    "5", "Hostel Discussion", "1", "15", "44"
);
$subcategories[] = array(
    "6", "Computer Science in General", "2", "15", "44"
);
$subcategories[] = array(
    "7", "Nanotechnology", "3", "15", "44"
);
$subcategories[] = array(
    "8", "Digital Enterprise", "4", "15", "44"
);
$subcategories[] = array(
    "9", "Virtual Reality", "5", "15", "44"
);
$subcategories[] = array(
    "10", "Media Culture", "6", "15", "44"
);
$subcategories[] = array(
    "11", "Movie Production", "7", "15", "44"
);
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
                            <option id="'.$subcategory[1].'" value="'.$subcategory[1].'">'.$subcategory[1].'</option>
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
                document.getElementById(subcategoriesFromPHP[i][1]).style.display = "none";
            } else {
                document.getElementById(subcategoriesFromPHP[i][1]).style.display = "block";
            }
        }
    }
</script>
</html>