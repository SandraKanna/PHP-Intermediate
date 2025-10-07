<?php
/*  ================================================================
	1) Output: echo vs print
	----------------------------------------------------------------
	- echo: multiple arguments (separated by commas), faster, no return value
	- print: single argument, returns 1 (so it can be used in expressions)
	================================================================ */
section('1) Output: echo vs print', 2);

echo "This is echo. ", "It can display multiple strings ", "separated by commas.<br>";
$value = print("This is print. ");
echo "<br>print returns: $value<br>";