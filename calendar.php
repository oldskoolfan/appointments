<?php
use Classes\Workday,
	Classes\Appointment;

require 'include/setup.php'; // initializes $data as DataHelper

$workDays = $data->getWorkdays();	
$appts = $data->getAppointments();
?>

<?php include 'include/header.html' ?>

<h1>Appointment Calendar: <?=$data->month->format('F Y')?></h1>
<h4>Click a timeslot to create an appointment, or click an existing appointment to delete it</h4>

<?php include 'include/page-links.php' ?>

<section>
<?php if ($data->currentDayOfWeek > WorkDay::FIRST_WEEK_DAY): ?>
	<div class="row">
	<!-- echo empty table cells for each day offset from sunday at beginning of month -->
	<?php for ($i = WorkDay::FIRST_WEEK_DAY; $i < $data->currentDayOfWeek; $i++):?>
		<div class="cell"></div>
	<?php endfor; ?>
<?php endif; ?>

<!-- main loop to go through all days in a month -->
<?php for ($i = 1, $day = $data->getDay($i); $i <= $data->days; $i++): ?>
	<?php if ($data->currentDayOfWeek == WorkDay::FIRST_WEEK_DAY): ?>
		<div class="row">
	<?php endif; ?>
	
	<div class="<?=$dayHasAtLeastOneAppt ? 'cell has-appt' : 'cell'?>">
		<div class="day-of-month"><?=$day->format('j')?></div>
		<div class="timeslot-wrapper">
			<?php for ($j = 0, $action = Appointment::getActionForAppt($appts, $day->getTimeStamp()); $j < WorkDay::HALF_HOURS; $j++): ?>
				<?php foreach ($workDays as $workDay): ?>
					<?php if ($workDay->day == $day->format('w') + 1): ?>
						<?php if ($workDay->getOpenDateTime($day) <= $day && $workDay->getCloseDateTime($day) >= $day): ?>
							<li data-action="<?=$action?>" data-appt-ts="<?=$day->getTimestamp()?>" 
								class="appt-link appt-<?=$action?>"><?=$day->format('h:i a')?></li>
						<?php endif; ?>
						<?php break; ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php $day->modify("+30 minute"); ?>
			<?php endfor; ?>
		</div>
	</div>
	
	<?php if ($data->currentDayOfWeek == WorkDay::LAST_WEEK_DAY): ?>
		</div>
	<?php endif; ?>

	<?php WorkDay::setDayOfWeek($data->currentDayOfWeek); ?>
<?php endfor; ?>
<!-- end main loop -->

<?php if ($data->currentDayOfWeek > WorkDay::FIRST_WEEK_DAY &&
	$data->currentDayOfWeek <= WorkDay::LAST_WEEK_DAY):?>
	<!-- echo empty table cells for each day offset from sunday at end of month -->
	<?php for ($i = $data->currentDayOfWeek; $i <= WorkDay::LAST_WEEK_DAY; $i++):?>
		<div class="cell"></div>
	<?php endfor; ?>
	</div>
<?php endif; ?>
</section>

<?php include 'include/page-links.php' ?>
<?php include 'include/footer.php' ?>
