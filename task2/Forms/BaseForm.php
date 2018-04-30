<?php
namespace app\Forms\BaseForm;

class BaseForm {
	static private $is_field_required = [
	];

	public $error = '';

	public static function getIsFieldRequired() {
		return self::$is_field_required;
	}

	public function populate($data) {
		foreach (static::getIsFieldRequired() as $field => $is_required) {
			if ($data[$field]) {
				$this->$field = $data[$field];
			}
		}
	}

//	TODO: Should keep field by field validation error info
	public function validate() {
		foreach (static::getIsFieldRequired() as $field => $value) {
			if ($value and !$this->$field) {
				$this->error = lcfirst($field) . " is required";
				return false;
			}
		}
		return true;
	}

    public function execute() {
	    return $this->validate();
    }
}
