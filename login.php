<?php
use Classes\LoginHelper;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// setup
	require __dir__ . '/include/setup.php';

	$login->loginUser();
}