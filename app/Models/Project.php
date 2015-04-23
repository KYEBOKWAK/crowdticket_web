<?php namespace App\Models;

class Project extends Model {
	
	protected $fillable = [
		'location_fixed', 'title', 'poster_url', 'detailed_address', 'pledged_amount',
		'audiences_limit', 'commision_type', 'funding_closing_at', 'performance_opening_at'
	];
	
	protected static $creationRules = [
		'location_fixed' => 'boolean',
		'title' => 'required',
		'poster_url' => 'active_url',
		'detailed_address' => 'required_if:location_fixed,true,1|alpha_dash',
		'pledged_amount' => 'required|integer|min:0',
		'audiences_limit' => 'required|integer|min:1',
		'commision_type' => 'required|in:all_or_nothing,take_it_anyway',
		'funding_closing_at' => 'required_if:location_fixed,false,0|date_format:Y-m-d',
		'performance_opening_at' => 'required_if:location_fixed,true,1|date_format:Y-m-d'
	];
	
	protected static $updateRules = [
		'location_fixed' => 'accepted',
		'poster_url' => 'active_url',
		'detailed_address' => 'required_if:location_fixed,true,1|alpha_dash',
		'pledged_amount' => 'required_without',
		'audiences_limit' => 'integer|min:1',
		'commision_type' => 'required_without',
		'funding_closing_at' => 'required_without',
		'performance_opening_at' => 'required_if:location_fixed,true,1|date_format:Y-m-d'
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
