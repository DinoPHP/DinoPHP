<?php

/**
 * View render
 *
 * @param string $path
 * @param array $data
 * @return mixed
 */
if(! function_exists('view')) {
	function view($path, $data = []) {
		return DinoPHP\View\View::render($path, $data);
	}
}

/**
 * Request get
 *
 * @param string $key
 * @return mixed
 */
if(! function_exists('request')) {
	function request($key) {
		return DinoPHP\Http\Request::value($key);
	}
}

/**
 * Redirect
 *
 * @param string $path
 * @return mixed
 */
if(! function_exists('redirect')) {
	function redirect($path) {
		return DinoPHP\Url\Url::redirect($path);
	}
}

/**
 * Previous
 *
 * @return mixed
 */
if(! function_exists('previous')) {
	function previous() {
		return DinoPHP\Url\Url::previous();
	}
}

/**
 * Url path
 *
 * @param string $path
 * @return mixed
 */
if(! function_exists('url')) {
	function url($path) {
		return DinoPHP\Url\Url::path($path);
	}
}

/**
 * Asset path
 *
 * @param string $path
 * @return mixed
 */
if(! function_exists('asset')) {
	function asset($path) {
		return DinoPHP\Url\Url::path($path);
	}
}

/**
 * Dump and die
 *
 * @param string $data
 * @return void
 */
if(! function_exists('dd')) {
	function dd($data) {
		echo "<pre>";
		if(is_string($data)) {
			echo $data;
		} else {
			print_r($data);
		}
		echo "</pre>";
		die();
	}
}

/**
 * Get session data
 *
 * @param string $key
 * @return string $data
 */
if(! function_exists('session')) {
	function session($key) {
		return DinoPHP\session\session::get($key);
	}
}

/**
 * Get session flash data
 *
 * @param string $key
 * @return string $data
 */
if(! function_exists('flash')) {
	function flash($key) {
		return DinoPHP\session\session::flash($key);
	}
}

/**
 * show pagination links
 *
 * @param string $current_page
 * @param string $pages_page
 * @return string
 */
if(! function_exists('links')) {
	function links($current_page, $pages) {
		return DinoPHP\Database\Database::links($current_page, $pages);
	}
}

/**
 * Table auth
 *
 * @param string $table
 * @return string
 */
if(! function_exists('auth')) {
	function auth($table) {
		$auth = DinoPHP\Session\Session::get($table) ?: DinoPHP\Cookie\Cookie::get($table);
		return DinoPHP\Database\Database::table($table)->where('id', '=', $auth)->first();
	}
}