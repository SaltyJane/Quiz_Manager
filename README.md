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
* Click 'start' on MySQL. If this results in an error, click on 'Services' on the right-hand side, and scroll down to 'MySQL80'. Stop this service if the option is available, and then try this step again.
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
