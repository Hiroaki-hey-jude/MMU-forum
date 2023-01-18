function process_like (ids) {
    user_id = ids[0];
    post_id = ids[1];
    comment_id = ids[2];

    if(user_id == null) {
        window.alert("Please log in first");
    } else {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "process_like.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if(response === 'success'){
                    // alert('Record Inserted successfully');
                    if(comment_id == 0 ) {
                        nOfLikes = parseInt(document.getElementById("post-number-of-likes").innerHTML);
                        nOfLikes += 1;
                        document.getElementById("post-number-of-likes").innerHTML = nOfLikes;
                        document.getElementById("post-like-icon").className = "post-action-icon liked fas fa-thumbs-up";
                    } else {
                        nOfLikes = parseInt(document.getElementById("comment-"+comment_id+"-number-of-likes").innerHTML);
                        nOfLikes += 1;
                        document.getElementById("comment-"+comment_id+"-number-of-likes").innerHTML = nOfLikes;
                        document.getElementById("comment-"+comment_id+"-like-icon").className = "post-action-icon liked fas fa-thumbs-up";
                    }
                } else if(response === 'unlike'){
                    // alert('unliking this thing');
                    if(comment_id == 0 ) {
                        nOfLikes = parseInt(document.getElementById("post-number-of-likes").innerHTML);
                        nOfLikes -= 1;
                        document.getElementById("post-number-of-likes").innerHTML = nOfLikes;
                        document.getElementById("post-like-icon").className = "post-action-icon fas fa-thumbs-up";
                    } else {
                        nOfLikes = parseInt(document.getElementById("comment-"+comment_id+"-number-of-likes").innerHTML);
                        nOfLikes -= 1;
                        document.getElementById("comment-"+comment_id+"-number-of-likes").innerHTML = nOfLikes;
                        document.getElementById("comment-"+comment_id+"-like-icon").className = "post-action-icon fas fa-thumbs-up";
                    }
                } else{
                    alert('Error inserting record1');
                }
            }
        }
        // Pass variables in the form of a query string
        if(comment_id == "0") {
            var queryString = "user_id=" + user_id + "&post_id=" + post_id + "&comment_id=" + comment_id;
        } else {
            var queryString = "user_id=" + user_id + "&post_id=" + post_id + "&comment_id=" + comment_id;
        }
        xhr.send(queryString);
    }
}

function process_comment(ids) {
    user_id = ids[0];
    post_id = ids[1];
    comment_description = document.getElementById("post-comment-input").value;
    if(user_id == null) {
        window.alert("Please log in first");
    } 
    else if(comment_description == '') {
        window.alert("You must comment something!")
    }
    else {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "process_comment.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if(response === 'success'){
                    // alert('Comment successfully');
                    location.reload();
                }
                else if(response === 'error'){
                    alert('Error');
                } else{
                    alert('Error inserting record1');
                }
            }
        }
        
        // Pass variables in the form of a query string
        var queryString = "user_id=" + user_id + "&post_id=" + post_id +"&comment=" + comment_description;
        xhr.send(queryString);
    }
}

function process_bookmark (ids) {
    user_id = ids[0];
    post_id = ids[1];
    if(user_id == null) {
        window.alert("Please log in first");
    } 
    else {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "process_bookmark.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if(response === 'success'){
                    // alert('Bookmarked successfully');
                    document.getElementById("bookmark-icon").className = "post-action-icon bookmarked fas fa-bookmark"
                }
                else if(response === 'unbookmark'){
                    // alert('Unbookmarked successfuly');
                    document.getElementById("bookmark-icon").className = "post-action-icon fas fa-bookmark"
                } else if(response === 'error' || response === 'error2' ){
                    alert('Error inserting record');
                } else {
                    alert("Error inserting record");
                }
            }
        }
        
        // Pass variables in the form of a query string
        var queryString = "user_id=" + user_id + "&post_id=" + post_id;
        xhr.send(queryString);
    }
}
