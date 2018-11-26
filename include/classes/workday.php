<?php
namespace Classes;
use \DateTime as DateTime;

class WorkDay 
{
	const FIRST_WEEK_DAY = 1;
	const LAST_WEEK_DAY = 7;
	const HALF_HOURS = 24 * 2;  // get number of 30min time slots in a day

	/**
	 * @var int
	 */
	public $day;

	/**
	 * @var string
	 */
	public $open;

	/**
	 * @var string
	 */
	public $close;

	function __construct(int $day, string $open, string $close) 
	{
		$this->day = $day;
		$this->open = $open;
		$this->close = $close;
	}

	public function getOpenDateTime(\DateTime $now = null) : \DateTime
	{
		return $this->getNewDateTime($this->open, $now);
	}

	public function getCloseDateTime(\DateTime $now = null) : \DateTime
	{
		return $this->getNewDateTime($this->close, $now);
	}

	private function getNewDateTime(string $time, \DateTime $now) : \DateTime
	{
		if ($now == null) $now = new DateTime();
		
		$ts = strtotime($time, $now->getTimestamp());
		$dt = new DateTime();
		
		return $dt->setTimestamp($ts);
	}

	// function to update currentDayOfWeek during our main loop
	public static function setDayOfWeek(int &$currDay) : int
	{
		if ($currDay >= self::LAST_WEEK_DAY) {
			return $currDay = self::FIRST_WEEK_DAY;
		}
		
		return $currDay++;
	}
}
?>
