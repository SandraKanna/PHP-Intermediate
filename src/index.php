<?php

/* 	===========================================================================
    Index: 
    ---------------------------------------------------------------------------
    - simple router (slug->metadata)
    - require statements to include code from other files with E_COMPILE_ERROR
    - include statements to include files with E_WARNING
    =========================================================================== */

require __DIR__ . '/helpers.php';
$pages = [
  'home' => [
    'title' => 'Home',
    'file'  => __DIR__ . '/pages/home.php',
    'group' => 'root'
  ],

  // Fundamentals
  '01-output'  => ['title' => '1) Echo vs Print',     'file' => __DIR__ . '/pages/01-output.php',     'group' => 'fundamentals'],
  '02-vars'    => ['title' => '2) Variables & Scope', 'file' => __DIR__ . '/pages/02-variables.php',  'group' => 'fundamentals'],
  '03-const'   => ['title' => '3) Constants',         'file' => __DIR__ . '/pages/03-constants.php',  'group' => 'fundamentals'],
  '04-strings' => ['title' => '4) Strings & Numbers', 'file' => __DIR__ . '/pages/04-strings.php',    'group' => 'fundamentals'],
  '05-arrays'  => ['title' => '5) Arrays & Loops',    'file' => __DIR__ . '/pages/05-arrays.php',     'group' => 'fundamentals'],

  // Form section
  '06-form'    => ['title' => 'Multi field Form',     'file' => __DIR__ . '/pages/06-form.php',       'group' => 'forms'],
];

$current = $_GET['p'] ?? 'home'; // Get cur page from query ?p=01-output, for example
if (!isset($pages[$current])) {
    http_response_code(404);
    $current = 'home';
}

include __DIR__ . '/layout/header.php';
include $pages[$current]['file'];
include __DIR__ . '/layout/footer.php';