<?php
namespace app\Forms\RegForm;

use app\utils;
use app\App\App;
use app\Forms\BaseLoginForm\BaseLoginForm;

class RegForm extends BaseLoginForm {
	public $password_repeat = '';

	static private $is_field_required = [
		'password_repeat' => true
	];

    private function passwordHash() {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

//  TODO: should remove row if not activated
	private function checkEmailUsed() {
        $email = App::Instance()->db->real_escape_string($this->email);

        $res = App::Instance()->db->query(
<<<SQL
SELECT (`id`) FROM `users`
WHERE `email` = "$email"
SQL
        );
        return $res->num_rows > 0;
    }

    private function createUser($reg_token) {
        $query = App::Instance()->db->prepare(
            <<<SQL
INSERT INTO `users` (`email`, `pass_hash`, `reg_token`)
VALUES (?, ?, ?)
SQL
        );
        $query->bind_param(
            "sss",
            $this->email,
            static::passwordHash(),
            $reg_token
        );

        if (!$query->execute()) {
            $this->error = "DB error: $query->error";
            return false;
        }
        return true;
    }

    public function execute() {
        if (!parent::execute()) {
            return false;
        }

        if ($this->checkEmailUsed()) {
            $this->error = "This email already used";
            return false;
        }

        $reg_token = md5(uniqid(rand(), true));
        if (!$this->createUser($reg_token)) {
            return false;
        }

        $letter = utils\render_php('Templates/email_activation.php', [
            'token' => $reg_token,
        ]);
        if (!mail(
            $this->email,
            'Account activation',
            $letter
        )) {
            $this->error = "Mail error";
            return false;
        }

        return true;
    }
}
