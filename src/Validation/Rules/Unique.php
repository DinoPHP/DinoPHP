<?php

namespace Dinophp\Validation\Rules;

use Dinophp\Database\Database;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
	protected $message = ":attribute :value has been used";

	protected $fillableParams = ['table', 'column', 'except'];

	public function check($value): bool
	{
		// make sure required parameters exists
		$this->requireParameters(['table', 'column']);

		// getting parameters
		$column = $this->parameter('column');
		$table = $this->parameter('table');
		$except = $this->parameter('except');

		if ($except AND $except == $value) {
			return true;
		}

		// do query
		$data = Database::table($table)->where($column, '=', $value)->first();

		// true for valid, false for invalid
		return $data ? false : true;
	}
}

