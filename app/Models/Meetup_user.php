<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Meetup_user extends Model
{    
    use SoftDeletes;
    
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
