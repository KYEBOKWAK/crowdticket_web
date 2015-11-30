<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $fillable = ['email', 'name', 'password', 'profile_photo_url', 'contact', 'website'];

	protected $hidden = ['password', 'remember_token', 'facebook_id'];
	
	protected static $creationRules = [
		'email' => 'required|email|unique:users',
		'name' => 'required|alpha',
		'profile_photo_url' => 'active_url'
	];
	
	protected static $updateRules = [
		'name' => 'alpha',
		'profile_photo_url' => 'active_url',
		'contact' => 'numeric',
		'website' => 'url'
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
	
	public function checkOwnership($entity) {
		if (!$this->isOwnerOf($entity)) {
			throw new \App\Exceptions\OwnershipException;
		}
	}
	
	public function isOwnerOf($entity) {
		return $this->id === $entity->user_id || $this->isAdmin();
	}
	
	private function isAdmin() {
		return \DB::table('admins')->where('user_id', '=', $this->id)->count() > 0;
	}
	
	public function getPhotoUrl() {
		if ($this->profile_photo_url) {
			return $this->profile_photo_url;
		}
		return 'http://orig06.deviantart.net/ea2a/f/2010/213/6/d/facebook_default_picture_by_graffadetoart.jpg';
	}

}
