<?php
$config = parse_ini_file(__DIR__ . '/../config.ini');
$etcPath = $config['mysql_connect_path'];
include $etcPath;

$con->select_db('andrewfharriscom_appointmentdb');
