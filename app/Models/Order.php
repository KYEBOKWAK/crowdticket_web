<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    protected $guarded = ['id', 'project_id', 'ticket_id', 'user_id', 'confirmed', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    protected static $creationRules = [
        'contact' => 'required|numeric'
    ];

    protected static $updateRules = [
        'contact' => 'numeric'
    ];

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
