<?php
use Classes\Workday,
	Classes\Appointment;

// autoload
require __dir__ . '/../autoload.php';

// db connect
require 'mysql-connect.php';

// get hours of operation from database
$result = $con->query('select day_of_week+0 as day_of_week,
	open_time, close_time from operating_hours');

// create an array of objects from database result
$workDays = [];
if ($result) {
	while ($workDay = $result->fetch_object()) {
		array_push(
			$workDays,
			new WorkDay(
				$workDay->day_of_week,
				$workDay->open_time,
				$workDay->close_time
			)
		);
	}
}

// get appointments from database
$result = $con->query('select * from appointments order by appointment_timestamp');

// create an array of objects from database result
$appts = [];
if ($result) {
	while ($appt = $result->fetch_object()) {
		array_push(
			$appts,
			new Appointment(
				$appt->appointment_date,
				$appt->appointment_time,
				$appt->appointment_timestamp
			)
		);
	}
}

// get page parameter if there is one
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$prev = $page - 1;

$month = new DateTime();
$month = $month->modify("first day of $page month");
$days = $month->format('t'); // get total days in month

// get our timestamp to get first day of month
$m = $month->format('m');
$y = $month->format('Y');
$ts = mktime(null, null, null, $m, 1, $y);

// init currentDayOfWeek variable with first day of month
// note: we add one here because mysql enum is starts on 1, but wday starts on 0
$currentDayOfWeek = getdate($ts)['wday'] + 1;
