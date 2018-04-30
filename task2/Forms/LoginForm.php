<?php
namespace app\Forms\LoginForm;

use app\App\App;
use app\Forms\BaseLoginForm\BaseLoginForm;

class LoginForm extends BaseLoginForm {
    public function execute() {
        if (!parent::execute()) {
            return false;
        }
        $email = App::Instance()->db->real_escape_string($this->email);

        $res = App::Instance()->db->query(
<<<SQL
SELECT `id`, `pass_hash`, `active` FROM `users`
WHERE `email` = "$email"
SQL
        );

        if (!$res->num_rows) {
            $this->error = 'Email is wrong';
            return false;
        }
        $user_data = $res->fetch_assoc();

        if (!$user_data['active']) {
            $this->error = 'Verify your email firstly.';
            return false;
        }

        if (!password_verify($this->password, $user_data['pass_hash'])) {
            $this->error = 'Password or email is wrong';
            return false;
        }

        $sid = md5(uniqid(rand(), true));
        setcookie('sid', $sid, time() + (60 * 60 * 24));
        App::Instance()->db->query(
<<<SQL
UPDATE `users` SET `sid` = "$sid"
WHERE `email` = "$email"
SQL
        );

        return true;
    }
}
