<?php
namespace Classes;

class Appointment 
{
	/**
	 * @var int
	 */
	public $userId;

	/**
	 * @var string
	 */
	public $date;

	/**
	 * @var string
	 */
	public $time;

	/**
	 * @var int
	 */
	public $timestamp;

	function __construct(int $userId, string $date, string $time, int $ts) 
	{
		$this->userId = $userId;
		$this->date = $date;
		$this->time = $time;
		$this->timestamp = $ts;
	}

	public static function getActionForAppt(array $appts, int $ts) : string
	{
		$appointment = null;
		$userId = $_SESSION['userId'];

		foreach($appts as $appt) {
			if ($appt->timestamp === $ts) {
				$appointment = $appt;
				break;
			}
		}

		if (!$appointment) {
			return 'add';
		}

		if ($appointment->userId !== $userId) {
			return 'none';
		}

		return 'remove';
	}

	public static function dayHasAtLeastOneAppt(array $appts, \DateTime $day) : bool
	{
		$date = $day->format('Y-m-d');

		foreach($appts as $appt) {
			if ($appt->date == $date) return true;
		}

		return false;
	}
}
?>
