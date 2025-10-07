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
  <nav class="navbar">
      <a href="?p=home" class="<?= $current === 'home' ? 'active' : '' ?>">Home</a>

      <div class="dropdown">
        <button class="dropbtn <?= ($pages[$current]['group'] ?? '') === 'fundamentals' ? 'active' : '' ?>">
          Fundamentals ▾
        </button>
        <div class="dropdown-content">
          <?php foreach ($pages as $slug => $meta): ?>
            <?php if (($meta['group'] ?? '') === 'fundamentals'): ?>
              <a href="?p=<?= urlencode($slug) ?>" class="<?= $slug === $current ? 'active' : '' ?>">
                <?= htmlspecialchars($meta['title']) ?>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>

      <a href="?p=06-form" class="<?= ($pages[$current]['group'] ?? '') === 'forms' ? 'active' : '' ?>">Form</a>
    </nav>
    <hr>
  </header>