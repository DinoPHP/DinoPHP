<?php

use Dinophp\Bootstrap\App;

class Application {

    // Application Constructor
    private function __construct() {}

    // Run the application
    public static function run () {

        /*
        * Define root
        */
        define('ROOT', realpath(__DIR__.'/..'));

        // Directory separator 
        define('DS', DIRECTORY_SEPARATOR);

        // Run the application
        App::run();
    }
    
}