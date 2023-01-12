<?php // first check that the login form was submitted
if(isset($_POST['submit-login'])){
    // dependencies
    require("db.php");
    include("functions.php");

    //declare variables
    $error = '';
    $isError = false;
    $username = $_POST['username'];
    $password = $_POST['password'];

    // check if the username exists
    if (!checkUserExists($conn, $username)){
        $error = "User does not exist.";
        $isError = true;
        end_validation($error);
    }

    // check if the password entered is the same as in the DB 
    if (!checkPassword($conn, $username, $password)){
        $error = "Password is incorrect.";
        $isError = true;
        end_validation($error);
    }

    // if user's account is not authorised, don't log in
    if (!isUserAuth($conn, $username)){
        $error = "Your account is not authorised.";
        $isError = true;
        end_validation($error);
    }

    // if there is any error, return to login page displaying it
    // this is a catch-all for any missed validation above.
    if($isError == true){
        header("location: ../index.php?loginError={$error}");
        exit();
    } else {
        // if no errors, call the createSession function to log 
        // the user in, and then redirect to the homepage
        createSession($conn, $username);
        header("location: ../home.php?login=successful");
        exit();
    } 

// if the login form was not submitted, go back to login page
} else {
    header("location: ../index.php");
    exit();
}

?>