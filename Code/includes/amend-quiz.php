<?php 
//only do anything if the add.php form has been submitted
if (isset($_POST['submitEdit'])) {
    if (isset($_GET['id'])){
        // save quiz id to variable, then require db connection
        $Quiz_id = $_GET['id'];
        require('db.php');

        // get all QQ_ids which relate to the selected Quiz_id
        $qq_ids = array();
        $get_QQid = $conn -> prepare("SELECT * FROM `quiz_question` WHERE `Quiz_id` = ?;");
        $get_QQid -> bind_param('i', $Quiz_id);
        $get_QQid -> execute();
        $result_array = $get_QQid->get_result();
        // push each QQ_id into the empty array on line 10
        while($row = $result_array->fetch_assoc()){
            array_push($qq_ids, $row['QQ_id']);
        }
        // close the connection
        $get_QQid -> close();

        // then delete the related questions and options below
        // I've done this so that the foreign key won't falsely relate to a question if the user
        // has changed the text to something completely different.
        foreach($qq_ids as $qq_id){        
            $del_QQ = $conn -> prepare("DELETE FROM `quiz_question` WHERE `QQ_id` = ?");
            $del_QQ -> bind_param('i', $qq_id);
            $del_QQ -> execute();
            $del_QQ -> close();        
        }


    // re-add entire quiz

        // re-get the amount of questions from the hidden input
        $amount_of_questions = 0;
        if (isset( $_POST['question-amount'])) {
            $amount_of_questions = $_POST['question-amount'];
        }

        $quiz_title = $_POST['Quiz_title'];

        //add quiz title
        $update_title = $conn -> prepare("UPDATE `quiz` 
                                            SET `Quiz_title`= ?,`Quiz_qu_amount`= ? 
                                        WHERE Quiz_id = ?;");
        $update_title -> bind_param('sii', $quiz_title, $amount_of_questions, $Quiz_id);
        $update_title -> execute();
        $update_title -> close();

    // parent loop for adding the questions to the DB
        for ($i = 0; $i < $amount_of_questions; $i++) {
            $question_number = $i + 1;
            $question_text = '';

            // check if the post is set before assigning its value
            if (isset($_POST["Question{$question_number}"])){
                $question_text = $_POST["Question{$question_number}"];
            }

            // prepared statement for adding the questions to the DB
            $add_question = $conn -> prepare("INSERT INTO `quiz_question` (`Quiz_id`, `QQ_text`) 
                                            VALUES ( ?, ? );");
            $add_question -> bind_param('is', $Quiz_id, $question_text);
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
        // when done, redirect to home
        header("location: ../quiz.php?id={$Quiz_id}");
        exit();
    // if no ID in url, redirect to home
    } else {
        header("location: ../home.php?noid=true");
        exit();
    }
// if form not submitted, redirect to home page
} else {
    header("location: ../home.php?noform=true");
    exit();
}