<?php

$searchQuery = $conn->prepare("SELECT * from users WHERE email = ?");
$searchQuery ->bind_param("s", $email);
$searchQuery ->execute();
$user['id'] = $_SESSION['user_id'];

// USER TABLE
"CREATE TABLE user(
    user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    user_pass VARCHAR(255) NOT NULL,
    profile_pic_name VARCHAR(255) DEFAULT 'default.png',
    number_of_posts INT(6) UNSIGNED DEFAULT 0,
    number_of_comments INT(6) UNSIGNED DEFAULT 0
    );";

// CATEOGRY TABLE
"CREATE TABLE category (
    category_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
    );";

// SUBCATEGORY TABLE
"CREATE TABLE subcategory (
    subcategory_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subcategory_name VARCHAR(255) NOT NULL,
    category_id INT(6) UNSIGNED NOT NULL,
    number_of_posts INT(6) NOT NULL DEFAULT 0,
    number_of_comments INT(6) NOT NULL DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE CASCADE
    );";

// POST TABLE
"CREATE TABLE post (
    post_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id INT(6) UNSIGNED NOT NULL,
    subcategory_id INT(6) UNSIGNED NOT NULL ,
    post_name VARCHAR(255) NOT NULL,
    post_description TEXT NOT NULL,
    image_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    number_of_comments INT(6) DEFAULT 0 NOT NULL,
    number_of_likes INT(6) DEFAULT 0 NOT NULL,
    FOREIGN KEY (subcategory_id) REFERENCES subcategory(subcategory_id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES user(user_id) ON DELETE CASCADE
    );";

// COMMENT TABLE
"CREATE TABLE comment (
    comment_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    commenter_id INT(6) UNSIGNED NOT NULL,
    post_id INT(6) UNSIGNED NOT NULL,
    comment_description TEXT NOT NULL,
    comment_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    number_of_likes INT(6) NOT NULL DEFAULT 0,
    FOREIGN KEY (commenter_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES post(post_id) ON DELETE CASCADE
    );";

// LIKE TABLE
"CREATE TABLE `like` (
    like_id INT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    post_id INT(6) UNSIGNED NOT NULL,
    comment_id INT(6) UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES post(post_id) ON DELETE CASCADE,
    FOREIGN KEY (comment_id) REFERENCES comment(comment_id) ON DELETE CASCADE
);";

// BOOKMARK TABLE
"CREATE TABLE bookmark (
    bookmark_id INT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    post_id INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES post(post_id) ON DELETE CASCADE
);";

// Trigger to update number of post
"CREATE TRIGGER increase_number_of_posts_in_user
AFTER INSERT ON post FOR EACH ROW
    UPDATE user SET number_of_posts = number_of_posts + 1 WHERE user_id = NEW.author_id;";

"CREATE TRIGGER decrease_number_of_posts_in_user AFTER DELETE ON 
`post` FOR EACH ROW UPDATE `user` SET 
`number_of_posts` = `number_of_posts` - 1 WHERE `user_id` = `OLD`.`author_id`;";

// Trigger to update number of likes
"CREATE TRIGGER increase_number_of_comments_in_user AFTER INSERT ON 
`comment` FOR EACH ROW UPDATE `user` SET 
`number_of_comments` = `number_of_comments` + 1 WHERE `user_id` = `NEW`.`commenter_id`;";

"CREATE TRIGGER decrease_number_of_comments_in_user AFTER DELETE ON 
`comment` FOR EACH ROW UPDATE `user` SET 
`number_of_comments` = `number_of_comments` - 1 WHERE `user_id` = `OLD`.`commenter_id`;";

// Trigger to update number of post
"CREATE TRIGGER increase_number_of_posts_in_subcategory AFTER INSERT ON 
    post FOR EACH ROW UPDATE subcategory SET 
    number_of_posts = number_of_posts + 1 WHERE subcategory_id = NEW.subcategory_id;";

"CREATE TRIGGER decrease_number_of_posts_in_subcategory AFTER DELETE ON 
    `post` FOR EACH ROW UPDATE `subcategory` SET 
    `number_of_posts` = `number_of_posts` - 1 WHERE `subcategory_id` = `OLD`.`subcategory_id`;";

// Trigger to update number of comments
"CREATE TRIGGER increase_number_of_comments_in_subcategory AFTER INSERT ON 
    `comment` FOR EACH ROW UPDATE `subcategory` SET 
    `number_of_comments` = `number_of_comments` + 1 WHERE `subcategory_id` = 
    (SELECT `subcategory_id` FROM `post` WHERE `NEW`.`post_id` = `post_id`);";

"CREATE TRIGGER decrease_number_of_comments_in_subcategory AFTER DELETE ON 
    `comment` FOR EACH ROW UPDATE `subcategory`  SET 
    `number_of_comments` = `number_of_comments` - 1 WHERE `subcategory_id` = 
    (SELECT `subcategory_id` FROM `post` WHERE `OLD`.`post_id` = `post_id`);";

// Trigger to update number of comments
"CREATE TRIGGER increase_number_of_comments_in_post AFTER INSERT ON 
`comment` FOR EACH ROW UPDATE `post` SET 
`number_of_comments` = `number_of_comments` + 1 WHERE `post_id` = `NEW`.`post_id`;";

"CREATE TRIGGER decrease_number_of_comments_in_post AFTER DELETE ON 
`comment` FOR EACH ROW UPDATE `post` SET 
`number_of_comments` = `number_of_comments` - 1 WHERE `post_id` = `OLD`.`post_id`;";

// Trigger to update number of likes
"CREATE TRIGGER increase_number_of_likes_in_post AFTER INSERT ON 
`like` FOR EACH ROW UPDATE `post` SET 
`number_of_likes` = `number_of_likes` + 1 WHERE `post_id` = `NEW`.`post_id` AND `NEW`.`comment_id` IS NULL;";

"CREATE TRIGGER decrease_number_of_likes_in_post AFTER DELETE ON 
`like` FOR EACH ROW UPDATE `post` SET 
`number_of_likes` = `number_of_likes` - 1 WHERE `post_id` = `OLD`.`post_id` AND `OLD`.`comment_id` IS NULL;";

// Trigger to update number of likes
"CREATE TRIGGER increase_number_of_likes_in_comment AFTER INSERT ON 
`like` FOR EACH ROW UPDATE `comment` SET 
`number_of_likes` = `number_of_likes` + 1 WHERE `comment_id` = `NEW`.`comment_id`;";

"CREATE TRIGGER decrease_number_of_likes_in_comment AFTER DELETE ON 
`like` FOR EACH ROW UPDATE `comment` SET 
`number_of_likes` = `number_of_likes` - 1 WHERE `comment_id` = `OLD`.`comment_id`;";

// data insertion
"INSERT INTO category (category_name) VALUES 
    ('GENERAL'),
    ('Faculty of Computing and Informatics (FCI)'),
    ('Faculty of Engineering (FOE) & Faculty of Engineering & Technology (FET)'),
    ('Faculty of Management (FOM) & Faculty of Business (FOB)'),
    ('Faculty of Creative Multimedia (FCM)'),
    ('Faculty of Applied Communication (FAC)'),
    ('Faculty of Cinematic Arts (FCA)'),
    ('Faculty of Information Science and Technology (FIST)'),
    ('Faculty of Law (FOL)');
    ";

"INSERT INTO subcategory (subcategory_name, category_id) VALUES 
    ('Annoucement' , 1),
    ('Club Activities' , 1),
    ('Feedback and Helpdesk' , 1),
    ('Admission & Enrollment' , 1),
    ('Hostel Discussion' , 1),
    ('FYP Topic Dicussion' , 1),
    ('FAQ' , 1),
    ('Computer Science in General', 2),
    ('Programming', 2),
    ('Data Science', 2),
    ('Software Engineering', 2),
    ('Artificial Intelligence (AI)', 2),
    ('Cybersecurity', 2),
    ('Foundation in Engineering', 3),
    ('Electrical Engineering', 3),
    ('Electronics Engineering', 3),
    ('Mechanical Engineering', 3),
    ('Engineering Mathematics', 3),
    ('Nanotechnology', 3),
    ('Foundation in Management', 4),
    ('Foundation in Business', 4),
    ('Finance & Ecnomics', 4),
    ('Accounting', 4),
    ('Marketing', 4),
    ('Business Administration', 4),
    ('Digital Enterprise', 4),
    ('Banking and Finance', 4),
    ('Foundation in Creative Multimedia', 5),
    ('Advertising Design', 5),
    ('Animination', 5),
    ('Interface Design', 5),
    ('Media Arts', 5),
    ('Visual Effects', 5),
    ('Virtual Reality', 5),
    ('Foundation in Communication', 6),
    ('Applied Communication', 6),
    ('Strategic Communication', 6),
    ('Media Culture', 6),
    ('Foundation in Cinematic Arts', 7),
    ('Creative Producing', 7),
    ('Cinematography', 7),
    ('Cinematic Arts', 7),
    ('Movie Production', 7),
    ('Foundation in Information Technology', 8),
    ('Bioinformatics', 8),
    ('Security Technology', 8),
    ('Artificial Intelligence (AI)', 8),
    ('Information System and Technology', 8),
    ('Foundation in Law', 9),
    ('Bachelor of Law', 9),
    ('Contract Law', 9),
    ('Islamic Law', 9),
    ('Land Law', 9),
    ('Things on Court', 9);
    ";



// insert new user
"INSERT INTO user (username, email, user_pass) VALUES 
    ('FCIstudent1', 'fci01@gmail.com', '123456')
    ;";

// insert new post
"INSERT INTO post (author_id, subcategory_id, post_name, post_description, image_name) VALUES 
    (1, 2, 'Testing', 'this should be a description of the testing post', '');
";

// insert new comment
"INSERT INTO comment (commenter_id, post_id, comment_description) VALUES 
    (1, 4, 'This is a example of comment')
    ;";

// insert new like for post
"INSERT INTO `like` (user_id, post_id) VALUES 
    (1, 4);";

// insert new like for comment
"INSERT INTO `like` (user_id, post_id, comment_id) VALUES 
    (1, 4, 2)
    ;";

// if the comment_id is 0, mean user like the post. If user like a comment, the entry will have comment_id and post_id
// ------------------Queries--------------------
$user_id = $user['id'];
$post_id = 1;
$comment_id = 1;
$subcategory_id = 1;

// ............Queries for homepage............
$category = array();
$query_get_all_category = "SELECT * FROM category WHERE;";
$result = mysqli_query($conn, $query_get_all_category);

while ($row = mysqli_fetch_assoc($result)) {
    $category[] = $row;
}

// List category and subcategory
$subcategory = array();
$query_get_all_subcategory = "SELECT * FROM subcategory WHERE '
`subcateogry`.`category_id` = ". "$category[$i]['id']" . ";";
$result = mysqli_query($conn, $query_get_all_subcategory);

while ($row = mysqli_fetch_assoc($result)) {
    $subcategory[] = $row;
}

// loop to echo all the category and subcategory out
for ($i = 0; $i < count($category); $i++) {
    echo "<h1>" . $category[$i]['id'] . "<h1>";
    for($j = 0; $j < count($subcategory); $j++) { 
        if($category[$i]['id'] == $subcategory[$j]['category_id']) {
            echo "<h2>" . $subcategory[$j]['category_id'] . "<h2>";
        }
    }
}

// Query to show post list (after clicking into a subcategory)
$post_list = array();
$query_get_to_get_post = "SELECT `post_id`, `author_id`, `post_name`, `created_at`,
                         `number_of_cooments`, `number_of_likes` , `pinned` FROM post 
                        WHERE `subcategory_id` = `$subcategory_id`;";

// search post
$search_criteria = "test";
$query_get_to_get_posts_from_search = "SELECT `post_id`, `author_id`, `post_name`, `created_at`,
    `number_of_cooments`, `number_of_likes` , `pinned` FROM post WHERE 
    `post_description` LIKE '%$search_criteria%' OR `post_name` LIKE '%$search_criteria%';";

$result = mysqli_query($conn, $query_get_to_get_post);

while ($row = mysqli_fetch_assoc($result)) {
    $post_list[] = $row;
}

$post_per_page = 10; 
for ($i = 0; $i < count($post_list); $i++) {
    $current_post_number = $post_per_page * $currentPage;
    echo $post_list[$current_post_number + $i];
};

// ...........Queries when viewing a post..............
// view particular post
$query_to_view_post = "SELECT * FROM post WHERE post_id = $post_id";

// Check if he is the author of this post
$query_check_if_is_author = "SELECT `post_id` FROM `post` WHERE
    post_id = $post_id AND author_id = $user_id";

// Query to check if the user already like this post
$query_to_check_liked_post = "SELECT `like_id` FROM `like` WHERE user_id =" . 
                        $user["id"] . " AND post_id = $post_id" ;

// check if this (current logged in) user already like this comment
$query_to_check_liked_comment = "SELECT `like_id` FROM `like` WHERE user_id = " . $user_id . " AND 
                        post_id = $post_id AND commentID = $comment_id" ;

$result = mysqli_query($link, $query_to_check_liked);

if (mysqli_num_rows($result) > 0) {
    $Liked = True;
} else {
    $Liked = False;
}

// like post
"INSERT INTO `like` (user_id, post_id) VALUES ($user_id, $post_id);";
// like comment
"INSERT INTO `like` (user_id, post_id, comment_id) VALUES ($user_id, $post_id, 0);";
// delete like from post
"DELETE FROM like WHERE post_id = $post_id AND comment_id = 0;";
// delete like from comment
"DELETE FROM like WHERE post_id = $post_id AND comment_id = $comment_id;";

// ---------------------For references---------------------
// check if this record is exist
/* use case 
    1. check user liked this post
    2. if the user is the author of this post
    3. if user exist (login)
*/
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0) {
    $exist = True;
} else {
    $exist = False;
}

// Store everything into a list and echo it out
/* use case
    1. list all category and subcategory
    2. list all posts in that subcategory
    3. list all posts that fit the search text
*/
$result = mysqli_query($conn, $query_get_to_get_post);

while ($row = mysqli_fetch_assoc($result)) {
    echo $row; 
    // $post_list[] = $row;
}

for ($i = 0; $i < count($post_list); $i++) {
    $current_post_number = $post_per_page * $currentPage;
    echo $post_list[$current_post_number + $i];
};

?>