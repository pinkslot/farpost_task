<?php
namespace app\App;

class App {
    public $config = null;
    public $db = null;
    public $user = null;

    public static function Instance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new App();
        }
        return $inst;
    }

    private function __construct()
    {
        $config = require_once 'config.php';
        $this->config = $config;

        $this->db = mysqli_connect(
            $config['db_server'], $config['db_user'], $config['db_password'], $config['db_db']
        );
        if (mysqli_connect_errno()) {
            throw new \Exception("Can't connect to db: " . mysqli_connect_error());
            exit();
        }

        $sid = $_COOKIE['sid'];
        if ($sid) {
            $res = $this->db->query(
                <<<SQL
SELECT `id`, `email` FROM `users`
WHERE `sid` = "$sid"
SQL
            );
            $this->user = $res->num_rows ? $res->fetch_assoc() : null;
            if (!$this->user) {
                setcookie('sid', null, -1, '/');
            }
        }
    }
}
