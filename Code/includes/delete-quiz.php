<?php
// check if id is in the url before doing anything
if (isset($_GET['id'])){
    require("db.php");
    $Quiz_id = $_GET['id'];

    // delete the quiz. The questions and answers will cascade
    $delete_quiz = $conn -> prepare("DELETE FROM `quiz` WHERE Quiz_id = ?");
    $delete_quiz -> bind_param('i', $Quiz_id);
    $delete_quiz -> execute();
    $delete_quiz -> close();

    // redirect back to home after deletion
    header("location: home.php?quiz-deleted");
    exit();

// if the ID is not set in the URL, redirect to homepage
} else {
    header("location: home.php");
    exit();
}
