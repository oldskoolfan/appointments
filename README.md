# CSCI 2412 - Appointment Calendar Example

This project shows how a calendar can be made with php and html. It also contains examples of many date functions (particularly formatting), classes and namespaces, and pagination with GET parameters (switching months).

## Setup Instructions

1. Clone or download the project to your htdocs directory
2. Make sure Apache and MySQL servers are running
3. Copy config.ini.example to config.ini
4. Create a folder called `etc` somewhere on your file system
5. In config.ini, set `etc_directory` equal to the full path to the directory you created in step 4
6. In `etc`, create a file called `db-connect.php` with the following code:
	```
	<?php

	$con = new mysqli('localhost', 'root', '');
	```
7. Run the appointmentdb.sql file in Workbench
8. Go to the project index page in your browser
