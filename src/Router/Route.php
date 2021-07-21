<?php

namespace Dinophp\Router;

use Dinophp\Http\Request;
use Dinophp\Exception;
use Dinophp\View\View;

class Route {

    /**
     * Route Countainer
     */
    private static $routes = [];

    /**
     * Middleware Container
     */
    private static $middleware;

    /**
     * Prefix
     */
    private static $prefix;

    /**
     * Route Constructor
     */
    private function __construct(){}

    /**
     * Add Route
     * @param object|callback $callback
     */
    private static function add($methods, $uri, $callback) {
    	$uri = trim($uri, '/');
        $uri = rtrim(static::$prefix . '/' . $uri, '/');
        $uri = $uri ?: '/';
        foreach (explode('|', $methods) as $method) {
            static::$routes[] = [
                'uri' => $uri,
                'callback' => $callback,
                'method' => $method,
                'middleware' => static::$middleware
            ];
        }
    }

    /**
     * 
     * Add new get route
     * @param string $uri
     */
    public static function get($uri, $callback) {
        static::add('GET', $uri, $callback);
    }

    /**
     *
     * Add new post route
     * @param string $uri
     */
    public static function post($uri, $callback) {
        static::add('POST', $uri, $callback);
    }

    /**
     *
     * Add any route
     * @param string $uri
     */
    public static function any($uri, $callback) {
        static::add('GET|POST', $uri, $callback);
    }

    /**
     * Set Prefix for routing
     * @param string $prefix
     * @param callback $callback
     */
	/**
	 * @return mixed
	 */
	public static function prefix($prefix, $callback)
	{
		$parent_prefix = static::$prefix;
		static::$prefix .= '/' . trim($prefix, '/');
		if(is_callable($callback)) {
			call_user_func($callback);
		} else {
			throw new \BadFunctionCallException('Please provide a valid callback');
		}
		static::$prefix = $parent_prefix;
	}

	/**
	 * Set Middleware for routing
	 * @param string $middleware
	 * @param callback $callback
	 */
	/**
	 * @return mixed
	 */
	public static function middleware($middleware, $callback)
	{
		$parent_middleware = static::$middleware;
		static::$middleware .= '|' . trim($middleware, '|');
		if(is_callable($callback)) {
			call_user_func($callback);
		} else {
			throw new \BadFunctionCallException('Please provide a valid callback');
		}
		static::$middleware = $parent_middleware;
	}

	/**
	 *
	 * Handle the request and match routes
	 * @return mixed
	 */
	public static function handle() {
		$uri = Request::url();
		foreach (static::$routes as $route) {
			$matched = true;
			$route['uri'] = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['uri']);
			$route['uri'] = '#^' . $route['uri'] . '$#';
			if(preg_match($route['uri'], $uri, $matches)) {
				array_shift($matches);
				$params = array_values($matches);
				foreach ($params as $param) {
					if(strpos($param, '/')) {
						$matched = false;
					}
				}
				if($route['method'] != Request::method()) {
					$matched = false;
				}
				if($matched == true) {
					return static::invoke($route, $params);
				}
			}
		}
		return View::render('errors.404');
	}

	/**
	 * Invoke routes
	 *
	 * @param array $route
	 * @param array $params
	 */
	public static function invoke($route, $params = []) {
		static::executeMiddleware($route);
		$callback = $route['callback'];
		if(is_callable($callback)) {
			return call_user_func_array($callback, $params);
		} elseif(strpos($callback, '@') !== false) {
			list($controller, $method) = explode('@', $callback);
			$controller = 'App\Controllers\\' . $controller;
			if(class_exists($controller)) {
				$object = new $controller;
				if(method_exists($object, $method)) {
					return call_user_func_array([$object, $method], $params);
				} else {
					throw new \BadFunctionCallException("The method " . $method . " is not exists at " . $controller);
				}
			} else {
				throw new \ReflectionException("Class " . $controller . " is not found");
			}
		} else {
			throw new \InvalidArgumentException("Please provide valid callback function");
		}
	}

	/**
	 * Execute Middleware
	 *
	 * @param array $route
	 */

	public static function executeMiddleware ($route) {
		foreach (explode('|', $route['middleware']) as $middleware) {
			if($middleware != '') {
				$middleware = 'App\Middleware\\' . $middleware;
				if(class_exists($middleware)) {
					$object = new $middleware;
					call_user_func_array([$object, 'handle'], []);
				} else {
					throw new \ReflectionException("Class " . $middleware . " is not found");
				}
			}
		}
	}
}