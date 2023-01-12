<?php 
// start session
session_start();
// set page title
$title = "Log in";
// call in header file using include_once
include_once ("includes/header.php"); 
// if the session is active, redirect the user to the home page. logged in users 
// should not be able to see this page
if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION["login_user"])){ 
    header("location: home.php");
    exit();
} else {
?>
<!-- Main background container -->
<div class="container-fluid bg-light-grey custom-vh">
    <!-- container for the login card -->
    <div class="d-flex justify-content-center">
        <div id="login-card">
<?php       // check the URL for an error and display it if there is one
    if (isset($_GET['loginError'])) { ?>
                <div class='alert alert-danger' role='alert' id="loginError">
                    Error: <?php echo $_GET['loginError']; ?>
                </div>
<?php       
    } ?>
            <h1>Log in</h1>
            <form action="includes/login.php" method="post">
                <!-- Following best practice, I enclose form elements in a form group -->
                <div class="form-group">
                    <!-- Label and input for username. Label has 'for' element as per best practice and accessibility -->
                    <label for="username">Username</label>
                    <input type="text" class="form-control text-dark" id="username" name="username">
                </div>
                <div class="form-group">
                    <!-- Label and input for password. Label has 'for' element as per best practice and accessibility -->
                    <label for="password">Password</label>
                    <input type="password" class="form-control text-dark" id="password"  name="password">
                </div>
                <!-- Submit button for the form. -->
                <button type="submit" id="submit-login" name="submit-login" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php 
} ?>
