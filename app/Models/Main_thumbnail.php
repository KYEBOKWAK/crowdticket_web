<?php namespace App\Models;

class Main_thumbnail extends Model
{
    const THUMBNAIL_TYPE_RECOMMEND = 1; //크라우드 티켓 추천 썸네일
    const THUMBNAIL_TYPE_CROLLING = 2; //크라우드 티켓 크롤링 썸네일
    const THUMBNAIL_TYPE_MAGAZINE = 3; //크라우드 티켓 매거진 썸네일
    const THUMBNAIL_TYPE_RECOMMENT_SANDBOX_EVENT = 4; //추천 썸네일, 이벤트성(예:샌드박스 추석 이벤트) 추천썸네일 위에 있다.

    const THUMBNAIL_TYPE_STORE_ITEM = 5;
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }

    public function magazines()
    {
      return $this->hasMany('App\Models\Magazine');
    }
}
