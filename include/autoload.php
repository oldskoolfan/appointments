<?php
/**
 * look in ./include/classes for our declared classes
 * @var [type]
 */
spl_autoload_register(function ($class) {
	$dirs = explode('\\', $class);
	$path = implode('/', $dirs);
	include "include/$path.php";
});
