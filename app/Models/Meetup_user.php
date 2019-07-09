<?php namespace App\Models;

class Meetup_user extends Model
{    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function meetup()
    {
        return $this->belongsTo('App\Models\Meetup'); 
    }
/*
    public function creator()
    {
        return $this->belongsTo('App\Models\Creator');
    }
    */
}
