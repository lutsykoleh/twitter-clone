<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'Twitter Clone'; ?></title>
  <link rel="stylesheet" href="/css/main.css">
</head>

<body>
  <?php include __DIR__ . '/../partials/header.php'; ?>
  <main>
    <?php include $content; ?>
  </main>
  <?php include __DIR__ . '/../partials/footer.php'; ?>
  <script type="text/javascript" src="js/main.js"></script>
</body>

</html>