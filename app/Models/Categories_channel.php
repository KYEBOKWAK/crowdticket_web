<?php namespace App\Models;

class Categories_channel extends Model
{

    //protected $fillable = ['title'];

    protected static $creationRules = [
    //    'title' => 'required'
    ];

    public function user()
    {
      return  $this->hasMany('App\Models\User');
    }
    /*
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
    */

}
