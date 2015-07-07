<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use App\Exceptions\ValidationException;
use Validator;

abstract class Model extends BaseModel {
	
	const S3_BASE_URL = "https://crowdticket.s3.amazonaws.com/";
	const S3_POSTER_BUCKET = "posters/";
	const S3_STORY_BUCKET = "stories/";
	const S3_NEWS_BUCKET = "news";
	const S3_USER_BUCKET = "users";
	
	protected static $typeRules = array();
	
	protected static $creationRules = array();
	
	protected static $updateRules = array();
	
	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		if (!empty($attributes)) {
			$this->validate($attributes, static::$typeRules);
			$this->validate($attributes, static::$creationRules);
		}
	}
	
	public function update(array $attributes = array()) {
		$this->validate($attributes, static::$typeRules);
		$this->validate($attributes, static::$updateRules);
		$this->fill($attributes);
	}
	
	private function validate(array $attributes = array(), $rules) {
		$validator = Validator::make($attributes, $rules);
		if ($validator->fails()) {
			throw new ValidationException($validator->messages());
		}
	}

}
