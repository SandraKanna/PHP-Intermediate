<?php
/* ================================================================
   multi field form
   ================================================================ */
section('6) Form', 2);

// if method != POST -> serve the HTML file, use GET by default
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	readfile(__DIR__ .'/06-form.html');
	return;
}

// if POST -> process the request
$ctype = $_SERVER['CONTENT_TYPE'] ?? '';
if ($ctype !== '' && stripos($ctype, 'application/x-www-form-urlencoded') === false
                 && stripos($ctype, 'multipart/form-data') === false) {
    http_response_code(415);
    echo "<h1>Unsupported Media Type</h1>";
    exit;
}
/* ================================================================
   read input (clean with test_input) 
   - note: $_REQUEST can be used for $_GET + $_POST + $_COOKIE --> but it's not explicit
   - preferred $_POST for clarity
   ================================================================ */
$name       = test_input($_POST['name']     ?? ''); //text
$email      = test_input($_POST['email']    ?? ''); //email
$age        = test_input($_POST['age']      ?? ''); //text
$level      = test_input($_POST['level']    ?? ''); //select from option
$comment    = test_input($_POST['comment']  ?? ''); // textarea
$contact    = test_input($_POST['contact']  ?? 'email'); // radio: email|phone
$newsletter = isset($_POST['newsletter']) ? 1 : 0; // checkbox

/* ================================================================
   basic normalization/validation
   ================================================================ */
$errors = [];

if ($name === '')  {
	$errors[] = 'name is required';
} else {
    // Normalize spaces and deletes invisibble chars
    $name = preg_replace('/\s+/u', ' ', trim($name));
    $name = str_replace(["\xC2\xA0", "\u{00A0}"], ' ', $name); // reemplaza NBSP

    // accept letters (any language), hyphens, apostrophes..
    if (!preg_match("/^[\p{L}\s'’-]+$/u", $name)) {
        $errors[] = "name must contain only letters, spaces, hyphens or apostrophes";
    }
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errors[] = 'valid email is required';
}

$allowedLevels  = ['A1','A2','B1','B2','C1','C2'];
$allowedContact = ['email','phone'];

if (!in_array($level, $allowedLevels, true)) {
	$errors[] = 'invalid level';
}
if (!in_array($contact, $allowedContact, true)) {
	$errors[] = 'invalid contact method';
}

$ageInt = null;
if ($age !== '') {
	if (ctype_digit($age)) {
		$ageInt = (int)$age;
	}
	else {
		$errors[] = 'age must be an integer';
	}
}

// if errors → show error and stop
if ($errors) {
	echo "<h1>Wrong input format</h1>";
	pre($errors);
	echo '<p><a href="?p=06-form">Back to form</a></p>';
	exit;
}
/* ================================================================
   PostgreSQL (via PDO)
   - read env credentials (.env via docker-compose)
   - create table if it doesnt exist yet
   - insert data and return id
   ================================================================ */
$host = getenv('DB_HOST') ?: 'db';
$port = (int)(getenv('DB_PORT') ?: 5432);
$db   = getenv('DB_NAME') ?: 'appdb';
$user = getenv('DB_USER') ?: 'app';
$pass = getenv('DB_PASS') ?: 'secret';

$dsn = "pgsql:host={$host};port={$port};dbname={$db}";
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

try {
    // $dsn = "pgsql:host={$host};port={$port};dbname={$db};";
    // $pdo = new PDO($dsn, $user, $pass, [
    //     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // ]);

    // Create table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS form1 (
            id          SERIAL PRIMARY KEY,
            name        TEXT      NOT NULL,
            email       TEXT      NOT NULL,
            age         INTEGER   NULL,
            level       TEXT      NOT NULL,
            newsletter  BOOLEAN   NOT NULL DEFAULT FALSE,
            comment     TEXT,
            contact     TEXT      NOT NULL DEFAULT 'email',
            user_agent  TEXT,
            ip          TEXT,
            created_at  TIMESTAMPTZ NOT NULL DEFAULT NOW()
        )
    ");
    // insert info
    $stmt = $pdo->prepare("
        INSERT INTO form1
        (name, email, age, level, newsletter, comment, contact, user_agent, ip, created_at)
        VALUES (:name, :email, :age, :level, :newsletter::boolean, :comment, :contact, :ua, :ip, :ts)
        RETURNING id
    ");

    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR']     ?? '';
    $ts = date('c'); // ISO8601 standard time

    $stmt->execute([
        ':name'       => $name,
        ':email'      => $email,
        ':age'        => $ageInt,
        ':level'      => $level,
        ':newsletter' => (int)$newsletter,
        ':comment'    => $comment,
        ':contact'    => $contact,
        ':ua'         => $ua,
        ':ip'         => $ip,
        ':ts'         => $ts,
    ]);

    $newId = (int) $stmt->fetchColumn(); //return id to be printed on the browser
} catch (Throwable $e) {
    http_response_code(500);
    echo "<h1>DB error</h1>";
    pre($e->getMessage());
    exit;
}
/* ================================================================
   success view: show summary + a few superglobals + some security
   ================================================================ */

// safe helper function antiXss() to be used when printing any input from the user
echo "<h1>Thanks, request saved!</h1>";
echo "<p>ID: <b>" . antiXss($newId) . "</b></p>";

echo "<h3>Saved payload</h3>";
echo "<ul>";
echo "<li>Name: " . antiXss($name) . "</li>";
echo "<li>Email: " . antiXss($email) . "</li>";
echo "<li>Age: " . antiXss($ageInt) . "</li>";
echo "<li>Level: " . antiXss($level) . "</li>";
echo "<li>Newsletter: " . ($newsletter ? 'yes' : 'no') . "</li>";
echo "<li>Comment:</li>";
echo antiXss($comment);
echo "</ul>";

echo "<h3>Print Superglobals</h3>";
echo "<ul>";
echo "<li>REQUEST_METHOD: " . antiXss($_SERVER['REQUEST_METHOD'] ?? '') . "</li>";
echo "<li>REQUEST_URI: " . antiXss($_SERVER['REQUEST_URI'] ?? '') . "</li>";
echo "<li>HTTP_USER_AGENT: " . antiXss($_SERVER['HTTP_USER_AGENT'] ?? '') . "</li>";
echo "<li>REMOTE_ADDR: " . antiXss($_SERVER['REMOTE_ADDR'] ?? '') . "</li>";
echo "</ul>";

echo '<p><a href="?p=06-form">Back to form</a></p>';