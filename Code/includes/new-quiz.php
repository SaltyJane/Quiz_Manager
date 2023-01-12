<?php 
//only do anything if the add.php form has been submitted
if (isset($_POST['submitAdd'])) {
    // connect to DB
    require('db.php');
    // initialise amount of questions at 0
    $amount_of_questions = 0;
    // add each question to the DB in a loop, using the amount of questions
    if (isset( $_POST['question-amount'])) {
        $amount_of_questions = $_POST['question-amount'];
    }

    $quiz_title = $_POST['Quiz_title'];

    //add quiz title to the DB
    $add_quiz = $conn -> prepare("INSERT INTO `quiz` (`Quiz_title`, `Quiz_qu_amount`)
                                VALUES (?, ?);");
    $add_quiz -> bind_param('si', $quiz_title, $amount_of_questions);
    $add_quiz -> execute();
    $add_quiz -> close();

    // get the ID of the quiz I just added, so I can link the questions to it
    $last_inserted_id = mysqli_query($conn,  "SELECT MAX(Quiz_id) as max_id FROM `quiz`;");
    $last_inserted = $last_inserted_id->fetch_assoc();
    
    $last_inserted =  $last_inserted['max_id'];

    // parent loop for adding the questions to the DB
    for ($i = 0; $i < $amount_of_questions; $i++) {
        $question_number = $i + 1;
        $quiz_id = $last_inserted;
        $question_text = '';

        // check if the post is set before assigning its value
        if (isset($_POST["Question{$question_number}"])){
            $question_text = $_POST["Question{$question_number}"];
        }

        // prepared statement for adding the questions to the DB
        $add_question = $conn -> prepare("INSERT INTO `quiz_question` (`Quiz_id`, `QQ_text`) 
                                        VALUES ( ?, ? );");
        $add_question -> bind_param('is', $quiz_id, $question_text);
        $add_question -> execute();
        $add_question -> close();

        // get the ID of the question that was just added to use below
        $last_inserted_qq = mysqli_query($conn,  "SELECT MAX(QQ_id) as max_qq FROM `quiz_question`;");
        $last_insert_qq = $last_inserted_qq->fetch_assoc();
        
        $last_insert_qq =  $last_insert_qq['max_qq'];

        // count the amount of options in the nested loop, init 0 here
        $amount_of_options = 0;
        // nested loop to add the answers to the DB
        for ($j = 0; $j < 5; $j++ ) {
            // set variables
            $option_number = $j + 1;
            $isCorrect;
            $option_text = '';
            $question_id = $last_insert_qq;
            // the first option will always be the correct answer for the form.
            if ($j == 0) {
                $isCorrect = 1;
            } else {
                $isCorrect = 0;
            }
            //check if the option in the loop is set and not empty before adding it to the database
            if (isset($_POST["Question{$question_number}-choice{$option_number}"]) 
                        && !empty($_POST["Question{$question_number}-choice{$option_number}"])){
                // increment the amount of options counter
                $amount_of_options++;
                $option_text = $_POST["Question{$question_number}-choice{$option_number}"];

                // prepared statement which adds each answer to the DB
                $add_option = $conn -> prepare("INSERT INTO `question_option` (`QQ_id`, `QO_text`, `QO_isCorrect`)
                                            VALUES (?, ?, ?);");
                $add_option -> bind_param('isi', $question_id, $option_text, $isCorrect);
                $add_option -> execute();
                $add_option -> close();
            } // end if post is set and not empty

            
        } // end FOR j
        // update the quiz question table to include the amount of answer options
        $update_QQ = $conn -> prepare("UPDATE `quiz_question` SET `QQ_answerAmt` = ? WHERE `quiz_question`.`QQ_id` = ?");
        $update_QQ -> bind_param('ii', $amount_of_options, $question_id);
        $update_QQ -> execute();
        $update_QQ -> close();
    } // end FOR i
    // redirect to home page when done
    header("location: ../home.php?quiz=added");
    exit();
// if form not submitted, redirect to home page
} else {
    header("location: ../home.php");
    exit();
}