<?php namespace App\Models;

use App\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Config;
use Validator;

abstract class Model extends BaseModel
{

    const S3_BASE_URL = "https://s3-ap-northeast-1.amazonaws.com/crowdticket0/";
    const S3_POSTER_DIRECTORY = "posters/";
    const S3_STORY_DIRECTORY = "stories/";
    const S3_NEWS_DIRECTORY = "news/";
    const S3_USER_DIRECTORY = "users/";
    const S3_GOODS_DIRECTORY = "goods/";

    protected static $typeRules = array();

    protected static $creationRules = array();

    protected static $updateRules = array();

    public static function getS3Directory($dir) {

        if(env('APP_TYPE'))
        {
          return env('APP_TYPE'). '/' . $dir;
        }
        else
        {
          return 'newtest/' . $dir;
        }

        //예전코드
        if (Config::get('app.debug')) {
            return 'newtest/' . $dir;
        }
        //return $dir;

        //기존에 debug 모드에서 풀지 않아서 해당 폴더 사용
        return 'test/' . $dir;
    }

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        if (!empty($attributes)) {
            $this->validate($attributes, static::$typeRules);
            $this->validate($attributes, static::$creationRules);
        }
    }

    public function update(array $attributes = array())
    {
        $this->validate($attributes, static::$typeRules);
        $this->validate($attributes, static::$updateRules);
        $this->fill($attributes);
    }

    private function validate(array $attributes = array(), $rules)
    {
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }
    }

    public function required($attr)
    {
        if (!isset($this->$attr)) {
            $this->load($attr);
        }
    }

    public function requiredGet($attr)
    {
        $this->required($attr);
        return $this->$attr;
    }

}
