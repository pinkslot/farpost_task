<?php
    use app\App\App;
    $app = App::Instance();
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/"><?= $app->config['site_name'] ?></a>
    </div>
    <ul class="nav navbar-nav pull-right">
      <?php if ($app->user): ?>
        <li><a href="#"><?= $app->user['email'] ?></a></li>
        <li><a href="/logout">Logout</a></li>
      <?php else: ?>
        <li><a href="/login">Login</a></li>
        <li><a href="/reg">Registration</a></li>
      <?php endif; ?>

    </ul>
  </div>
</nav>
