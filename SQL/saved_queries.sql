-- This join statement will find all 
-- questions and answers relating to a specific quiz
-- just enter the ID where the questionmark is.
SELECT * FROM `quiz` q1
INNER JOIN `quiz_question` q2
	ON q1.Quiz_id = q2.Quiz_id
INNER JOIN `question_option` q3
	ON q2.QQ_id = q3.QQ_id
WHERE q1.Quiz_id = ?;