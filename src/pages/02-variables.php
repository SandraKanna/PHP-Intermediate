
<?php
/*  ================================================================
	2) Variables, scope & data types
	----------------------------------------------------------------
	- globals declared outside any function;
	- local variables reset after each call
	- static variables keep value across calls
	================================================================ */

section('2) Variables, scope & data types', 2);
$char = 'a'; $word = 'hola'; $num = 1; $float = 5.42; $nul = NULL; $bool = true;
$arr = array('this','is','an','array','of','strings');

echo "char = $char | word = $word | num = $num | float = $float | nul = $nul | bool = $bool <br>";
echo "arr = $arr[0] $arr[1] $arr[2] $arr[3] $arr[4] $arr[5]<br>";
pre($char, $word, $num, $float, $nul, $bool, $arr);

function modifyGlobal() { 
	global $word, $num; // "global" keyword brings global variables to local scope
	$word = "Hello";
	++$num;
}
modifyGlobal();
echo "<b>After modifyGlobal:</b> word = $word | num = $num<br>";
echo "<br><b>Local scope:</b><br>";
function callLocal() {
	$normalNum = 42;       // local variable, resets at every call
	echo "local normalNum = $normalNum<br>";
	static $staticNum = 0; // static variable, preserves value across calls
	$staticNum++;
	echo "staticNum = $staticNum<br>";
}
callLocal(); callLocal();
