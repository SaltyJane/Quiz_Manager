<?php 
// start the session
session_start();
// et the title
$title = "Edit a quiz"; 
// include header
include_once("includes/header.php");
// only show the page if the user is logged in and has Edit permissions
if ((session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION["login_user"])) && ($_SESSION["permission"] == "Edit")){
    // can only edit a test if the ID tells us which one to edit
    if(isset($_GET['id'])) {
        // save the id to a variable
        $Quiz_id = $_GET['id'];
        // initialise variables so that I can assign them
        // within a while loop
        $isRetired = false;
        $quiz_title;
        $amount_of_questions = 0;
        $question_num = 0;
        // connect to db required
        require("includes/db.php");
        // prepared statement to get the quiz details
        $get_quiz = $conn -> prepare("SELECT * FROM `quiz` WHERE `Quiz_id` = ?;");
        $get_quiz -> bind_param('i', $Quiz_id);
        $get_quiz -> execute();
        $quiz_arr = $get_quiz->get_result();
        // save the data from DB to variables
        while($row = $quiz_arr ->fetch_assoc()){ 
            $quiz_title = $row['Quiz_title'];
            $amount_of_questions = $row['Quiz_qu_amount'];
            if($row['Quiz_isRetired'] == 1){
                $isRetired = true;
            } else {
                $isRetired = false;
            }
        }
        $get_quiz -> close();
        // don't allow editing of quizzes marked as retired
        if ($isRetired){
            header("location: home.php");
            exit();
        }
?>

<div class="container-fluid bg-light-grey height-100">
    <!-- centered heading with top and bottom padding -->
    <h1 class="text-center text-lg-start py-4">Edit quiz - "<?php echo $quiz_title; ?>"</h1>
    <!-- section break to separate the heading from the content -->
    <hr class="mt-2 mb-5">

    <!-- begin form, with action and method -->
    <form method="post" action="includes/amend-quiz.php?id=<?php echo $Quiz_id; ?>">
        <!-- Separate container for the quiz title -->
        <div class="card pt-4 mb-2 px-3">
            <div class="form-group">
                <label for="Quiz_title">Quiz title</label>
                <input type="text" name="Quiz_title" id="Quiz_title" value="<?php echo $quiz_title;?>" required>
            </div>
        </div>
        <div id="all-questions">
<?php // prepared statement to get each question title
        $get_question_title = $conn -> prepare("SELECT * FROM `quiz_question` WHERE `Quiz_id` = ?;");
        $get_question_title -> bind_param('i', $Quiz_id);
        $get_question_title -> execute();
        $question_arr = $get_question_title->get_result();
        // loop through all questions in the quiz 
        while($row = $question_arr ->fetch_assoc()){
            // update the question number variable
            $GLOBALS['question_num']++;
            // save the data to variables so I can use them
            // within the nested loop which comes later
            $question_id = $row['QQ_id'];
            $question_text = $row['QQ_text'];
            $amount_of_answers = $row['QQ_answerAmt'];?>

            <div class="question-container card p-3 m-3">
                <div class="form-group question-title">
                    <label for="Question<?php echo $GLOBALS['question_num'];?>">Question title</label>
                    <input class="question-title" type="text" name="Question<?php echo $GLOBALS['question_num'];?>" id="Question<?php echo $GLOBALS['question_num'];?>" value="<?php echo $question_text;?>" required>
                </div>
                <div class="ml-3">
                
<?php       // prepared statement to get all the answer options for the current question
            $get_question_choices = $conn -> prepare("SELECT * FROM `question_option` WHERE `QQ_id` = ?;");
            $get_question_choices -> bind_param('i', $question_id);
            $get_question_choices -> execute();
            $option_arr = $get_question_choices->get_result();

            $option_num = 0;
            while($optionRow = $option_arr ->fetch_assoc()){
                $option_num++;
                $option_text = $optionRow['QO_text'];?>
                    <div class="form-group">
<?php           // if the current option in the loop is correct it will have different html
                if ($optionRow['QO_isCorrect']) {?>
                        <label for="Question<?php echo $GLOBALS['question_num'];?>-choice1">Correct answer</label>
                        <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice1" id="Question<?php echo $GLOBALS['question_num'];?>-choice1" value="<?php echo $optionRow['QO_text'];?>" required>
<?php           // else do them as normal options
                } else { 
                    // nested IF to ensure that options 4 and 5 remain optional fields
                    if($option_num <= 3){ ?>
                        <label for="Question<?php echo $GLOBALS['question_num'];?>-choice<?php echo $option_num;?>">Wrong answer <?php echo ($option_num -1);?></label>
                        <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice<?php echo $option_num;?>" id="Question<?php echo $GLOBALS['question_num'];?>-choice<?php echo $option_num;?>" value="<?php echo $optionRow['QO_text'];?>" required>
<?php               // if the question has 
                    } elseif ($option_num > 3 && !empty($optionRow['QO_text'])) { ?>
                        <label for="Question<?php echo $GLOBALS['question_num'];?>-choice<?php echo $option_num;?>">(optional) Wrong answer <?php echo ($option_num -1);?></label>
                        <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice<?php echo $option_num;?>" id="Question<?php echo $GLOBALS['question_num'];?>-choice<?php echo $option_num;?>" value="<?php echo $optionRow['QO_text'];?>">
<?php               }   // end IF option num < 3
                } // end IF option is correct?>
                    <!-- end div.form-group -->
                    
                </div>  
<?php           } $get_question_choices -> close();// end while $optionRow 
                // if the question only has 3 answers, add 2 empty optional inputs 
                
                if ($amount_of_answers == 3) { ?>
                        <div class="form-group">
                            <label for="Question<?php echo $GLOBALS['question_num'];?>-choice4">(optional) Wrong answer 3</label>
                            <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice4" id="Question<?php echo $GLOBALS['question_num'];?>-choice4">
                        </div>
                        <div class="form-group">
                            <label for="Question<?php echo $GLOBALS['question_num'];?>-choice5">(optional) Wrong answer 4</label>
                            <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice5" id="Question<?php echo $GLOBALS['question_num'];?>-choice5">
                        </div>
<?php           // if the question has 4 answers, we only need 1 empty optional input
                } elseif ($amount_of_answers == 4) { ?>
                        <div class="form-group">
                            <label for="Question<?php echo $GLOBALS['question_num'];?>-choice5">(optional) Wrong answer 4</label>
                            <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice5" id="Question<?php echo $GLOBALS['question_num'];?>-choice5">
                        </div>
<?php           } ?>
                </div>
                <!-- end div.ml-3 -->
                <!-- Button to delete the question -->
                <p class="hint-text text-danger">Warning: if you delete a question using the button below, the page will refresh and lose any unsaved edits.</p>
                <a class="btn btn-danger" onclick="javascript: return confirm('Are you sure you want to delete this question permanently?');" href="includes/delete-question.php?QID=<?php echo $question_id;?>&id=<?php echo $Quiz_id; ?>">Delete this question</a>
            <!-- end div.question-container -->
            </div>
<?php       } $get_question_title -> close();// end while $row  ?>

<!-- area here for while amt of questions < 3 add the html -->
<?php       while ($amount_of_questions < 3){ 
                // increment the variables so that my loop is not infinite
                $amount_of_questions++;
                $GLOBALS['question_num']++; ?>
            <div class="question-container card p-3 m-3">
                <div class="form-group question-title">
                    <label for="Question<?php echo $GLOBALS['question_num'];?>">Question title</label>
                    <input class="question-title" type="text" name="Question<?php echo $GLOBALS['question_num'];?>" id="Question<?php echo $GLOBALS['question_num'];?>" required>
                </div>
                <div class="ml-3">
                    <div class="form-group">
                        <label for="Question<?php echo $GLOBALS['question_num'];?>-choice1">Correct answer</label>
                        <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice1" id="Question<?php echo $GLOBALS['question_num'];?>-choice1" required>
                    </div>
                    <div class="form-group">
                        <label for="Question<?php echo $GLOBALS['question_num'];?>-choice2">Wrong answer 1</label>
                        <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice2" id="Question<?php echo $GLOBALS['question_num'];?>-choice2" required>
                    </div>
                    <div class="form-group">
                        <label for="Question<?php echo $GLOBALS['question_num'];?>-choice3">Wrong answer 2</label>
                        <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice3" id="Question<?php echo $GLOBALS['question_num'];?>-choice3" required>
                    </div>
                    <div class="form-group">
                        <label for="Question<?php echo $GLOBALS['question_num'];?>-choice4">(optional) Wrong answer 3</label>
                        <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice4" id="Question<?php echo $GLOBALS['question_num'];?>-choice4">
                    </div>
                    <div class="form-group">
                        <label for="Question<?php echo $GLOBALS['question_num'];?>-choice4">(optional) Wrong answer 4</label>
                        <input type="text" name="Question<?php echo $GLOBALS['question_num'];?>-choice5" id="Question<?php echo $GLOBALS['question_num'];?>-choice5">
                    </div>
                </div>
            </div>
<?php       } ?>

        <!-- end .all-questions -->
        </div>
        <p class="add-another btn btn-warning mt-2 ml-4">Add another question</p>
        <!-- Show the number of questions dynamically for users -->
        <div class="form-group ml-4">
            <label for="question-amount">Total number of questions:</label>
            <input type="number" name="question-amount" id="question-amount" value="<?php echo $amount_of_questions; ?>" readonly="true" required>
        </div>
        <button class="btn btn-primary" type="submit" id="submitEdit" name="submitEdit">Save</button>
    </form>
</div>
<?php
    // if ID is not set, redirect to home
    } else {
        header("location: home.php");
        exit();
    }
// if user is not logged in or doesn't have the 
//correct permissions, redirect to login page
} else {
    header("location: index.php");
    exit();
} ?>