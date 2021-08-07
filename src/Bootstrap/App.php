<?php

namespace DinoPHP\Bootstrap;

use DinoPHP\Exception\Whoops;
use DinoPHP\Http\Request;
use DinoPHP\Http\Response;
use DinoPHP\File\File;
use DinoPHP\Router\Route;
use DinoPHP\Session\Session;


class App {
	/**
	 * App constructor
	 *
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Run the application
	 *
	 * @return void
	 */
	public static function run() {
		// Register whoops
		Whoops::handle();

		// Start session
		Session::start();

		// Handle the request
		Request::handle();

		// Require all routes directory
		File::require_directory('routes');

		// Handle the route
		$data = Route::handle();

		// Output the response
		Response::output($data);

		// Send http header
		header('X-Powered-By: DinoPHP');
	}
}
