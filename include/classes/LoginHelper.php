<?php
namespace Classes;

class LoginHelper
{
	/**
	 * @var \mysqli
	 */
	public $conn;

	const ERRNO_DUP_ENTRY = 1062;

	public function __construct(\mysqli $dbConn)
	{
		$this->conn = $dbConn;
	}

	public function loginUser() : void
	{
		try {
			$user = $_POST['username'];
			$pass = $_POST['password'];

			if ($this->anyEmptyStrings($user, $pass)) {
				throw new \Exception('All fields required');
			}

			$query = 'SELECT * FROM users WHERE username = ?';
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param('s', $user);

			if (!$stmt->execute()) {
				throw new \Exception($stmt->error);
			}

			$result = $stmt->get_result();
			
			if ($result->num_rows !== 1) {
				throw new \Exception('Problem finding user');
			}

			$user = $result->fetch_object();

			if (!password_verify($pass, $user->password)) {
				throw new \Exception('Invalid password');
			}

			// user is logged in
			$_SESSION['user'] = $user->username;
			$_SESSION['userId'] = $user->id;

			header('Location: calendar.php');

		} catch (\Throwable $e) {
			$_SESSION['msg'] = 'Error: ' . $e->getMessage();
			header('Location: index.php');
		}
	}

	public function registerUser() : void
	{
		try {
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$confirm = $_POST['confirm'];

			if ($this->anyEmptyStrings($user, $pass, $confirm)) {
				throw new \Exception('All fields required');
			}

			if ($pass !== $confirm) {
				throw new \Exception('Passwords must match');
			}

			$hash = password_hash($pass, PASSWORD_DEFAULT);
			$query = 'INSERT users (username, password) VALUES(?,?)';
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param('ss', $user, $hash);

			if (!$stmt->execute()) {
				if ($stmt->errno === self::ERRNO_DUP_ENTRY) {
					throw new \Exception('Username already taken');
				}

				throw new \Exception($stmt->error);
			}

			$_SESSION['msg'] = 'User created successfully!';

			header('Location: index.php');

		} catch (\Throwable $e) {
			echo 'Error: ' . $e->getMessage(); // todo: for now
		}
	}

	private function anyEmptyStrings(...$params) : bool
	{
		foreach ($params as $string) {
			if (empty($string)) {
				return true;
			}
		}

		return false;
	}
}