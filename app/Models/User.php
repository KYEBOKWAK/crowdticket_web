<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    const LIKE_KEY_MAGAGINE = "magazine";

    protected $fillable = ['email', 'name', 'nick_name', 'password', 'profile_photo_url', 'contact', 'introduce', 'website', 'bank', 'account', 'account_holder', 'like_meta', 'age', 'gender', 'country_code', 'is_certification', 'advertising', 'advertising_at'];

    protected $hidden = ['password', 'remember_token', 'facebook_id', 'google_id'];

    protected static $creationRules = [
        'email' => 'required|email|unique:users',
        'name' => 'required|string',
        'nick_name' => 'string',
        'profile_photo_url' => 'url',
        'age' => 'string',
        'gender' => 'string',
    ];

    protected static $updateRules = [
        'name' => 'string',
        'nick_name' => 'string',
        'profile_photo_url' => 'url',
        'contact' => 'numeric',
        'introduce' => 'string',
        'website' => 'url',
        'bank' => 'string',
        'account' => 'numeric',
        'account_holder' => 'string',
        'age' => 'string',
        'gender' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function channels()
    {
      return $this->hasMany('App\Models\Channel');
    }

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }

    public function stores()
    {
        return $this->hasMany('App\Models\Store');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function checkOwnership($entity)
    {
        if (!$this->isOwnerOf($entity)) {
          throw new \App\Exceptions\OwnershipException();
        }
    }

    public function isOwnerOf($entity)
    {
        return $this->id === $entity->user_id || $this->isAdmin() || $this->isSuperUser($entity);
    }

    public function isSuperUser($entity)
    {
      if(isset($entity->super_user_id))
      {
        return $this->id === $entity->super_user_id;
      }
      else
      {
        return false;
      }
    }

    public function isAdmin()
    {
        return \DB::table('admins')->where('user_id', '=', $this->id)->count() > 0;
    }

    public function getPhotoUrl()
    {
        if ($this->profile_photo_url) {
            return $this->profile_photo_url;
        }
        //return asset('/img/app/default-user-image.png');
        return asset('/img/icons/ic-default-profile-512.png');
    }

    public function getMannayoPhotoURL($isAnonymity)
    {
        if((int)$isAnonymity === 1)
        {
            return asset('/img/icons/ic-default-profile-512.png');
        }

        if ($this->profile_photo_url) {
            return $this->profile_photo_url;
        }
        //return asset('/img/app/default-user-image.png');
        return asset('/img/icons/ic-default-profile-512.png');
    }

    public function getUserNickName()
    {
      if($this->nick_name)
      {
        return $this->nick_name;
      }

      return $this->name;
    }

    public function getMannayoUserNickName($isAnonymity)
    {
        if((int)$isAnonymity === 1)
        {
            return '익명';
        }

        if($this->nick_name)
        {
            return $this->nick_name;
        }

        return $this->name;
    }

    public function getUserAge()
    {
        return $this->age;
    }

    public function getUserGender()
    {
        return $this->gender;
    }

/*
    public function setLikeMeta($likekey, $id)
    {
      $like_meta = json_decode($this->like_meta);

      if($likekey == self::LIKE_KEY_MAGAGINE)
      {

      }

      return count($like_meta);
    }
    */

}
