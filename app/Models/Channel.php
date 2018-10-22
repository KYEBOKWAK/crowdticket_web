<?php namespace App\Models;

class Channel extends Model
{
    protected $fillable = ['url'];

    protected static $typeRules = [
        'url' => 'string|min:0',
    ];

    /*
    protected static $creationRules = [
        'title' => 'required'
    ];
    */

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function categories_channel()
    {
      return $this->belongsTo('App\Models\Categories_channel');
    }
/*
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
*/
}
