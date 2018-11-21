<?php
use Classes\Workday,
	Classes\Appointment;
require 'include/setup.php';
?>
<!doctype html>
<html>
<head>
<title>Appointment Calendar Example</title>
<link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<h1>Appointment Calendar: <?=$month->format('F Y')?></h1>
<h4>Click a timeslot to create an appointment, or click an existing appointment to delete it</h4>
<div class="page-links">
	<a href="./?page=<?=$prev?>">Prev</a>|<a href="./?page=<?=$page + 1?>">Next</a>
</div>
<section>
<?php if ($currentDayOfWeek > WorkDay::FIRST_WEEK_DAY): ?>
	<div class="row">
	<!-- echo empty table cells for each day offset from sunday at beginning of month -->
	<?php for ($i = WorkDay::FIRST_WEEK_DAY; $i < $currentDayOfWeek; $i++):?>
		<div class="cell"></div>
	<?php endfor; ?>
<?php endif; ?>
<!-- main loop to go through all days in a month -->
<?php
	for ($i = 1; $i <= $days; $i++) {
		// create new datetime object for the day
		$day = new DateTime("$m/$i/$y");
		// set time to 12am
		$day->setTime(0,0);

		$dayHasAtLeastOneAppt = Appointment::dayHasAtLeastOneAppt($appts, $day);
		$cellClass = $dayHasAtLeastOneAppt ? 'cell has-appt' : 'cell';

		if ($currentDayOfWeek == WorkDay::FIRST_WEEK_DAY) echo '<div class="row">';
		echo "<div class=\"$cellClass\">";
		echo "<div class=\"day-of-month\">{$day->format('j')}</div>";
		echo '<div class="timeslot-wrapper">';
		for ($j = 0; $j < WorkDay::HALF_HOURS; $j++) {
			foreach ($workDays as $workDay) {
				if ($workDay->day == $day->format('w') + 1) {
					if ($workDay->getOpenDateTime($day) <= $day &&
						$workDay->getCloseDateTime($day) >= $day) {
						$apptExists = Appointment::doesApptExist($appts, $day->getTimestamp());
						$action = $apptExists ?	"remove" : "add";
						echo "<li data-action=\"$action\" data-appt-ts=\"{$day->getTimestamp()}\" class=\"appt-link appt-$action\">{$day->format('h:i a')}</li></a>";
					}
					break;
				}
			}
			$day->modify("+30 minute");
		}
		echo "</div></div>";
		if ($currentDayOfWeek == WorkDay::LAST_WEEK_DAY) echo "</div>";

		WorkDay::setDayOfWeek($currentDayOfWeek);
	}
?>

<?php if ($currentDayOfWeek > WorkDay::FIRST_WEEK_DAY &&
	$currentDayOfWeek <= WorkDay::LAST_WEEK_DAY):?>
	<!-- echo empty table cells for each day offset from sunday at end of month -->
	<?php for ($i = $currentDayOfWeek; $i <= WorkDay::LAST_WEEK_DAY; $i++):?>
		<div class="cell"></div>
	<?php endfor; ?>
	</div>
<?php endif; ?>
</section>
<div class="page-links">
	<a href="./?page=<?=$prev?>">Prev</a>|<a href="./?page=<?=++$page?>">Next</a>
</div>
<script src="assets/scripts.js"></script>
</body>
</html>
