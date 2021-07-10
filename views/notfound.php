<?php namespace views; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <base href="<?= FOLDER_PATH ?>/">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Not found!</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/not-found.css">
</head>
<body>
<?php
class NotFound
{
  public function show() { ?>

    <div class="container">
      <img src="assets/images/404-icon.png" alt="window" height="150">
      <h1>Not found!</h1>
      <a href="./" class="link">Go home!</a>
      <p class="version">
        <?= date('Y') ?> &copy; v <?= APP_VERSION ?>
      </p>
    </div>

<?php 
  }
}