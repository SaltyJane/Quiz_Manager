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
