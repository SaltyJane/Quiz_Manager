<?php // require connection script
require("db.php");

// save csv path to variable
$csvFilePath = "../../user.csv";

// open the csv as 'read'
$file = fopen($csvFilePath, "r");

// use a while loop to iterate through each line of the csv
while (($row = fgetcsv($file)) !== FALSE) {
    // save each row to an appropriately named variable
    $username = $row[0];
    $password = $row[1];
    $auth = $row[2];
    // hash the password using PHP's hash algorithm
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // use a prepared statement to connect to the database and prepare an INSERT SQL statement
    $add_users = $conn->prepare("INSERT INTO User (U_username, U_password, U_auth) VALUES (?, ?, ?)");
    // bind the variables to the question marks. the 'sss' declares that they are all 'string' datatypes
    $add_users->bind_param("sss", $username, $hashed_password, $auth);
    // execute the query
    $add_users->execute();
}
// once the loop has finished, redirect to the login page and exit the script
header("location: ../index.php");
exit();
?>
