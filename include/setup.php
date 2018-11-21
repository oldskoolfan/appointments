<?php
use Classes\Workday,
	Classes\Appointment,
	Classes\DataHelper;

// autoload
require __dir__ . '/../autoload.php';

// db connect
require 'mysql-connect.php';

$data = new DataHelper($con);
