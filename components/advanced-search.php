<!DOCTYPE html>
<html lang="en">
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
        <form action="" method="post">
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
                                            <option id="'.$subcategory[1].$subcategory[0].'" value="'.$subcategory[1].'">'.$subcategory[1].'</option>
                                            ';
                                        }    
                                        ?>
                                    </select>
                            </div>
                            <div class="checkbox">
                                <p class="select-label" for="subcategory-names"> Post </p>
                                <label for="toggle" class="toggle_label">title</label>
                                <input id="toggle" class="toggle_input" type='checkbox' />
                                <label for="toggle" class="toggle_label">decscription</label>
                                <input id="toggle" class="toggle_input" type='checkbox' />
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