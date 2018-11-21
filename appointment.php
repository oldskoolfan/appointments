<?php
// db connect
include "include/mysql-connect.php";

$ts = $_POST['appt'] ?? null;
$action = $_POST['action'] ?? null;

$persist = function ($ts, $action, $con) {
	$response = [
		'action' => $action,
		'appt' => $ts,
	];
	$query = '';
	switch ($action) {
		case 'add':
			$result = $con->query("select * from appointments where appointment_timestamp = $ts");
			if ($result->num_rows > 0) {
				return;
			}
			$query = "insert into appointments (appointment_date, appointment_time, appointment_timestamp)
				values (date(from_unixtime($ts)),time(from_unixtime($ts)),$ts)";
			break;
		case 'remove':
			$query = "delete from appointments where appointment_timestamp = $ts";
			break;
	}

	$result = $con->query($query);
	if (!$result) {
		$response['status'] = 'error';
		$response['error_msg'] = $con->error;
	} else {
		$response['status'] = 'ok';
	}

	return $response;
};

if (isset($ts) && isset($action)) {
	$response = $persist($ts, $action, $con);
} else {
	$response = [
		'status' => 'error',
		'error_msg' => 'bad params',
	];
}

header('Content-type: application/json');
echo json_encode($response);

?>
