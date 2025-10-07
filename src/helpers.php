<?php
/* ================================================================
   helper functions
   ----------------------------------------------------------------
	- "pre" html tag:
		displays text in a fixed-width font, preserving spaces & line breaks
	- "section" html:
		prints uniform subtitles (h1/h2/h3) across the script
   ================================================================ */

function pre(...$values) { // variadic: pre($a, $b, $c...)
	echo "<pre>";
	foreach ($values as $v) { var_dump($v); }
	echo "</pre>";
}

function section(string $title, int $level = 2) { // switch for h1/h2/h3
	switch ($level) {
		case 1: echo "<h1>$title</h1>"; break;
		case 3: echo "<h3>$title</h3>"; break;
		default: echo "<h2>$title</h2>";
	}
}

function antiXss($s) {
	// htmlspecialchars takes special chars as "plain"/safe text
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function test_input($data) {
    $data = trim((string)$data);
    $data = stripslashes($data);
    return $data;
}