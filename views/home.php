<?php namespace views; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Subscribers</title>
</head>
<body>
<?php
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
?>
</body>
</html>