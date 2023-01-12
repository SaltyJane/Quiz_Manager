<?php 
// start the session
session_start();
// et the title
$title = "Home"; 
// include header
include_once("includes/header.php");
// only show the page if the user is logged in
if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION["login_user"])){
?>

<div class="container-fluid bg-light-grey height-100">
    <!-- centered heading with top and bottom padding -->
    <h1 class="text-center text-lg-start py-4">Choose a quiz</h1>
    <!-- section break to separate the heading from the content -->
    <hr class="mt-2 mb-5">
    <div class="flex">
        <ul id="quiz-lister">
<?php   
    // requires a connection to the database
    require("includes/db.php");
    // initialise isRetired as 0 so we can find all quizzes that aren't retired.
    $isRetired = 0;
    // prepared statement to list all quizzes
    $query = $conn -> prepare("SELECT * FROM `quiz` WHERE Quiz_isRetired = ? ORDER BY Quiz_title;");
    $query -> bind_param('i', $isRetired);
    $query -> execute();
    $result_array = $query->get_result();
    // loop through all quizzes
    while($row = $result_array->fetch_assoc()){ 
        // in each iteration, create a list item with a link to the quiz inside?>
            <li class="quiz-tile">
                <a class="quiz-link lead text-dark" href="quiz.php?id=<?php echo $row['Quiz_id']; ?>">
                    <?php echo $row['Quiz_title']; ?>
                </a>
            </li>
<?php   
    } ?>
        </ul>
    </div>
</div>

<?php 
}  else {
    header("location: index.php");
    exit();
}// end IF user is logged in ?>