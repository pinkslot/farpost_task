<?php
use app\App\App;
$config = App::Instance()->config;
?>

Click this link to activate account on <?= $config['site_name'] ?>.

<?= $config['site_host']?>activation?token=<?= $args['token'] ?>