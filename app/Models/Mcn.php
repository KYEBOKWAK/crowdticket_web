<?php namespace App\Models;

class Mcn extends Model
{
  public function user()
  {
      return $this->belongsTo('App\Models\User');
  }
}
