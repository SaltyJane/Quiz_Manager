-- Create the database
CREATE DATABASE `Quiz_Manager`;

-- Create the Quiz table
CREATE TABLE Quiz_Manager.Quiz (
    -- create an ID for each quiz as primary key
    -- this auto-increments so that we don't 
    -- have to keep checking what the last ID was
	Quiz_id int PRIMARY KEY AUTO_INCREMENT,
    -- each quiz has a title
    Quiz_title varchar(255),
    -- and an amount of questions
    Quiz_qu_amount int(11), 
    -- checks if the quiz has been deleted
    Quiz_isRetired tinyint
);

-- Create the Quiz_Question table, which holds the questions
CREATE TABLE Quiz_Manager.Quiz_Question (
    -- use another auto-incrementing primary key ID
	QQ_id int PRIMARY KEY AUTO_INCREMENT,
    -- each question should have a foreign 
    -- key referencing the quiz it belongs to
    Quiz_id int,
    -- each question has text and an amount of answers
    QQ_text varchar(255),
    QQ_answerAmt int(11),
    -- make the above Quiz_id a foreign key
    FOREIGN KEY (Quiz_id) REFERENCES Quiz(Quiz_id)
);

-- Create table Question_Option which holds the answers to questions
CREATE TABLE Quiz_Manager.Question_Option (
    -- auto-incrementing primary key ID
	QO_id int PRIMARY KEY AUTO_INCREMENT,
    -- reference the question it belongs to
    QQ_id int,
    -- answer text 
    QO_text varchar(255),
    -- records which multiple-choice answer is correct
    QO_isCorrect tinyint,
    -- make the above QQ_id a foreign key 
    FOREIGN KEY (QQ_id) REFERENCES Quiz_Question(QQ_id)
);

-- Create the User table
CREATE TABLE Quiz_Manager.User (
    -- users have a username, password, and permission level
    U_username VARCHAR(255) PRIMARY KEY,  
    U_password VARCHAR(255), 
    U_auth VARCHAR(25)
);

