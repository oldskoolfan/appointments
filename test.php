<?php

$class = '\MyClass';

$arr = explode('\\', $class);
var_dump(implode('/', $arr) . '.php');
