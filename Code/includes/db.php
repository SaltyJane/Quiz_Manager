<?php
// save database login details to variables
$servername = "localhost";
$username = "QuizManager";
$password = "password";
$dbname = "Quiz_Manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
// } else {
//     echo "connected!";
// }


?> 