<?php

namespace DinoPHP\Csrf;

class Csrf {

	private function __construct() {}

	public static function generate_token() {
		// Check if a token is present for the current session
		if(!isset($_SESSION["csrf_token"])) {
			// No token present, generate a new one
			$token = bin2hex(random_bytes(32));
			$_SESSION["csrf_token"] = $token;
		} else {
			// Store the token
			$token = $_SESSION["csrf_token"];
		}
		return $token;
	}
	/**
	 * Validate CSRF Token
	 * @param $token
	 */
	public static function validate_csrf($token) {
		if (!empty($_POST['token'])) {
			if(hash_equals($_SESSION['token'], $_POST['token'])) {
				// Proceed to process the form data
			} else {
				// Log this as a warning and keep an eye on these attempts
			}
		}
	}
}
