<?php

namespace Dinophp\Http;

class server {
    private function __construct(){}

    /*
    * Check server's key if available
    */

    public static function has($key) {
        return isset($_SERVER[$key]);
    }

    /*
    * Get all server data
    * @return array
    */

    public static function all() {
        return $_SERVER;
    }

    /*
    * Get the value from server
    */
    public static function get($key) {
        return static::has($key) ? $_SERVER[$key] : null;
    }

    /*
    * Get Path Info
    */
    public static function path_info($path) {
        return pathinfo($path);
    }
}