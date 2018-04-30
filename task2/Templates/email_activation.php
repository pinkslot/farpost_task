<?php
use app\App\App;
$config = App::Instance()->config;
?>

Click <a href="/activation?token=<?= $args['token'] ?>">this link</a>
to activate account on <?= $config['site_name'] ?>.

