<?php
namespace views;

$pageTitle = "Let's keep in touch!";
$cssFile = "form";

include "common/header.php";

class Home
{
  public function setForm($form) {
    $formPath = "views/forms/". $form .".php";

    if ( !is_readable($formPath) ) : ?>
      <p>An error occurred loading the form.</p>
    <?php else :
      include $formPath;
    endif;
  }
}
