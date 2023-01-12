<?php 
// start the session
session_start();
// et the title
$title = "Add a quiz"; 
// include header
include_once("includes/header.php");
// only show the page if the user is logged in
if ((session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION["login_user"])) && ($_SESSION["permission"] == "Edit")){
?>

<div class="container-fluid bg-light-grey height-100">
    <!-- centered heading with top and bottom padding -->
    <h1 class="text-center text-lg-start py-4">Add a quiz</h1>
    <!-- section break to separate the heading from the content -->
    <hr class="mt-2 mb-5">

    <!-- begin form, with action and method -->
    <form method="post" action="includes/new-quiz.php">
        <!-- Separate container for the quiz title -->
        <div class="card pt-4 mb-2 px-3">
            <div class="form-group">
                <label for="Quiz_title">Quiz title</label>
                <input type="text" name="Quiz_title" id="Quiz_title" required>
            </div>
        </div>
        <!-- container for all questions -->
        <div id="all-questions">
            <!-- container for each question -->
            <div class="question-container card p-3 m-3">
                <div class="form-group question-title">
                    <label for="Question1">Question title</label>
                    <input class="question-title" type="text" name="Question1" id="Question1" required>
                </div>
                <div class="ml-3">
                    <div class="form-group">
                        <label for="Question1-choice1">Correct answer</label>
                        <input type="text" name="Question1-choice1" id="Question1-choice1" required>
                    </div>
                    <div class="form-group">
                        <label for="Question1-choice2">Wrong answer 1</label>
                        <input type="text" name="Question1-choice2" id="Question1-choice2" required>
                    </div>
                    <div class="form-group">
                        <label for="Question1-choice3">Wrong answer 2</label>
                        <input type="text" name="Question1-choice3" id="Question1-choice3" required>
                    </div>
                    <!-- Options 4 and 5 are optional. The user can create a min of 3 answers, a max of 5 -->
                    <div class="form-group">
                        <label for="Question1-choice4">(optional) Wrong answer 3</label>
                        <input type="text" name="Question1-choice4" id="Question1-choice4" >
                    </div>
                    <div class="form-group">
                        <label for="Question1-choice5">(optional) Wrong answer 4</label>
                        <input type="text" name="Question1-choice5" id="Question1-choice5" >
                    </div>
                </div>
            </div>
            <div class="question-container card p-3 m-3">
                <div class="form-group question-title">
                    <label for="Question2">Question title</label>
                    <input class="question-title" type="text" name="Question2" id="Question2" required>
                </div>
                <div class="ml-3">
                    <div class="form-group">
                        <label for="Question2-choice1">Correct answer</label>
                        <input type="text" name="Question2-choice1" id="Question2-choice1" required>
                    </div>
                    <div class="form-group">
                        <label for="Question2-choice2">Wrong answer 1</label>
                        <input type="text" name="Question2-choice2" id="Question2-choice2" required>
                    </div>
                    <div class="form-group">
                        <label for="Question2-choice3">Wrong answer 2</label>
                        <input type="text" name="Question2-choice3" id="Question2-choice3" required>
                    </div>
                    <!-- Options 4 and 5 are optional. The user can create a min of 3 answers, a max of 5 -->
                    <div class="form-group">
                        <label for="Question2-choice4">(optional) Wrong answer 3</label>
                        <input type="text" name="Question2-choice4" id="Question2-choice4" >
                    </div>
                    <div class="form-group">
                        <label for="Question2-choice5">(optional) Wrong answer 4</label>
                        <input type="text" name="Question2-choice5" id="Question2-choice5" >
                    </div>
                </div>
            </div>
            <div class="question-container card p-3 m-3">
                <div class="form-group question-title">
                    <label for="Question3">Question title</label>
                    <input class="question-title" type="text" name="Question3" id="Question3" required>
                </div>
                <div class="ml-3">
                    <div class="form-group">
                        <label for="Question3-choice1">Correct answer</label>
                        <input type="text" name="Question3-choice1" id="Question3-choice1" required>
                    </div>
                    <div class="form-group">
                        <label for="Question3-choice2">Wrong answer 1</label>
                        <input type="text" name="Question3-choice2" id="Question3-choice2" required>
                    </div>
                    <div class="form-group">
                        <label for="Question3-choice3">Wrong answer 2</label>
                        <input type="text" name="Question3-choice3" id="Question3-choice3" required>
                    </div>
                    <!-- Options 4 and 5 are optional. The user can create a min of 3 answers, a max of 5 -->
                    <div class="form-group">
                        <label for="Question3-choice4">(optional) Wrong answer 3</label>
                        <input type="text" name="Question3-choice4" id="Question3-choice4" >
                    </div>
                    <div class="form-group">
                        <label for="Question3-choice5">(optional) Wrong answer 4</label>
                        <input type="text" name="Question3-choice5" id="Question3-choice5" >
                    </div>
                </div>
            </div>
        </div>
        <!-- Using JavaScript, this 'button' will add a new question -->
        <p class="add-another btn btn-warning mt-2 ml-4">Add another question</p>

        <!-- This input will track how many questions the quiz has. It is hidden and cannot be edited. 
        It will be updated via JavaScript  -->
        <div class="form-group ml-4">
            <label for="question-amount">Total number of questions:</label>
            <input type="number" name="question-amount" id="question-amount" value="3" readonly="true" required>
        </div>

        <button class="btn btn-primary" type="submit" id="submitAdd" name="submitAdd">Submit</button>
    </form>
</div>
<?php
} else {
    header("location: index.php");
    exit();
} ?>