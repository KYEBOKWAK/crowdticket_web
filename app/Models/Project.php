<?php namespace App\Models;

class Project extends Model {
	
	protected $fillable = [
		'location_fixed', 'title', 'description', 'video_url',
		'detailed_address', 'pledged_amount', 'audiences_limit', 
		'commision_type', 'funding_closing_at', 'performance_opening_at'
	];
	
	protected static $typeRules = [
		'location_fixed' => 'accepted',
		'title' => 'string',
		'description' => 'string',
		'video_url' => 'active_url',
		'detailed_address' => 'required_if:location_fixed,true,1|string',
		'pledged_amount' => 'integer|min:0',
		'audiences_limit' => 'integer|min:1',
		'commision_type' => 'in:all_or_nothing,take_it_anyway',
		'funding_closing_at' => 'date_format:Y-m-d',
		'performance_opening_at' => 'date_format:Y-m-d'
	];
	
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
