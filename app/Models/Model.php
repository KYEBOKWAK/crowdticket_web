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
    const S3_MAGAZINE_DIRECTORY = "magazine/";
    const S3_MAGAZINE_STORY_DIRECTORY = "magazine/story/";
    const S3_CONFIG_DIRECTORY = "config/";
    const S3_LOG_DIRECTORY = "logs/";
    const S3_LOG_PROCESS_DIRECTORY = "logs_process/";

    const LOG_TYPE_PICKER_ORDER_CANCEL = "order_picker_cancel";
    const LOG_TYPE_SEND_PICK_SUCCESS_EMAIL = "send_pick_success_email";
    const LOG_TYPE_SEND_PICK_FAIL_EMAIL = "send_pick_fail_email";
    const LOG_TYPE_SEND_PICK_SUCCESS_SMS = "send_pick_success_sms";

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
