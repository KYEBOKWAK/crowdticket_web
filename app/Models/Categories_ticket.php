<?php namespace App\Models;

class Categories_ticket extends Model
{

    //protected $table = 'categories_ticket';

    protected $fillable = ['title'];

    protected static $creationRules = [
        'title' => 'required'
    ];

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }

}
