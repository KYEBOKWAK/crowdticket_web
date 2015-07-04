<?php namespace App\Models;

class Project extends Model {
	
	const STATE_READY = 1;
	const STATE_READY_AFTER_FUNDING = 2;
	const STATE_UNDER_INVESTIGATION = 3;
	const STATE_ACCEPTED = 4;
	
	protected static $fillableByState = [
		Project::STATE_READY => [
			'title', 'alias', 'poster_url', 'description', 'video_url',
			'detailed_address', 'pledged_amount', 'audiences_limit', 
			'funding_closing_at', 'performance_opening_at'
		],
		
		Project::STATE_READY_AFTER_FUNDING => [
			'poster_url', 'description', 'video_url',
			'detailed_address', 'audiences_limit',
			'performance_opening_at'
		],
		
		Project::STATE_UNDER_INVESTIGATION => [
			// nothing can update
		],
		
		Project::STATE_ACCEPTED => [
			'poster_url', 'description', 'video_url', 'detailed_address'
		]
	];
	
	protected static $typeRules = [
		'title' => 'string|min:1|max:30',
		'alias' => 'regex:/^[a-zA-Z]{1}[a-zA-Z0-9-_]{3,63}$/',
		'poster_url' => 'active_url',
		'description' => 'string',
		'video_url' => 'active_url',
		'detailed_address' => 'string',
		'pledged_amount' => 'integer|min:0',
		'audiences_limit' => 'integer|min:0',
		'funding_closing_at' => 'date_format:Y-m-d',
		'performance_opening_at' => 'date_format:Y-m-d'
	];
	
	public function update(array $attributes = array()) {
		$this->fillable = static::$fillableByState[$this->state];
		parent::update($attributes);
	}
	
	public function category() {
		return $this->belongsTo('App\Models\Category');
	}

	public function organization() {
		return $this->belongsTo('App\Models\Organization');
	}

	public function user() {
		return $this->belongsTo('App\Models\User');
	}
	
	public function city() {
		return $this->belongsTo('App\Models\City');
	}

	public function tickets() {
		return $this->hasMany('App\Models\Ticket');
	}

	public function orders() {
		return $this->hasMany('App\Models\Order');
	}

	public function supporters() {
		return $this->hasMany('App\Models\Supporter');
	}
	
	public function comments() {
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

}
