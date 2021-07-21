<?php

namespace Dinophp\Bootstrap;

use Dinophp\Exception\Whoops;
use Dinophp\Http\Request;
use Dinophp\Http\Response;
use Dinophp\Http\Server;
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
    public static function run()
    {
        // Whoops for errors
        Whoops::handle();

        // Handle the request
        Request::handle();

        // Require all routes directory
        File::require_dir('routes');

		// Handle the route
        $data = Route::handle();

        Response::output($data);
    }
}
