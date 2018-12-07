<?php namespace App\Models;

class Url_crawling extends Model
{
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
}
