<?php namespace App\Models;

class Poster extends Model
{
    //protected $fillable = ['type', 'img_cache', 'img_url'];
    protected $fillable = ['poster_img_cache', 'title_1_img_cache', 'title_2_img_cache', 'title_3_img_cache', 'title_4_img_cache'];

    protected static $typeRules = [
        'poster_img_cache' => 'integer|min:0',
        'title_1_img_cache' => 'integer|min:0',
        'title_2_img_cache' => 'integer|min:0',
        'title_3_img_cache' => 'integer|min:0',
        'title_4_img_cache' => 'integer|min:0'

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
        'poster_img_cache' => 'integer',
        'title_1_img_cache' => 'integer',
        'title_2_img_cache' => 'integer',
        'title_3_img_cache' => 'integer',
        'title_4_img_cache' => 'integer'
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
