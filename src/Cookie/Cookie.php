<?php

namespace DinoPHP\Cookie;

class Cookie {
	/**
	 * Cookie constructor
	 *
	 */
	private function __construct() {}

	/**
	 * Set new cookie
	 *
	 * @param string $key
	 * @param string $value
	 *
	 * @return string $value
	 */
	public static function set($key, $value) {
		$expired = time() + (1 * 365 * 24 * 60 * 60);
		setcookie($key, $value, $expired, '/', '', false, true);

		return $value;
	}

	/**
	 * Check that cookie has the key
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public static function has($key) {
		return isset($_COOKIE[$key]);
	}

	/**
	 * Get cookie by the given key
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public static function get($key) {
		return static::has($key) ? $_COOKIE[$key] : null;
	}

	/**
	 * Remove cookie by the given key
	 *
	 * @param string $key
	 * @return void
	 */
	public static function remove($key) {
		unset($_COOKIE[$key]);
		setcookie($key, null, '-1', '/');
	}

	/**
	 * Return all cookies
	 *
	 * @return array
	 */
	public static function all() {
		return $_COOKIE;
	}

	/**
	 * Destroy the cookie
	 *
	 * return void
	 */
	public static function destroy() {
		foreach(static::all() as $key => $value) {
			static::remove($key);
		}
	}
}