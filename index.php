<?php
// create a redirect to the login page. 
// ensures if someone goes to the root folder address they do 
// not see just a file directory
header("location: Code/index.php");
exit();
?>