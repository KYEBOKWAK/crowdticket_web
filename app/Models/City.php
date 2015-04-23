<?php namespace App\Models;

class City extends Model {

	protected $table = 'cities';
	
	protected $fillable = ['name'];
	
	protected static $creationRules = [
		'name' => 'required'
	];
	
	public function projects() {
		return $this->hasMany('App\Models\Project');
	}
	
	public function country() {
		return $this->belongsTo('App\Models\Country');
	}

}
