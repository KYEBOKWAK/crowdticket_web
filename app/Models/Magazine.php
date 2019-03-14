<?php namespace App\Models;

class Magazine extends Model
{
    protected $fillable = ['title', 'subtitle', 'title_img_url', 'story'];

    protected static $typeRules = [
        'title_img_url' => 'url',
    ];

    public function update(array $attributes = array())
    {
      parent::update($attributes);
    }

    public function getThumbImgURL()
    {
      return $this->title_img_url;
    }

    public function getMagazineLinkURL()
    {

      return url().'/magazine'.'/'.$this->id;
      //return __DIR__.'/../../';
      //return 'https://crowdticket.kr';
    }

}
