<?php namespace App\Models;

class Category extends Model
{

    protected $table = 'categories';

    protected $fillable = ['title'];

    protected static $creationRules = [
        'title' => 'required'
    ];

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }

}
