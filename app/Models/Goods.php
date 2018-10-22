<?php namespace App\Models;

class Goods extends Model
{

    protected $table = 'goods';

    protected $fillable = ['price','img_cache', 'title', 'content', 'img_url'];

    protected static $typeRules = [
        'price' => 'integer|min:0',
        'img_cache' => 'integer|min:0',
        'title' => 'string|min:0',
        'content' => 'string|min:0',
        'img_url' => 'string|min:0'
        //'real_ticket_count' => 'integer|min:0',
      //  'reward' => 'string|min:1',
      //  'question' => 'string|max:100',
      //  'audiences_limit' => 'integer|min:0',
      //  'delivery_date' => 'date_format:Y-m-d H:i:s',
      //  'shipping_charge' => 'integer',
      //  'category' => 'string|min:0',
      //  'show_date' => 'date_format:Y-m-d H:i:s'
    ];

    protected $casts = [
        'price' => 'integer',
        'img_cache' => 'integer'
        //'audiences_count' => 'integer',
        //'real_ticket_count' => 'integer',
    ];

    /*
    protected static $creationRules = [
        'title' => 'required'
    ];
    */

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

}
