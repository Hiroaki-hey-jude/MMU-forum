## Notes to everyone

database\_query.php is useless (will temporary keep it for reference purpose).

## Current progress

### Backend

To-do list:

- [x] register.php
- [x] login.php
- [x] profile.php
- [x] edit\_profile.php
- [x] Search function
- [x] home.php	
	- [x] view categories
	- [x] view sub-categories
	- [x] view post list
- [x] View posts' details 	
	- [x] upvoting
	- [x] post comment
	- [x] bookmark
	- [ ] report post or comment
	- [ ] share post (generate URL)
- [x] Create post function
- [x] Create admin-login.php
- [ ] Admin functions
	- [x] Login
	- [x] Add category
	- [ ] Delete category
	- [x] Add subcategory
	- [ ] Delete subcategory
	- [ ] Manage post
	- [ ] Manage user
	

To-be fixed:

- [ ] In create-post.php, the search bar doesn't work
- [x] All fontawesome icons are not working (changed URL)
- [x] In post-details.php, cannot post some comments (e.g: Post comments like `'` will cause the submit button doesn't work) (fixed using prepared statement)
- [x] In post-details.php, the user will be redirected to localhost after posting a comment

### Frontend

To-do list:

## Installation

Just move the entire repository to the server and make sure to read install.md.
