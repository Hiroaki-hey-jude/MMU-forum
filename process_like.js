function process_like (user_id, post_id, comment_id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process_like.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Pass variables in the form of a query string
    var queryString = "user_id=" + user_id + "&post_id=" + post_id + "&comment_id=" + comment_id;
    xhr.send(queryString);
}