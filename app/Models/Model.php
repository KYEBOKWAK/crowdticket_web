<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use App\Exceptions\ValidationException;
use Validator;

abstract class Model extends BaseModel {
	
	protected static $creationRules = array();
	
	protected static $updateRules = array();
	
	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->validate($attributes, static::$creationRules);
	}
	
	public function update(array $attributes = array()) {
		if (empty(static::$updateRules)) {
			$this->validate($attributes, static::$creationRules);
		} else {
			$this->validate($attributes, static::$updateRules);
		}
		$this->fill($attributes);
	}
	
	private function validate(array $attributes = array(), $rules) {
		$validator = Validator::make($attributes, $rules);
		if ($validator->fails()) {
			throw new ValidationException($validator->messages());
		}
	}

}
