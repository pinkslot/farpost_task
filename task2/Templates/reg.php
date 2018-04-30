<!DOCTYPE html>
<html>
<head>
  <?php include 'header.php'?>
  <title> Registration | <?= $args['site']; ?></title>
</head>
<body>

<?php include 'layout_auth_bar.php' ?>

<?php
  $form = $args['form'];
  $isFieldRequired = $form->getIsFieldRequired();
  $error = $form->error;
?>
<div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
  <form class="form" method="POST" action="/reg">
    <h3 class="text-center">Registration</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger">
          <?= $error ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
      <label class="control-label" for="regform-email">Email</label>
      <input
        type="email"
        id="regform-email"
        class="form-control"
        name="email"
        aria-required="<?= $isFieldRequired['email'] ?>"
        value=<?= $form->email ?>
      >
    </div>

    <div class="form-group">
      <label class="control-label" for="regform-password">Password</label>
      <input
        type="password"
        id="regform-password"
        class="form-control"
        name="password"
        aria-required="<?= $isFieldRequired['password'] ?>"
        value=<?= $form->password ?>
      >
    </div>

    <div class="form-group">
      <label class="control-label" for="regform-repeat-password">Repeat password</label>
      <input
        type="password"
        id="regform-repeat-password"
        class="form-control"
        name="password_repeat"
        aria-required="<?= $isFieldRequired['password_repeat'] ?>"
        value=<?= $form->password_repeat ?>
      >
    </div>

    <button class="btn btn-default">Registration</button>
  </form>
</div>
</body>
</html>