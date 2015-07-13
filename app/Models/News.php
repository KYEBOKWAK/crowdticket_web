<?php namespace App\Models;

class News extends Model {
	
	protected $table = 'news';
	
	protected $fillable = ['title', 'content'];
	
	protected static $creationRules = [
		'title' => 'required',
		'content' => 'required'
	];
	
	public function project() {
		return $this->belongsTo('App\Models\Project');
	}
	
}
