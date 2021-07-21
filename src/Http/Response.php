<?php

namespace Dinophp\Http;

class Response {

	/**
	 * Response constructor.
	 */
	private function __construct() {}

	/**
	 * Return Json Encode
	 * @param $data
	 * @return false|string
	 */
	public static function json($data) {
		return json_encode($data);
	}

	/**
	 * Output Data
	 * @param mixed $data
	 */
	public static function output($data) {
		if(! $data) {
			return ;
		}
		if(!is_string($data)) {
			$data = static::json($data);
		}
		echo $data;
	}
}