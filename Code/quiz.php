<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
// start session
session_start();
// set page title
$title = "Quiz information";
// call in header file using include_once
include_once ("includes/header.php"); 
// if the session is active, redirect the user to the home page. logged in users 
// should not be able to see this page
if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION["login_user"])){ 
    if(isset($_GET['id'])) { 
        $Quiz_id = $_GET['id'];
?>

<div class="container-fluid bg-light-grey height-100">
<?php   
// requires a connection to the database
require("includes/db.php");
// prepared statement to get the quiz title
$get_quiz_title = $conn -> prepare("SELECT Quiz_title FROM `quiz` WHERE Quiz_id = ?;");
$get_quiz_title -> bind_param('i', $Quiz_id);
$get_quiz_title -> execute();
$result = $get_quiz_title->get_result();
// display quiz title
while($titleRow = $result->fetch_assoc()){ ?>
    <h1 class="text-center text-lg-start py-4"><?php echo $titleRow['Quiz_title']; ?></h1>
<?php } ?>

    <hr class="mt-2 mb-5">
<?php
    if($_SESSION["permission"] == 'Edit'){ ?>
    <div class="text-center">
        <a href="edit-quiz.php?id=<?php echo $Quiz_id ;?>" class="mb-3 mx-2 btn btn-primary">
            Edit quiz
        </a>
        <a  href="includes/delete-quiz.php?id=<?php echo $Quiz_id ;?>" 
            onclick="javascript: return confirm('Are you sure you want to delete this quiz permanently?');" class="mb-3 mx-2 btn btn-danger">
            Delete quiz
        </a>
    </div>
<?php 
    } ?>

    <div class="flex">
        <ol id="quiz-lister">

<?php   
// initialise variable
$current_question = 0;
// prepared statement to get all the questions
$get_question = $conn -> prepare("SELECT * FROM `quiz_question` WHERE Quiz_id = ?;");
$get_question -> bind_param('i', $Quiz_id);
$get_question -> execute();
$result_array = $get_question->get_result();
$counter = 0;
// loop through all questions for the selected quiz
while($row = $result_array->fetch_assoc()){ 
    $counter++;
    $current_question = $row['QQ_id']; ?>
            <li class="quiz-tile question-tile"><?php echo "<span class='lead'>{$counter}. </span>"; ?>
<?php   
    if ($_SESSION["permission"] == "View" || $_SESSION["permission"] == "Edit") { ?>
                <a class="lead text-dark" data-toggle="collapse" href="#question<?php echo $row['QQ_id'];?>-answers" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <?php echo $row['QQ_text']; ?>
                </a>
                <div id="question<?php echo $row['QQ_id'];?>-answers" class="collapse">
                    <!-- add a type to the list so that they display as per the spec. eg A, B, C, D etc -->
                    <ol class="answers-lister" type="A">
<?php                   
        // Nested loop required to display all the answers to the current question
        // prepared statement
        $get_answers = $conn -> prepare("SELECT * FROM `question_option` WHERE QQ_id = ?;");
        $get_answers -> bind_param('i', $current_question);
        $get_answers -> execute();
        $answer_array = $get_answers->get_result();
        // loop through all the answers for the current question 
        // variables should be named different than the parent loop to avoid errors
        while($answerRow = $answer_array->fetch_assoc()){ 
            // if the current answer in the loop is the correct one, apply the visually distinctive class
            if($answerRow['QO_isCorrect'] == 1){ ?>
                        <li class="correct-answer"><?php echo $answerRow['QO_text']; ?></li>
<?php   // otherwise simply echo out a list item with no class
            } else { ?>
                        <li><?php echo $answerRow['QO_text']; ?></li>
<?php       } ?>
<?php 
        }  $get_answers -> close(); // end WHILE $answerRow?>
                    </ol>
                </div>
            </li>
<?php       
    } else { ?>
                <span class="lead text-dark"><?php echo $row['QQ_text']; ?></span>
<?php    
    }
} $get_question -> close(); // end WHILE $row ?>
        </ol>
    </div>
</div>
        
<?php
    // end IF id is set in the URL
    } else {
        header("location: home.php");
        exit();
    }
// end IF user is logged in
} else {
    header("location: home.php");
    exit();
}