-- CREATE DATABASE chat_service;
USE chat_service;

CREATE TABLE user
(
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(50) NOT NULL,
	user_password VARCHAR(30) NOT NULL,
	first_name VARCHAR(100),
	last_name VARCHAR(100)
);
DROP TABLE user;
TRUNCATE TABLE user;
INSERT INTO user(email, user_password, first_name, last_name) 
VALUES ('nahid204@gmail.com', 'abcd', 'Nahid' , 'Ferdous');
SELECT LAST_INSERT_ID();
SELECT * FROM user;

TRUNCATE TABLE message;
DROP TABLE message;
CREATE TABLE message
(
message_id INT PRIMARY KEY AUTO_INCREMENT,
epoch INT UNSIGNED ,
sender_id INT,
receiver_id INT,
message VARCHAR(500)
);

INSERT INTO message(epoch, sender_id, receiver_id, message) 
VALUES (UNIX_TIMESTAMP(), 1, 2 ,'Hello');

SELECT * FROM message;