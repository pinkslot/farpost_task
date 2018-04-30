<?php
namespace app;
$root_path = dirname(__FILE__);

// autoload should be added
require_once 'App.php';
require_once 'Controller.php';
require_once 'utils.php';

require_once 'Forms\BaseForm.php';
require_once 'Forms\BaseLoginForm.php';
require_once 'Forms\RegForm.php';
require_once 'Forms\LoginForm.php';

use app\Controller\Controller;

$controller = new Controller();

$url_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$url = $url_parts[0];

echo $controller->route($url, [
	'get' => $_GET,
	'post' => $_POST,
	'files' => $_FILES,
]);
