<?php

namespace Dinophp\Validation;

use Dinophp\Http\Request;
use Dinophp\Url\Url;
use MongoDB\Driver\Session;
use Rakit\Validation\Validator;

class Validata {
	/**
	 * Validata constructor.
	 */
	private function __construct() {}

	/**
	 * Validate Request
	 *
	 * @param array $rules
	 * @param bool $json
	 *
	 * @return mixed
	 */
	public static function validate(Array $rules, $json) {
		$validator = new Validator;

		$validation = $validator->validate($_POST + $_FILES, $rules);
		$errors = $validation->errors();

		if ($validation->fails()) {
			if($json) {
				return ['errors' => $errors->firstOfAll()];
			} else {
				Session::set('errors', $errors);
				Session::set('old', Request::all());
				return Url::redirect(Url::previous());
			}
		}
	}
}