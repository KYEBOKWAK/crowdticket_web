<?php namespace App\Models;

class Orders_goods extends Model
{
    protected $table = 'Orders_goods';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function goods()
    {
        return $this->belongsTo('App\Models\Goods');
    }
}
