<?php namespace App\Models;

class Meetup extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\Creator');
    }
}
