<?php namespace App\Models;

class Blueprint extends Model {
	
	protected $fillable = ['type', 'user_introduction', 'project_introduction',
						'story', 'estimated_amount', 'contact'];
	
	protected static $typeRules = [
		'type' => 'in:funding,sale',
		'user_introduction' => 'string|min:1',
		'project_introduction' => 'string|min:1',
		'story' => 'string|min:1',
		'estimated_amount' => 'string|min:1',
		'contact' => 'numeric'
	];
	
	protected static $creationRules = [
		'type' => 'required',
		'user_introduction' => 'required',
		'project_introduction' => 'required',
		'story' => 'required',
		'estimated_amount' => 'required',
		'contact' => 'required'
	];
	
	public function approve() {
		$this->setAttribute('approved', true);
		$this->save();
	} 
	
	public function user() {
		return $this->belongsTo('App\Models\User');
	}
	
	public function project() {
		return $this->belongsTo('App\Models\Project');
	}
	
	public function isProjectCreated() {
		return !empty($this->project_id);
	}
	
}
