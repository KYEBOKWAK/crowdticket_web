<?php namespace App\Models;

class Main_thumbnail extends Model
{
    const THUMBNAIL_TYPE_RECOMMEND = 1; //크라우드 티켓 추천 썸네일
    const THUMBNAIL_TYPE_CROLLING = 2; //크라우드 티켓 크롤링 썸네일
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
}
