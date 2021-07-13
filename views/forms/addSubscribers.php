<?php if ( isset($_GET["added"]) ) : ?>
  <div class="alert alert-success">
    <p>You have successfully subscribed.</p>
  </div>
<?php elseif ( isset($_GET["error"]) ) : ?>
  <div class="alert alert-error">
    <p>An error has occurred, please try again.</p>
  </div>
<?php endif; ?>

<div class="d-flex row">
  <div class="d-flex col col-image">
    <img src="assets/images/email-icon.png" alt="email">
  </div>
  <div class="d-flex col col-form">
    <h1 class="form__title">Let's keep in touch!</h1>
    <form action="add" class="form" method="post">
      <div class="form__group">
        <label for="email" class="form__label">Email address</label>
        <input id="email" name="email" type="email" placeholder="Email address" class="form__input" required>
      </div>
      <div class="form__group">
        <label for="name" class="form__label">Name</label>
        <input id="name" name="name" type="text" placeholder="Name" class="form__input">
      </div>
      <div class="form__group">
        <input id="terms" name="terms" type="checkbox" value="accepted">
        <label for="terms">I accept the <a class="form__link" href="https://www.aweber.com/permission.htm" ref="noopenner noreferrer" target="_blank">terms and conditions</a></label>
      </div>
      <button class="form__btn">Subscribe</button>
    </form>
  </div>
</div>