<!DOCTYPE html>
<html lang="en-GB">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Make sure viewport is responsive for accessibility purposes -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include necessary JavaScript files -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <!-- Include JavaScript for bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Include my own custom JavaScript file  -->
    <script src="includes/app.js"></script>
    <!-- Include the CSS for bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Include my own custom stylesheet -->
    <link rel="stylesheet" href="includes/style.css">
    <!-- Declare the title as a PHP variable which does not yet exist. 
    In each php file $title will be delcared before including the header file. -->
    <title><?php echo $title; ?> | Quiz Manager</title>
</head>

<body>
    <header>
        <!-- Use of semantic HTML - using the nav element -->
        <!-- The classes can be changed if rebranding is needed. 
        The 'navbar-light' and 'bg-blue' classes will change the colours -->
        <nav class="navbar navbar-expand-lg navbar-light bg-blue">
            <!-- navbar logo should redirect to home page as per best practice -->
            <a class="navbar-brand text-black" href="index.php">
                <!-- Ensure alt tag is included for accessibility -->
                <img id="company-logo" src="includes/Logos/WebbiSkools-Logo.JPG" alt="WebbiSkools Logo">
            </a>
            <!-- This button is the hamburger menu, which is only visible on mobile. -->
            <button class="navbar-toggler ms-auto" type="button" data-toggle="collapse" 
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- By adding the collapse class, this menu is responsive and expands on mobile -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <!-- Each menu item should be a list item as per best practice -->
<?php   
// if a user is logged in, show the menu items relating to their permission levels
if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION["login_user"])){ ?>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="home.php">Home</a>
                    </li>
<?php       // if the user has edit permissions, show the 'add a quiz' menu item
    if ($_SESSION["permission"] == 'Edit') { ?>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="add-quiz.php">Add a quiz</a>
                    </li>
<?php      
    } ?>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="includes/logout.php">Log out</a>
                    </li>
<?php  
} else { ?>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="index.php">Log in or sign up</a>
                    </li>
<?php 
} ?>
                </ul>
            </div>
        </nav>
    </header>
