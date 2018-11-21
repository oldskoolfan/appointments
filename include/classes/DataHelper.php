<?php
namespace Classes;

class DataHelper
{
	/**
	 * @var \mysqli
	 */
	public $conn;

	/**
	 * @var int
	 */
	public $page;
	
	/**
	 * @var int
	 */
	public $prev;

	/**
	 * @var array
	 */
	public $days;

	/**
	 * @var int
	 */
	public $currentDayOfWeek;

	/**
	 * @var \DateTime
	 */
	public $month;

	public function __construct(\mysqli $dbConn)
	{
		$this->conn = $dbConn;

		// get page parameter if there is one
		$this->page = isset($_GET['page']) ? $_GET['page'] : 0;
		$this->prev = $this->page - 1;

		$month = new \DateTime();
		$this->month = $month->modify("first day of $this->page month");
		$this->days = $this->month->format('t'); // get total days in month

		// get our timestamp to get first day of month
		$m = $this->month->format('m');
		$y = $this->month->format('Y');
		$ts = mktime(null, null, null, $m, 1, $y);

		// init currentDayOfWeek variable with first day of month
		// note: we add one here because mysql enum is starts on 1, but wday starts on 0
		$this->currentDayOfWeek = getdate($ts)['wday'] + 1;
	}

	public function getDay(int $i) : \DateTime
	{
		$m = $this->month->format('m');
		$y = $this->month->format('y');

		// create new datetime object for the day
		$day = new \DateTime("$m/$i/$y");
		
		// set time to 12am
		$day->setTime(0,0);

		return $day;
	}

	public function getWorkdays() : array
	{
		$workDays = [];

		try {
			// get hours of operation from database
			$result = $this->getResult('select day_of_week+0 as day_of_week,
			open_time, close_time from operating_hours');

			// create an array of objects from database result
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
		catch (\Throwable $e) {
			echo $e->getMessage(); // todo: for now
		}

		return $workDays;
	}

	public function getAppointments() : array
	{
		$appts = [];

		try {
			$result = $this->getResult('select * from appointments 
				order by appointment_timestamp');
			
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
		} catch (\Throwable $e) {
			echo $e->getMessage(); // todo: for now
		}

		return $appts;
	}

	private function getResult(string $query) : \mysqli_result
	{
		$result = $this->conn->query($query);

		if (!$result) {
			throw new \Exception($this->conn->error);
		}

		return $result;
	}
}
