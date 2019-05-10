<?php namespace App\Models;

class Alive_user extends Model
{
    protected $fillable = ['id', 'ga_user', 'cr_user', 'userip', 'ping_at', 'created_at', 'updated_at'];

    public $incrementing = false;
}
