<?php
namespace Classes;

class Appointment 
{
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

	function __construct(string $date, string $time, int $ts) 
	{
		$this->date = $date;
		$this->time = $time;
		$this->timestamp = $ts;
	}

	public static function getActionForAppt(array $appts, int $ts) : string
	{
		return self::doesApptExist($appts, $ts) ? 'remove' : 'add';
	}

	public static function doesApptExist(array $appts, int $ts) : bool 
	{
		foreach($appts as $appt) {
			if ($appt->timestamp == $ts) return true;
		}

		return false;
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
