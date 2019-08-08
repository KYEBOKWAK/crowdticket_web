<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Meetup extends Model
{
    use SoftDeletes;
    
    const MEETUP_STATE_NONE = 0;
    const MEETUP_STATE_COLLECT = 1;
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\Creator');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->orderBy('created_at', 'desc');
        //return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
