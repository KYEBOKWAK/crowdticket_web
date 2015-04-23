<?php namespace App\Models;

class Ticket extends Model {
	
	protected $fillable = ['title', 'detail', 'audiences_limit', 'price', 'require_shipping', 'shipping_charge', 'delivery_date'];
	
	protected static $creationRules = [
		'title' => 'required',
		'detail' => 'required',
		'audiences_limit' => 'required|integer|min:1',
		'price' => 'required|integer|min:1',
		'require_shipping' => 'required:boolean',
		'shipping_charge' => 'required_if:require_shipping,true,1|integer|min:1',
		'delivery_date' => 'date_format:Y-m-d'
	];
	
	protected static $updateRules = [
		'audiences_limit' => 'integer|min:1',
		'price' => 'required_without',
		'require_shipping' => 'required_without',
		'shipping_charge' => 'required_without',
		'delivery_date' => 'date_format:Y-m-d'
	];
	
	public function project() {
		return $this->belongsTo('App\Models\Project');
	}
	
	public function orders() {
		return $this->hasMany('App\Models\Order');
	}

}
