<?php
namespace app\Forms\BaseLoginForm;

use app\Forms\BaseForm\BaseForm;

class BaseLoginForm extends BaseForm {
	public $email = '';
	public $password = '';

	static private $is_field_required = [
		'email' => true, 
		'password' => true, 
	];

	public $error = '';

	public static function getIsFieldRequired() {
		$result = self::$is_field_required;
        $result = array_merge(parent::getIsFieldRequired(), $result);
		return $result;
	}

	public function validate() {
	    if (!parent::validate()) {
	        return false;
        }

		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$this->error = "Email must be valid email address";
			return false;
		}

		// TODO: add password validation
		if (false) {
			$this->error = "Password must be strong enough";
			return false;
		}

		return true;
	}
}
