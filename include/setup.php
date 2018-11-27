<?php
use Classes\Workday,
	Classes\Appointment,
	Classes\DataHelper,
	Classes\LoginHelper;

// autoload
require __dir__ . '/autoload.php';

// db connect
require 'mysql-connect.php';

$data = new DataHelper($con);
$login = new LoginHelper($con);