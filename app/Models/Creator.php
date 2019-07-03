<?php namespace App\Models;

class Creator extends Model
{
    public function meetups()
    {
      return $this->hasMany('App\Models\Meetup');
    } 
}
