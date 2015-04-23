<?php namespace App\Models;

class Organization extends Model {
	
	protected $fillable = ['name', 'email', 'contact', 'site_url', 'corporate'];
	
	protected static $creationRules = [
		'name' => 'required',
		'email' => 'required|email',
		'contact' => 'required|numeric',
		'site_url' => 'active_url',
		'corporate' => 'required|boolean'
	];
	
	protected static $updateRules = [
		'name' => 'required_without',
		'email' => 'email',
		'contact' => 'numeric',
		'site_url' => 'active_url',
		'corporate' => 'required_without'
	];
	
	public function master() {
		return $this->belongsTo('App\Models\User');
	}
	
	public function projects() {
		return $this->hasMany('App\Models\Project');
	}
	
}
