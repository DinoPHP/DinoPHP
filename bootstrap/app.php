
<?php

use Dinophp\Bootstrap\App;

class Application {
	/**
	 * Application constructor
	 *
	 */
	private function __construct() {}

	/**
	 * Run the application
	 *
	 * @return void
	 */
	public static function run() {
		/**
		 * Define root path
		 *
		 */
		define('ROOT', realpath(__DIR__.'/..'));

		/**
		 * Directory separator
		 *
		 */
		define('DS', DIRECTORY_SEPARATOR);

		/**
		 * Run the application
		 *
		 */
		App::run();
	}
}