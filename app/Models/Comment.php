<?php namespace App\Models;

class Comment extends Model {
	
	protected $fillable = ['contents'];
	
	public function user() {
		return $this->belongsTo('App\Models\User');
	}
	
	public function commentable() {
		return $this->morphTo();
	} 
	
	public function comments() {
		return $this->morphMany('App\Models\Comment', 'commentable')->orderBy('created_at', 'desc');
	}

}
