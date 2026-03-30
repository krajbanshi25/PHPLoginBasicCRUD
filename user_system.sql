CREATE DATABASE IF NOT EXISTS user_system;
USE user_system;

CREATE TABLE IF NOT EXISTS users (
	id INT(11) NOT NULL AUTO_INCREMENT,
	username VARCHAR(100) NOT NULL,
	password VARCHAR(255) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY unique_username (username)
);

-- Add sample users by using register.php in the browser,
-- because that page automatically hashes the password safely.
--
-- If you want to insert users manually, use this format:
-- INSERT INTO users (username, password) VALUES
-- ('student1', 'paste_password_hash_here'),
-- ('student2', 'paste_password_hash_here');
