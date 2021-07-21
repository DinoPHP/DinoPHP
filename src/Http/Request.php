<?php

namespace Dinophp\Http;

class Request
{

    /**
     * Script name
     */
    private static $script_name;

    /**
     * Base Url
     */
    private static $base_url;

    /**
     * Url
     */
    private static $url;

    /**
     * Full Url
     */
    private static $full_url;

    /**
     * Query String
     */
    private static $query_string;

    /**
     * Request Construct
     */
    private function __construct()
    {
    }

    /**
     * Handle the request
     */
    public static function handle()
    {
        static::setBaseUrl();
        static::setUrl();
        static::$script_name = str_replace('\\', '', dirname(Server::get('SCRIPT_NAME')));
    }

    /**
     * Set Base Url
     */
    private static function setBaseUrl()
    {
        $protocol = Server::get('REQUEST_SCHEME') . '://';
        $host = Server::get('HTTP_HOST');
        $script_name = static::$script_name;

        static::$base_url = $protocol . $host . $script_name;
    }

    /**
     * Set Url
     */
    private static function setUrl()
    {
        $request_uri = urldecode(Server::get('REQUEST_URI'));
        $request_uri = rtrim(preg_replace('#^' . static::$script_name . '#', '', $request_uri), '/');

        $query_string = '';

        static::$full_url = $request_uri;
        if (strpos($request_uri, '?') !== false) {
            list($request_uri, $query_string) = explode('?', $request_uri);
        }

        static::$url = $request_uri?:'/';
        static::$query_string = $query_string;
    }

    /**
     * Get Base Url
     */
    public static function BaseUrl()
    {
        return static::$base_url;
    }

    /**
     * Get Url
     */
    public static function Url()
    {
        return static::$url;
    }

    /**
     * Query String
     */
    public static function QueryString()
    {
        return static::$query_string;
    }

    /**
     * Full Url
     */
    public static function FullUrl()
    {
        return static::$full_url;
    }

    /**
     * 
     * Get Request Methods
     * 
     */
    public static function method()
    {
        return Server::get('REQUEST_METHOD');
    }

    /**
     * 
     * Check if the request has the key
     * 
     */
    public static function has($type, $key)
    {
        return array_key_exists($key, $type);
    }

    /**
     * 
     * Get the value from the request
     * 
     */
    public static function value($key, array $type = null)
    {
        $type = isset($type) ? $type : $_REQUEST;
        return static::has($type, $key) ? $type[$key] : null;
    }

    /**
     * 
     * Get Value from get request
     * 
     */
    public static function get($key)
    {
        return static::value($key, $_GET);
    }

    /**
     * 
     * Get Value from post request
     * 
     */
    public static function post($key)
    {
        return static::value($key, $_POST);
    }

    /**
     * 
     * Get Value from post request
     * 
     */
    public static function set($key, $value)
    {
        $_REQUEST[$key] = $value;
        $_POST[$key] = $value;
        $_GET[$key] = $value;

        return $value;
    }

    /**
     * 
     * Get previous request
     * 
     */
    public static function previous()
    {
        return Server::get('HTTP_REFERER');
    }

    /**
     * 
     * Get request all
     * 
     */
    public static function all()
    {
        return $_REQUEST;
    }
}
