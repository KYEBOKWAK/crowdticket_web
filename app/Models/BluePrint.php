<?php namespace App\Models;

class Blueprint extends Model {
	
	protected $fillable = [];
	
	protected $hidden = ['code'];
	
	protected static $creationRules = [
		//
	];
	
	public function user() {
		return $this->belongsTo('App\Models\User');
	}
	
	public function project() {
		return $this->hasOne('App\Models\Project');
	}
	
}
