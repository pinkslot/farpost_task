<?php
namespace app\Controller;
define('ROOTPATH', __DIR__);

use app\Forms\LoginForm\LoginForm;
use app\Forms\RegForm\RegForm;
use app\utils;
use app\App\App;
use function app\utils\redirect;

class Controller {
	private static $routing = [
		'/' => 'index',
		'/reg' => 'reg',
		'/activation' => 'activation',
		'/login' => 'login',
		'/logout' => 'logout',
	];

    private function login($params) {
        $form = new LoginForm();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' and $post = $params['post']) {
            $form->populate($post);
            if ($form->execute()) {
            	utils\redirect('/');
            }
        }

        return utils\render_php('Templates/login.php', [
            'form' => $form,
            'after_activation' => $params['get'] and $params['get']['after_activation'],
            'site' => App::Instance()->config['site_name']
        ]);
    }

    private function logout($params) {
        if ($user = App::Instance()->user) {
            $user_id = $user['id'];
            App::Instance()->db->query(
                <<<SQL
UPDATE `users` SET `sid` = NULL
WHERE `id` = "$user_id"
SQL
            );
            setcookie('sid', null, -1, '/');
        }
        redirect('/');
    }

    private function reg($params) {
		$form = new RegForm();
		if ($_SERVER['REQUEST_METHOD'] === 'POST' and $post = $params['post']) {
			$form->populate($post);
			if ($form->execute()) {
				return "Activation link sent to $form->email";
			}
		}

		return utils\render_php('Templates/reg.php', [
			'form' => $form,
			'site' => App::Instance()->config['site_name']
		]);
	}

    private function activation($params) {
        $db = App::Instance()->db;
        if ($get = $params['get'] and $token = $get['token']) {
            $token = $db->real_escape_string($token);
            $db->query(
<<<SQL
UPDATE `users` SET `active` = 1
WHERE `reg_token` = "$token"
SQL
            );
            if ($db->affected_rows > 0) {
				redirect('/login?after_activation=1');
            }
        }

        return "Activation failed";
    }

	private function index($params) {
		return utils\render_php('Templates/index.php', [
			'title' => 'Index page',
            'site' => App::Instance()->config['site_name']
		]);
	}

	public function route($url, $params) {
		if (!array_key_exists($url, static::$routing)) {
			utils\redirect('/');
		}

		$action = static::$routing[$url];
		$result = $this->$action($params);
		return $result;
	}
}
?>
