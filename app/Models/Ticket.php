<?php namespace App\Models;

class Ticket extends Model {
	
	protected $fillable = [
		'price', 'real_ticket_count', 'reward',
		'require_shipping', 'audiences_limit',
		'delivery_date', 'shipping_charge'
	];
	
	protected static $typeRules = [
		'price' => 'integer',
		'real_ticket_count' => 'integer',
		'reward' => 'string|min:1',
		'audiences_limit' => 'integer',
		'delivery_date' => 'date_format:Y-m-d',
		'shipping_charge' => 'integer'
	];
	
	protected static $creationRules = [
		'price' => 'required',
		'real_ticket_count' => 'required',
		'reward' => 'required',
		'require_shipping' => 'required',
		'audiences_limit' => 'required',
		'delivery_date' => 'required'
	];
	
	public function update(array $attributes = array()) {
		if ($this->audiences_count === 0) {
			parent::update($attributes);
		} else {
			// throw exception?
		}
	}
	
	public function project() {
		return $this->belongsTo('App\Models\Project');
	}
	
	public function orders() {
		return $this->hasMany('App\Models\Order');
	}

}
