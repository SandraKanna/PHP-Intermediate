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
  <title>PHP Training</title>
  <link rel="stylesheet" href="/assets/style.css?v=1"> <!-- with cache-busting when changing styles -->
</head>
<body>
  <div class="container">
  <header>
    <h1>PHP Training</h1>
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