<?php
/** PHP DocBlock.
 * @var array $pages */
/** @var string $current */
// set security headers
  header("X-Content-Type-Options: nosniff");
  header("X-Frame-Options: DENY");
  header("Referrer-Policy: no-referrer-when-downgrade");
  header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline';");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>PHP Fundamentals</title>
  <style>
    body{font-family:system-ui,Arial,Helvetica,sans-serif;margin:20px}
    nav a{margin-right:10px;text-decoration:none}
    nav a.active{font-weight:bold;text-decoration:underline}
    .muted{color:#666}
    code{background:#f6f6f6;padding:2px 4px;border-radius:3px}
    hr{margin:20px 0}
  </style>
</head>
<body>
  <header>
    <h1>PHP Fundamentals</h1>
    <p class="muted">PHP version: <?= phpversion(); ?></p>
    <nav>
      <?php foreach ($pages as $slug => $meta): ?>
        <?php $isActive = ($slug === $current); ?>
        <a href="?p=<?= urlencode($slug) ?>" class="<?= $isActive ? 'active' : '' ?>">
          <?= htmlspecialchars($meta['title']) ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <hr>
  </header>