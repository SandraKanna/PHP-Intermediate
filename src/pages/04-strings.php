<?php
section('4) Strings & Numbers', 2);

$word = 'Hello';
$greeting = $word . " world!"; // concatenation with "."
echo "string: $greeting | size: ", strlen($greeting), "<br>";
echo "position of \"world\": ", strpos($greeting, "world"), "<br>";
echo "replace (returns new string): ", str_replace("o", "ooooo", $greeting), "<br>";

echo "<br>Number kinds: Int, Float, Numeric String, Infinity, NaN<br>";
$imax = PHP_INT_MAX;		// int
$fmin = PHP_FLOAT_MIN;		// smallest positive float
$ns   = "4242";				// numeric string
echo "int: $imax | float(min+): $fmin | numeric string: $ns<br>";
$x = 1.9e411;  echo "is_infinite: "; var_dump(is_infinite($x));
$x = acos(8);  echo "NaN (acos(8)): "; var_dump($x);
