<?php namespace App\Models;

class Supporter extends Model
{

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
