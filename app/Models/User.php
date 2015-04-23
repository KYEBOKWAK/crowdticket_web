<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $fillable = ['email', 'name', 'password', 'profile_photo_url'];

	protected $hidden = ['password', 'remember_token', 'facebook_id'];
	
	protected static $creationRules = [
		'email' => 'required|email|unique:users',
		'name' => 'required|alpha',
		'profile_photo_url' => 'active_url'
	];
	
	protected static $updateRules = [
		'name' => 'alpha',
		'profile_photo_url' => 'active_url'
	];
	
	public function projects() {
		return $this->hasMany('App\Models\Project');
	}
	
	public function comments() {
		return $this->hasMany('App\Models\Comment');
	}
	
	public function orders() {
		return $this->hasMany('App\Models\Order');
	}

}
