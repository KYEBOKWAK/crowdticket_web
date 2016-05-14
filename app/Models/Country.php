<?php namespace App\Models;

class Country extends Model
{

    protected $table = 'countries';

    protected $fillable = ['code'];

    protected static $creationRules = [
        'code' => 'required|alpha'
    ];

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }

}
