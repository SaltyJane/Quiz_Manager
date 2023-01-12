-- Populate with the first example quiz, a general knowledge quiz
INSERT INTO Quiz_Manager.quiz (Quiz_title, Quiz_qu_amount, Quiz_isRetired) VALUES ("General Knowledge", 3, 0);

-- insert the questions
INSERT INTO Quiz_Manager.quiz_question (Quiz_id, QQ_text, QQ_answerAmt) VALUES
	(1, "In which part of your body would you find the cruciate ligament?", 4),
    (1, "What element is denoted by the chemical symbol Sn in the periodic table?", 4),
    (1, "How many of Henry VIII's wives were called Catherine?", 4);
    
-- insert the answers
INSERT INTO Quiz_Manager.question_option (QQ_id, QO_text, QO_isCorrect) VALUES
	-- quiz1 question1 answers 
	(1, "Knee", 1),
    (1, "Elbow", 0),
    (1, "Spine", 0),
    (1, "Ankle", 0),
    -- quiz1 question2 answers
    (2, "Tin", 1),
    (2, "Sodium", 0),
    (2, "Sulfur", 0),
    (2, "Copper", 0),
    -- quiz1 question3 answers
    (3, "3", 1),
    (3, "2", 0),
    (3, "1", 0),
    (3, "4", 0);

-- Populate with the second quiz, a pokemon quiz
INSERT INTO Quiz_Manager.quiz (Quiz_title, Quiz_qu_amount, Quiz_isRetired) VALUES ("Pokemon", 3, 0);

-- insert the questions
INSERT INTO Quiz_Manager.quiz_question (Quiz_id, QQ_text, QQ_answerAmt) VALUES 
    (2, "What is the name of the starting town in the original Pokemon?", 4),
    (2, "Who was the original bonus Pokemon?", 4),
    (2, "How many steps do you get in the Safari Zone?", 4);

-- insert the answers
INSERT INTO Quiz_Manager.question_option (QQ_id, QO_text, QO_isCorrect) VALUES
    -- quiz2 question1 answers
    (4, 'Pallett', 1),
    (4, 'Veridion', 0),
    (4, 'Mt Moon', 0),
    (4, 'Lavender', 0),
    -- quiz2 question2 answers
    (5, 'Mew', 1),
    (5, 'Mewtwo', 0),
    (5, 'Zapdos', 0),
    (5, 'Pikachu', 0),
    -- quiz2 question3 answers
    (6, '500', 1),
    (6, '1500', 0),
    (6, '1000', 0),
    (6, '3', 0);

-- Populate with the second quiz, a geography quiz
INSERT INTO Quiz_Manager.quiz (Quiz_title, Quiz_qu_amount, Quiz_isRetired) VALUES ("Geography", 5, 0);

-- insert the questions
INSERT INTO Quiz_Manager.quiz_question (Quiz_id, QQ_text, QQ_answerAmt) VALUES 
    (3, "What is the capital city of Australia?", 5),
    (3, "What language is spoken in Brazil?", 3),
    (3, "In which US state would you find Fort Knox?", 5)
    (3, "What percentage of the River Nile is located in Egypt?", 5)
    (3, "Which city currently has the highest population in the world?", 5);

-- insert the answers
INSERT INTO Quiz_Manager.question_option (QQ_id, QO_text, QO_isCorrect) VALUES
    -- quiz3 question1 answers
    (7, 'Canberra', 1),
    (7, 'Sydney', 0),
    (7, 'Melbourne', 0),
    (7, 'Brisbane', 0),
    (7, 'Darwin', 0),
    -- quiz3 question2 answers
    (8, 'Portuguese', 1),
    (8, 'Spanish', 0),
    (8, 'English', 0),
    -- quiz3 question3 answers
    (9, 'Kentucky', 1),
    (9, 'Tennessee', 0),
    (9, 'Missouri', 0),
    (9, 'Illinois', 0),
    (9, 'Florida', 0),
    -- quiz3 question4 answers
    (10, '22', 1),
    (10, '53', 0),
    (10, '78', 0),
    (10, '99', 0),
    (10, '8', 0),
    -- quiz3 question5 answers
    (11, 'Tokyo', 1),
    (11, 'Jakarta', 0),
    (11, 'Chongqing', 0),
    (11, 'Delhi', 0)
    (11, 'Shanghai', 0);