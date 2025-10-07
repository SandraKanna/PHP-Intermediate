<?php

/* 	================================================================
	5) Arrays & loops (towards real forms in LokaLingo)
	----------------------------------------------------------------
	- indexed / associative / multidimensional / matrix
	- while / for / foreach / do-while with continue/break
	- light type-normalization (int/float/bool/numeric-string)
	- realistic data structures
	- switch case
	================================================================ */

section('5) Arrays & Loops', 2);

// available tabs
$tabs = [
  'indexed' => 'Indexed + while',
  'assoc'   => 'Associative + foreach (&ByRef)',
  'schema'  => 'Form schema & options (for + do-while)',
  'matrix'  => 'Course matrix (nested for)',
];

// current tab (per query ?t=…)
$t = $_GET['t'] ?? 'indexed';
if (!isset($tabs[$t])) { 
	$t = 'indexed'; 
}

// tabs navbar
echo '<p>';
foreach ($tabs as $key => $label) {
  $active = $key === $t ? 'style="font-weight:bold;text-decoration:underline"' : '';
  echo '<a '.$active.' href="?p=05-arrays&t='.$key.'">'.htmlspecialchars($label).'</a> &nbsp; ';
}
echo '</p><hr>';

// tab prev/next
$tabKeys = array_keys($tabs);
$tabPos  = array_search($t, $tabKeys, true);
$tabPrev = $tabPos > 0 ? $tabKeys[$tabPos - 1] : null;
$tabNext = $tabPos < count($tabKeys) - 1 ? $tabKeys[$tabPos + 1] : null;

// ---------- content per tab ----------
switch ($t) {
  case 'indexed':
	section($tabs[$t], 3);
	$nums = [7, "3", 2.6, 9, true, "11.2", 0, null];
	echo "original: "; pre($nums);

	$i = 0; $processed = [];
	while ($i < count($nums)) {
		$v = $nums[$i];

	// if int → double; if float → round→int; if numeric string → cast→int; if bool → cast→int; else keep
		$out = is_int($v)      ? $v * 2
			 : (is_float($v)   ? (int)round($v)
			 : (is_numeric($v) ? (int)$v
			 : (is_bool($v)    ? (int)$v
			 : $v)));
	// skip zeros (continue), stop after pushing 5 items (break)
		if ($out === 0) { 
			$i++; 
			continue; 
		}
		$processed[] = $out;
		if (count($processed) >= 5) {
			break;
		}
		$i++;
	}
	echo "processed: "; pre($processed);
	break;

  case 'assoc':
	section($tabs[$t], 3);
	$user = [
	  "name"       => "Ana",
	  "age"        => "30",
	  "active"     => "yes",
	  "email"      => "ana@example.com",
	  "level"      => "B2",
	  "newsletter" => "0",
	];
	echo "before normalize: "; pre($user);

	foreach ($user as $k => &$val) {
		if ($k === "age" && is_numeric($val)) {
			$val = (int)$val;
		} elseif ($k === "active") {
			$val = ($val === "on" || $val === "yes" || $val === 1 || $val === "1") ? 1 : 0;
		} elseif ($k === "newsletter" && is_numeric($val)) {
			$val = (int)$val;
		}
	}
	unset($val);
	echo "after normalize: "; pre($user);
	break;

  case 'schema':
	section($tabs[$t], 3);
	$formSchema = [
	  ['field'=>'name', 'type'=>'text',   'label'=>'Full Name', 'required'=>true],
	  ['field'=>'email','type'=>'email',  'label'=>'Email',     'required'=>true],
	  ['field'=>'age',  'type'=>'number', 'label'=>'Age',       'required'=>false, 'min'=>15, 'max'=>65],
	  ['field'=>'level','type'=>'select', 'label'=>'Level',     'required'=>true],
	  ['field'=>'country','type'=>'select','label'=>'Country',  'required'=>true],
	];
	$options = [
	  'level'   => ['A1','A2','B1','B2','C1','C2'],
	  'country' => ['JP','FR','UK','BR','US','AUS'],
	];
	echo "<b>formSchema:</b> "; pre($formSchema);
	echo "<b>options:</b> ";    pre($options);

	/*  FOR loop (with chached count()) - find default level, prefer 'B2' if available, else first option */
	$defaultLevel = null;
	for ($i = 0, $n = count($options['level']); $i < $n; $i++) {
		if ($options['level'][$i] === 'B2') {
			$defaultLevel = 'B2';
			break;
		}
	}
	if ($defaultLevel === null) {
		$defaultLevel = $options['level'][0] ?? null;
	}
	echo "<p><b>Preferred default level: </b>", "$defaultLevel <br></p>";

	/*  DO-WHILE loop - consume required field queue with array_shift(pop from the front)
	- simulate checking requireds one by one */
	$requiredQueue = [];
	foreach ($formSchema as $f) {
		if (!empty($f['required'])) {
			$requiredQueue[] = $f['field'];
		}
	}
	echo "<b>Fields that must be filled: </b><br>";
	do {
		$next = array_shift($requiredQueue);
		echo "checking field: ", ($next ?? 'none'), "<br>";
	} while (!empty($requiredQueue));

  case 'matrix':
	section($tabs[$t], 3);
	$courses = [
	  ["English A1", 30, 12],
	  ["French B2",  25, 18],
	  ["Spanish C1", 40, 30],
	  ["Japanese A2",15, 5],
	];
	// direct access
	echo $courses[0][0] . ": enrolled = " . $courses[0][1] . ", completed = " . $courses[0][2] . "<br>";
	echo $courses[1][0] . ": enrolled = " . $courses[1][1] . ", completed = " . $courses[1][2] . "<br>";
	echo $courses[2][0] . ": enrolled = " . $courses[2][1] . ", completed = " . $courses[2][2] . "<br>";
	echo $courses[3][0] . ": enrolled = " . $courses[3][1] . ", completed = " . $courses[3][2] . "<br><br>";

	// nested FOR loops (row/col traversal)
	for ($row = 0; $row < count($courses); $row++) {
		echo "<p><b>Row $row</b></p>";
		echo "<ul>";
		for ($col = 0; $col < count($courses[$row]); $col++) {
			echo "<li>" . $courses[$row][$col] . "</li>";
		}
		echo "</ul>";
	}
	break;
}