<?php
/*  ================================================================
	3) Constants
	----------------------------------------------------------------
	- constants are global identifiers; immutable during execution
	- include a couple of predefined magic constants
	================================================================ */

section('3) Constants', 2);
define('APP_NAME','php-play');
const PI_VAL = 3.14159;
echo "APP_NAME = " . APP_NAME . "<br>";
echo "PI_VAL = " . PI_VAL . "<br>";
echo "Predefined: __FILE__ = ", __FILE__, " | __LINE__ = ", __LINE__, "<br>";
