<?php namespace App\Models;

class Magazine extends Model
{
    protected $fillable = ['title', 'subtitle', 'title_img_url', 'thumb_img_url', 'story', 'updated_at', 'is_open'];

    protected static $typeRules = [
        'title_img_url' => 'url',
    ];

    public function update(array $attributes = array())
    {
      parent::update($attributes);
    }

    public function getThumbImgURL()
    {
      //return $this->title_img_url;
      return $this->thumb_img_url;
    }

    public function getMagazineLinkURL()
    {

      return url().'/magazine'.'/'.$this->id;
      //return __DIR__.'/../../';
      //return 'https://crowdticket.kr';
    }

}
