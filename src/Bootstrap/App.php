<?php

namespace Dinophp\Bootstrap;

use Dinophp\Exception\Whoops;
use Dinophp\Http\Request;
use Dinophp\Http\Response;
use Dinophp\File\File;
use Dinophp\Router\Route;

class App
{
    /**
     * 
     * App Constructor
     * 
     */
    private function __construct() {}

    /**
     * 
     * Run the application
     *
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
    }
}
