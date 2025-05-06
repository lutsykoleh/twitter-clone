<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'Twitter Clone'; ?></title>
  <link rel="shortcut icon" href="/images/icon.svg">
  <link rel="stylesheet" href="/css/main.css">
</head>

<body>
  <div class="container">
    <div class="wrapper">
      <header class="header">
        <button id="hamburger" class="hamburger" aria-label="Toggle menu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </header>
      <div class="content">
        <?php include __DIR__ . '/../partials/sidebar.php'; ?>
        <main class="main">
          <?php include $content; ?>
        </main>
      </div>
      <?php include __DIR__ . '/../partials/footer.php'; ?>
    </div>
  </div>
  <script src="/js/main.js"></script>
</body>

</html>