<?php

namespace Dinophp\Url;

use Dinophp\Http\Request;
use Dinophp\Http\server;

class Url {
	/**
	 * Url constructor.
	 */
	private function __construct() {}

	/**
	 * Get Path
	 * @param string $path
	 * @return string $path
	 */
	public static function path($path) {
		return Request::baseUrl() . '/' . trim($path, '/');
	}

	/**
	 * Previous Url
	 * @return mixed|null
	 */
	public static function previous() {
		return Server::get('HTTP_REFERER');
	}

	/**
	 * Previous Url
	 * @param $path
	 */
	public static function redirect($path) {
		header('Location: ' . $path);
		exit();
	}
}