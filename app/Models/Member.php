<?php namespace App\Models;

class Member extends Model {
	
	public function organization() {
		return $this->belongsTo('App\Models\Organization');
	}
	
	public function user() {
		return $this->belongsTo('App\Models\User');
	}

}
