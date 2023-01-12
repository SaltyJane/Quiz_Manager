<?php 
//only do anything if the add.php form has been submitted
if (isset($_GET['QID']) && isset($_GET['id'])) {
    // db connection is required
    require('db.php');
    // save the URL values for Quiz_id and QID to variables
    $QID = $_GET['QID'];
    $Quiz_id = $_GET['id'];

    // get current amount of questions via db
    $amount_of_questions = 0;
    $get_amt = $conn -> prepare("SELECT `Quiz_qu_amount` FROM `quiz` WHERE `Quiz_id` = ?;");
    $get_amt -> bind_param('i', $Quiz_id);
    $get_amt -> execute();
    $amt_arr = $get_amt->get_result();
        // save the amount of questions for the current quiz to a variable
        while($row = $amt_arr ->fetch_assoc()){ 
            $amount_of_questions = $row['Quiz_qu_amount'];
        }
    // close the connection
    $get_amt -> close();

    // delete the question. No need to delete its options separately as the foreign key cascades 
    $delete_QQ = $conn -> prepare("DELETE FROM `quiz_question` WHERE `QQ_id` = ?");
    $delete_QQ -> bind_param('i', $QID);
    $delete_QQ -> execute();
    $delete_QQ -> close();

    // update the amount of questions now that 1 has been deleted
    $minus_one = $amount_of_questions - 1;
    // update amount of questions in db
    $update_db = $conn -> prepare("UPDATE `quiz` SET `Quiz_qu_amount`= ? 
                                    WHERE Quiz_id = ?;");
    $update_db -> bind_param('ii', $minus_one, $Quiz_id);
    $update_db -> execute();
    $update_db -> close();

    // when done, redirect back to the edit page for the current quiz
    header("location: ../edit-quiz.php?id={$Quiz_id}");
    exit();
}
?>