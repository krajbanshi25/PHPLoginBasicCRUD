Simple PHP Login and CRUD Project Documentation

1. Project idea
This project is a small PHP and MySQLi system for students.
It teaches how to:
- connect PHP with MySQL
- register a new user
- login with username and password
- store login data in session
- update user details
- show all users
- delete a user

This project uses simple PHP files, plain HTML, and basic CSS.
The code style is kept easy so beginners can follow it.

2. Main files in this project
db.php
- This file connects PHP to the MySQL database.
- It is included in other files using `include("db.php");`

register.php
- This file shows the registration form.
- It also inserts a new user into the database.

index.php
- This file shows the login form.

check.php
- This file checks login details from the form.
- If username and password are correct, it starts the user session.

welcome.php
- This is the page shown after successful login.
- From here, the user can go to profile update, user list, or logout.

profile.php
- This page lets the logged-in user update username and password.

users.php
- This page displays all users from the database.
- It is the Read part of CRUD.

edit_user.php
- This page updates any selected user.
- It is the Update part of CRUD.

delete_user.php
- This file deletes a selected user.
- It is the Delete part of CRUD.

logout.php
- This file removes the session and logs out the user.

style.css
- This file contains the basic design for forms, buttons, cards, and tables.

user_system.sql
- This file creates the database and users table.
- It also shows the format for adding sample records.

3. Important PHP keywords used
`session_start();`
- Starts a session.
- A session is used to remember the logged-in user.

`include("db.php");`
- Loads the database connection file into another file.

`$_POST`
- Gets values sent from an HTML form using method POST.
- Example: `$_POST["username"]`

`$_GET`
- Gets values from the URL.
- Example: `edit_user.php?id=3`

`$_SESSION`
- Stores values across different pages.
- Example: `$_SESSION["username"] = $username;`

`if`
- Used for checking a condition.
- Example: if login is correct, move to welcome page.

`header("Location: welcome.php");`
- Redirects the user to another page.

`exit();`
- Stops the script immediately.
- It is often used after `header()` redirection.

`mysqli_connect()`
- Connects PHP with MySQL database.

`mysqli_query()`
- Runs an SQL query.

`mysqli_num_rows()`
- Counts how many rows are returned from a SELECT query.

`mysqli_fetch_assoc()`
- Gets one row as an associative array.
- Example: `$row["username"]`

`mysqli_real_escape_string()`
- Helps make form input safer before using it in SQL queries.

`password_hash()`
- Converts a normal password into a hashed password.
- This is safer than storing plain text passwords.

`password_verify()`
- Checks whether the typed password matches the saved hashed password.

`htmlspecialchars()`
- Displays text safely in HTML.
- It helps prevent unwanted HTML code from showing on the page.

4. Important SQL queries in this project
Check whether username already exists:
`SELECT * FROM users WHERE username='$username'`

Insert a new user:
`INSERT INTO users (username, password) VALUES ('$username', '$password')`

Find one user for login:
`SELECT * FROM users WHERE username='$username'`

Show all users:
`SELECT id, username FROM users ORDER BY id ASC`

Update username only:
`UPDATE users SET username='$newUsername' WHERE id='$userId'`

Update username and password:
`UPDATE users SET username='$newUsername', password='$hashedPassword' WHERE id='$userId'`

Delete a user:
`DELETE FROM users WHERE id='$id'`

5. Important code lines explained simply
In db.php:
`$conn = mysqli_connect($host, $user, $pass, $dbname);`
- This line creates the database connection.

`if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }`
- If connection does not work, the program stops and shows the error.

In register.php:
`$password = password_hash($_POST["password"], PASSWORD_DEFAULT);`
- This changes the original password into a secure hashed value.

`$checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");`
- This checks whether the username already exists.

In check.php:
`if (password_verify($password, $row["password"]))`
- This checks whether the login password matches the stored hashed password.

`$_SESSION["user_id"] = $row["id"];`
- This stores the logged-in user's id.

`$_SESSION["username"] = $username;`
- This stores the logged-in username.

In welcome.php:
`if (!isset($_SESSION["username"]))`
- This protects the page.
- If user is not logged in, they are sent back to login page.

In profile.php and edit_user.php:
`if ($newPassword != "")`
- If user enters a new password, the password is updated.
- If left blank, old password is kept.

In delete_user.php:
`$deleteSql = "DELETE FROM users WHERE id='$id'";`
- This removes one user from the table.

6. CRUD meaning in this project
CRUD means:
- Create = add new user in register.php
- Read = show all users in users.php
- Update = change data in profile.php and edit_user.php
- Delete = remove user in delete_user.php

7. How to create the database manually in phpMyAdmin
Step 1:
Open XAMPP and start Apache and MySQL.

Step 2:
Open browser and go to:
http://localhost/phpmyadmin

Step 3:
Click on "New" to create a new database.

Step 4:
Enter the database name:
`user_system`

Step 5:
Click "Create".

Step 6:
Click on the `user_system` database.

Step 7:
Open the SQL tab and run this query:

`CREATE TABLE users (
	id INT(11) NOT NULL AUTO_INCREMENT,
	username VARCHAR(100) NOT NULL,
	password VARCHAR(255) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY unique_username (username)
);`

Step 8:
If you want sample data, run this:

`INSERT INTO users (username, password) VALUES
('student1', 'paste_hashed_password_here'),
('student2', 'paste_hashed_password_here');`

Note:
The `user_system.sql` file already creates the database and table.
For sample users, the easiest method is to open `register.php` and create users from the form, because the password will be hashed automatically.

8. How to run this project
Step 1:
Place the project folder inside `htdocs`.

Step 2:
Start Apache and MySQL in XAMPP.

Step 3:
Create the database using `user_system.sql` or manually in phpMyAdmin.

Step 4:
Open this URL in browser:
`http://localhost/login3/`

Step 5:
Create a new user and then login.

9. Small improvements added in this version
- Better login and register page design
- Shared CSS file for cleaner look
- Success and error messages
- Profile update page for logged-in user
- User list page
- Edit user page
- Delete user page
- SQL file for easy setup
- Safer output using `htmlspecialchars()`
- Safer input handling using `mysqli_real_escape_string()`

10. Final note
This project is simple and easy to study.
It is good for beginners who want to learn how PHP works with MySQL.
The code is not written in advanced style on purpose.
It is written in a way that students can read, test, and understand step by step.
