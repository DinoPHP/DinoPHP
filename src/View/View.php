<?php

namespace Dinophp\View;

use Dinophp\File\File;
use Dinophp\Session\Session;
use Jenssegers\Blade\Blade;

class View {
	/**
	 * View constructor.
	 */
	private function __construct() {}

	/**
	 * Render View Files
	 * @param $path
	 * @param array $data
	 */
	public static function render($path, $data = []) {
		$errors = Session::flash('errors');
		$old = Session::flash('old');
		$data = array_merge($data, ['errors' => $errors, 'old' => $old]);
		return static::bladeRender($path, $data);
	}

	/**
	 * Render the view using blade engine
	 * @param $path
	 * @param array $data
	 * @return string
	 */
	public static function bladeRender($path, $data = []) {
		$blade = new Blade(File::path('views'), File::path('storage/cache'));
		return $blade->make($path, $data)->render();
	}

	/**
	 * Render View Files
	 * @param $path
	 * @param array $data
	 */
	public static function ViewRender($path, $data = []) {
		$path = 'views' . File::ds() . str_replace(['/', '\\', '.'], File::ds(), $path) . '.php';
		if(! File::exist($path)) {
			throw new \Exception("The view file {$path} is not exist");
		}

		ob_start();
		extract($data);
		include File::path($path);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}