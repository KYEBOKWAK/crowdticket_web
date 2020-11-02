<?php namespace App\Models;

class Store extends Model
{
  public function user()
  {
      return $this->belongsTo('App\Models\User');
  }
}
