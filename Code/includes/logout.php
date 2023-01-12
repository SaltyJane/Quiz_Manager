<?php 
// start session
session_start();
// log the user out by 
// unsetting the session variables
unset($_SESSION['login_user']);
unset($_SESSION["permission"]);

//then redirect to login page
header('Location: ../index.php');
exit();
?>