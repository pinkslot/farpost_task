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
        '/upload' => 'upload',
    ];

    private function upload($params) {
        $app = App::Instance();
        $imgs = $params['files']['imgs'];
        var_dump($imgs);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'
            or empty($imgs['name']) or !$imgs['name'][0]
        ) {
            return;
        }

        if (!$app->user) {
            redirect('/login');
        }

        $result = [
            'errors' => [],
            'uploaded_files' => [],
        ];

        $target_path = $app->config['file_storage'] . $app->user['id'] . '/';

        if (!file_exists($target_path)) {
            mkdir($target_path);
        }

        for ($i = 0; $i < count($imgs['name']); $i++) {
            $orig_name = $imgs['name'][$i];

            if ($imgs['size'][$i] > 100000) {
                array_push($result['errors'], "File $orig_name is too big.\n");
                continue;
            }

            if (getimagesize($imgs['tmp_name'][$i]) === false) {
                array_push($result['errors'], "File $orig_name is not an image.\n");
                continue;
            }

            $target_name = $target_path . md5(uniqid()) . "." . $orig_name;
            move_uploaded_file($imgs['tmp_name'][$i], $target_name);
            array_push($result['uploaded_files'], $target_name);
        }

        $result = json_encode($result);
        return "<div data-result='$result' id='upload_data'></div>";
    }

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
        $app = App::Instance();
        $imgs = [];
        if ($app->user) {
            $img_dir = $app->config['file_storage'] . $app->user['id'] . '/';
            $imgs = scandir($img_dir);
            $imgs = array_filter($imgs, function($img) { return $img[0] != '.'; });
            $imgs = array_map(function($img) use ($img_dir){
                return $img_dir . $img;
            }, $imgs);
        }

        return utils\render_php('Templates/index.php', [
            'title' => 'Index page',
            'site' => App::Instance()->config['site_name'],
            'imgs' => $imgs,
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
