<?php namespace App\Models;

class Order extends Model {
	
	protected $fillable = ['address', 'contact'];
	
	protected static $creationRules = [
		'address' => 'alpha_dash',
		'contact' => 'required|numeric'
	];
	
	protected static $updateRules = [
		'address' => 'alpha_dash',
		'contact' => 'numeric'
	];
	
	public function project() {
		return $this->belongsTo('App\Models\Project');
	}
	
	public function ticket() {
		return $this->belongsTo('App\Models\Ticket');
	}
	
	public function user() {
		return $this->belongsTo('App\Models\User');
	}

}
