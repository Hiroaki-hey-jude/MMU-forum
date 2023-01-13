<?php
//backend data


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <form action="upload/path" method="post">
            <div class="choose-category">
                <div class="category">
                    <select name="category-names" id="category-names" style="width:200px;">
                        <option value="" disabled selected>Select your Category</option>
                        <option value="rigatoni">Rigatoni</option>
                        <option value="dave">Dave</option>
                        <option value="pumpernickel">Pumpernickel</option>
                        <option value="reeses">Reeses</option>
                    </select>
                </div>
                <div class="subcategory">
                    <select name="subcategory-names" id="subcategory-names" style="width:200px;">
                        <option value="" disabled selected>Select your Subcategory</option>
                        <option value="rigatoni">Rigatoni</option>
                        <option value="dave">Dave</option>
                        <option value="pumpernickel">Pumpernickel</option>
                        <option value="reeses">Reeses</option>
                    </select>
                </div>
            </div>
            <!-- by using contenteditable="true", it it gonna be like textarea but but put images also  -->
            <p style="font-size: 1.1rem;">*<span style="color:red; font-weight:bold;">WRITE</span> sentences and <span style="color:red; font-weight:bold;">DRAG&DROP</span> images to the box!</p>
            <div class="post-create" id="create_post_textarea" contenteditable="true"></div>
            <div align="right" class="post-submit-button" id="text-area">
                <input type="submit" id="submit_btn" name="submit">
            </div>
        </form>
    </div>
</body>
<script src="components/create-post.js"></script>
</html>