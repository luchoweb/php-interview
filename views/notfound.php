<?php
namespace views;

$pageTitle = "Error: 404 - Not found!";
$cssFile = "not-found";

include "common/header.php";

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