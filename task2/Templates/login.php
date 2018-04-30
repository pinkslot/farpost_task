<!DOCTYPE html>
<html>
<head>
  <?php include 'header.php'?>
  <title>Login | <?= $args['site']; ?></title>
</head>
<body>
<?php include 'layout_auth_bar.php' ?>

<?php 
  $form = $args['form'];
  $after_activation = $args['after_activation'];
  $isFieldRequired = $form->getIsFieldRequired('password');
  $error = $form->error;
?>
<div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
  <form class="form" method="POST" action="/login">
    <h3 class="text-center">Login</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger">
          <?= $error ?>
        </div>
    <?php endif; ?>

    <?php if ($after_activation): ?>
      <div class="alert alert-success">
          Activation successful
      </div>
    <?php endif; ?>

    <div class="form-group">
      <label class="control-label" for="loginform-email">Email</label>
      <input
        type="email"
        id="loginform-email"
        class="form-control"
        name="email"
        aria-required="<?= $isFieldRequired['email'] ?>"
        value=<?= $form->email ?>
      >
    </div>

    <div class="form-group">
      <label class="control-label" for="loginform-password">Password</label>
      <input
        type="password"
        id="loginform-password"
        class="form-control"
        name="password"
        aria-required="<?= $isFieldRequired['password'] ?>"
        value=<?= $form->password ?>
      >
    </div>

    <button class="btn btn-default">Login</button>
  </form>
</div>
</body>
</html>