# Quiz Manager

## Setting Up

* First you will need to download Xampp server at this address: https://www.apachefriends.org/download.html
* Once this has been installed, you will need to move this project folder into C:\xampp\htdocs\

### Creating a user account in phpMyAdmin

* Open the Xampp control panel
* Click 'start' on Apache
* Open a browser and go to 'localhost' and press enter
* Click 'phpMyAdmin' in the top-right
* Click 'User accounts' and then 'Add user account'
* Create a user account with all permissions ticked. For mine, I have used (Username: QuizManager, Password: password, Hostname: localhost and the Host dropdown should be 'Local') for ease and testing purposes. In a properly hosted website, the password would need to be much more secure.
* You MUST use the same details as above when creating the account, or the application will not connect to the database.

### Opening the project

* Open the Xampp control panel
* Click 'start' on Apache
* Click 'start' on MySQL. If this results in an error or it does not work, click on 'Services' on the right-hand side, and scroll down to 'MySQL80'. Stop this service if the option is available, and then try this step again.
* Open a browser of your choice. I used Safari Developer edition
* In the browser, type 'localhost' and press enter.
* To open the database, click on the 'phpMyAdmin' option in the menu.
* To open the project, instead go to the URL 'localhost/Quiz_Manager'.

### Constructing the Database

* Inside the project folder is a folder called 'SQL'. 
* In the database (see above instructions), go to the 'Import' tab.
* Import the 'create_tables.sql' file.
* Import the 'populate_tables.sql' file.

### Adding users to the database

* Users cannot be added until the above steps to construct the database and create a user account have been completed.
* In the root folder of the project ('Quiz_Manager'), there is a file called user.csv. 
* Any users which need to be added to the website should be entered here in this order and format: Username,Password,Permissions
* Permission level should be one of "View", "Edit", or "Restricted". It is case sensitive so ensure it starts with a capital letter.
* Once the user.csv file is saved, go to the URL "localhost/Quiz_Manager/add-users.php".
* The website will add the users and then redirect you to the login page. 

If you receive the following error: 
````
Fatal error: Uncaught mysqli_sql_exception: Duplicate entry 'someUsername' for key 'PRIMARY' in C:\xampp\htdocs\Quiz_Manager\Code\includes\add-users.php:23 Stack trace: #0 C:\xampp\htdocs\Quiz_Manager\Code\includes\add-users.php(23): mysqli_stmt->execute() #1 {main} thrown in C:\xampp\htdocs\Quiz_Manager\Code\includes\add-users.php on line 23
````
This is because there is already a user in the database with one of the usernames you tried to add. You should not receive this error the first time you add users, because the database has only just been created by you, but usernames will need to be updated if you intend to add any additional users.

## Using the website

### Logging in

* Now that you have completed the 'setting up' section above, you can log in with the user details you added to the database.
* If you did not change the user.csv file, you can use the following combinations to log in:
  * Username: Edit, Password: Edit
  * Username: View, Password: View
  * Username: Restricted, Password: Restricted
* The username represents the permission level the account has.

### Viewing a quiz

* After logging in, you will be taken to the home page where a list of quizzes are displayed. 
* Click on the quiz you wish to view. 
* Users with Restricted permissions will not be able to view the answers to questions, but Edit and View can.

### Editing a quiz

* While viewing the questions and answers to a quiz, and if your permission level is Edit, there will be a button near the top of the page called 'Edit quiz'. Click on it.
* You will be taken to a pre-filled form, displaying the quiz questions and answers for you to edit. 
* You can delete questions. This refreshes the page, so be sure to save any other changes before doing this!
* You can add new questions using a yellow 'Add another question' button near the bottom of the page. 
* When the quiz is edited to your satisfaction, simply click on the blue 'submit' button. 

Note: There is a question counter near the bottom of the page. You can not edit this value despite being able to highlight it.

### Deleting a quiz

* While viewing the questions and answers to a quiz, and if your permission level is Edit, there will be a button near the top of the page called 'Delete quiz'. Click on it.
* You will get a browser popup asking if you are sure. Click OK.
* The quiz will be deleted and you will return to the home page.

### Adding a new quiz

* On any page, in the main menu, there is a menu item called 'Add a quiz' (only for users with Edit permissions). Click on it.
* You will be taken to an empty form. Fill it in with the quiz details you want to add. 
* You can add new questions at the bottom of the page, the same as on the 'edit quiz' page. 
* You can delete questions, but only if they were added manually using the above method.
* Once the form has been filled out, submit it using the blue 'submit' button at the bottom of the page.

Note: There is a question counter near the bottom of the page. You can not edit this value despite being able to highlight it.
