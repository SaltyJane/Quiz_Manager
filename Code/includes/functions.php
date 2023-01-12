<?php

// --------------------
// LOGIN FUNCTIONS
// --------------------

// check password entered matches hashed password in DB 
function checkPassword($conn, $username, $password) {
    // declare this globally so I can assign it a value inside a loop
    $hashed_password = '';

    // prepared statement for security
    $sql = $conn->prepare("SELECT U_password FROM `user` WHERE U_username = ?");
    $sql -> bind_param("s", $username);
    $sql -> execute();
    // store the query's result
    $result = $sql -> get_result();
    // loop through the result in order to get the value. 
    // There will only be 1 as the username is a primary key in the DB
    while($row = mysqli_fetch_assoc($result)) {
        // save the DB password to a variable which I can use outside of the loop
        $hashed_password = $row['U_password'];
    }
    // close the connection
    $sql -> close();
    
    // use PHP's native password_verify method to check if the password 
    // entered is the same as the hashed password in the DB
    if(password_verify($password, $hashed_password)) {
        // if the passwords match, the function will evaluate as true
        return true;
    } else {
        // if they don't match, the function will return false
        return false;
    }
}

// reusable function to end validation early if error occurs
function end_validation($error){
    header("location: ../index.php?loginError={$error}");
    exit();
}

// check that the entered username exists
function checkUserExists($conn, $username) {
    $endResult;
    // prepared statement to prevent sql injection
    $sql = $conn-> prepare("SELECT * FROM `user` WHERE U_username = ?;");
    $sql -> bind_param("s", $username);
    $result = $sql->execute();
    $sql -> store_result(); //Transfers a result set from a prepared statement
    // save the number of rows to a variable
    $row_cnt = $sql -> num_rows;

    // if the number of rows is more than 0, it means there is an account with that username so return true
    if ($row_cnt > 0){
        $endResult = true;
    // if the row count is 0 or less then no account exists for this user, return false
    } else {
        $endResult = false;
    }
return $endResult;
}

// check if the user is authorised at all and return boolean
function isUserAuth($conn, $username){
    $sql = $conn -> prepare("SELECT * FROM `user` WHERE U_username = ?;");
    $sql -> bind_param('s', $username);
    $sql -> execute();
    // turn the results into an array to loop through
    $result_array = $sql->get_result();
    // loop through the users, checking their auth level
    while($row = $result_array->fetch_assoc()){
        if($row['U_auth'] == 'View' || $row['U_auth'] == 'Edit' || $row['U_auth'] == 'Restricted') {
            return true;
        } else {
            return false;
        }
    // close the connection
    $sql -> close();
    }
}

// get auth level from the db and return it
function getUserAuth($conn, $username) {
    // initialise the variable as 'none'
    $permissionLevel = 'none';
    
    // prepared statement to get the user authorisation level
    $sql = $conn -> prepare("SELECT * FROM `user` WHERE U_username = ?;");
    $sql -> bind_param('s', $username);
    $sql -> execute();
    $result_array = $sql->get_result();
    // loop through users - there should only be 1 anyway
    while($row = $result_array->fetch_assoc()){
        // update variable value with permission level
        $permissionLevel = $row['U_auth'];
    // close the connection
    $sql -> close();
    }
    // return the permission level
    return $permissionLevel;
}

// create session for the user after checks
function createSession($conn, $username) {
    session_start();
    $_SESSION["login_user"] = $username;
    // permission level is granted manually in the DB. You can't log in until that column is populated
    //therefore we can get the permission level here and save it to a SESSION variable
    $_SESSION["permission"] = getUserAuth($conn, $username);
    header ('location: ../home.php?login=successful');
    exit();
}

?>