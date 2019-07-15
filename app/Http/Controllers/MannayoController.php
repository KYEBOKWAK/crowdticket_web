<?php namespace App\Http\Controllers;

/*
use App\Models\Blueprint as Blueprint;
use App\Models\Category as Category;
use App\Models\Categories_ticket as Categories_ticket;
use App\Models\Categories_channel as Categories_channel;
use App\Models\Maincarousel as Maincarousel;
use App\Models\City as City;
use App\Models\Model as Model;
use App\Models\Project as Project;
use App\Models\Order as Order;
use App\Models\Poster as Poster;
use App\Models\Test as Test;
use App\Services\SmsService;
*/

use App\Models\Meetup as Meetup;
use App\Models\Meetup_user as Meetup_user;
use App\Models\Creator as Creator;
use App\Models\User as User;

use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
//use Storage as Storage;

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Mail;

class MannayoController extends Controller
{
    const SORT_TYPE_NEW = 0;
    const SORT_TYPE_POPULAR = 1;
    const SORT_TYPE_MY_MEETUP = 2;

    const INPUT_KEY_TYPE_NORMAL = 'key_type_normal';
    const INPUT_KEY_TYPE_ENTER = 'key_type_enter';

    public function goMannayo()
    {
        $meetups = [];
        return view('mannayo.welcome_mannayo', ['meetups' => $meetups]);
    }

    public function createCreator(Request $request)
    {
        $creator = null;
        
        if($request->has('creator_channel_id'))
        {
            $creator = Creator::where('channel_id', $request->creator_channel_id)->first();
        }
        else
        {
            return ['state' => 'error', 'message' => '채널 정보가 없습니다.'];
        }

        if(!$creator)
        {
            //크리에이터 정보가 없으면 정보 생성
            $creator = new Creator();
            $creator->channel_id = $request->creator_channel_id;
            $creator->title = $request->creator_title;
            $creator->thumbnail_url = $request->creator_img_url;
            $creator->social_channel = 'youtube';
            $creator->save();
            //return ['state' => 'error', 'message' => 'ERROR!! 크리에이터 정보가 없습니다.'];
        }

        return ['state' => 'success'];
    }

    public function createMeetup(Request $request)
    {
        $creator = null;
        
        if($request->has('creator_channel_id'))
        {
            $creator = Creator::where('channel_id', $request->creator_channel_id)->first();
        }

        if(!$creator)
        {
            //크리에이터 정보가 없으면 정보 생성
            $creator = new Creator();
            $creator->channel_id = $request->creator_channel_id;
            $creator->title = $request->creator_title;
            $creator->thumbnail_url = $request->creator_img_url;
            $creator->social_channel = 'youtube';
            $creator->save();
            //return ['state' => 'error', 'message' => 'ERROR!! 크리에이터 정보가 없습니다.'];
        }

        $user = User::find(\Auth::user()->id);
        if(!$user)
        {
            return ['state' => 'error', 'message' => 'ERROR!! 유저 정보가 없습니다. 로그인을 해주세요.'];
        }


        if(!$request->has('where') ||
            !$request->has('what') ||
            !$request->has('gender') ||
            !$request->has('age'))
        {
            return ['state' => 'error', 'message' => 'ERROR!! 입력값 오류!'];
        }

        $meetUp = new Meetup();
        $meetUp->user()->associate($user);
        $meetUp->creator()->associate($creator);

        $meetUp->where = $request->where;
        $meetUp->what = $request->what;
        $meetUp->anonymity = $request->anonymity;
        $meetUp->state = Meetup::MEETUP_STATE_COLLECT;
        $meetUp->save();
        $meetUp->increment('meet_count');

        if(!$request->anonymity)
        {
            //익명이 아닌데, 닉네임 정보가 다르면 업데이트 해준다.
            if($user->nick_name !== $request->nick_name)
            {
                $user->nick_name = $request->nick_name;
            }
        }

        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->save();

        $meetup_user = new Meetup_user();
        $meetup_user->user()->associate($user);
        $meetup_user->meetup()->associate($meetUp);
        $meetup_user->anonymity = $request->anonymity;
        $meetup_user->save();


        return ['state' => 'success', 'data' => ['creator_title' => $creator->title, 'contact' => $user->contact, 'email' => $user->email]];
    }

    public function findCreatorList(Request $request)
    {   
        $creators = [];
        
        if($request->title)
        {
            $creators = Creator::where('title', 'LIKE', '%'.$request->title.'%')->get();   
        }

        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
        }

        //$meetupsData = [];
        $meetupsData = $this->getMeetupList($creators, $user);

        return ['state' => 'success', 'data' => $creators, 'meetups' => $meetupsData, 'keytype' => $request->keytype];
    }

    public function callYoutubeSearch(Request $request)
    {
        $searchValue = urlencode($request->searchvalue);
        $referrer = url('/');
        $api_key = env("GOOGLE_YOUTUBE_API_KEY");

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&order=viewCount&type=channel&q=".$searchValue."&maxResults=50&key=".$api_key."&referrer=".$referrer;
        $json = file_get_contents($url);
        $objs = json_decode($json);

        return ['state' => 'success', 'data' => $objs->items];
    }

    public function getCreatorInfoInCrollingWithChannel(Request $request)
    {
        if(!strpos($request->url, 'youtube.com/channel/')){
            return ['state' => 'error', 'message' => '주소가 잘못 입력되었습니다. 다시 한번 확인 해주세요.'];
        }

        $strPos = strpos($request->url, 'channel/');
        $channel = substr($request->url, $strPos);
        $strPos = strpos($channel, '/');
        $channel = substr($channel, $strPos+1);

        //동일한 채널이 있는지 DB에서 찾아본다.
        $creators = Creator::where('channel_id', $channel)->get();
        if(count($creators))
        {
            //동일한 채널이 있다면 채널 정보를 넘겨준다.
            $meetupsData = $this->getMeetupList($creators, null);
            return ['state' => 'success', 'data' => $creators, 'meetups' => $meetupsData];
        }

        $referrer = url('/');
        $api_key = env("GOOGLE_YOUTUBE_API_KEY");

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&order=viewCount&type=channel&channelId=".$channel."&maxResults=50&key=".$api_key."&referrer=".$referrer;
        $json = file_get_contents($url);
        $objs = json_decode($json);

        return ['state' => 'success', 'data' => $objs->items];
    }

    public function getMeetupList($creators, $user)
    {
        $meetupsData = [];
        foreach($creators as $creator)
        {
            $meetups = $creator->meetups;
            foreach($meetups as $meetup)
            {
                $meetupRow['id'] = $meetup->id;
                $meetupRow['title'] = $creator->title;
                $meetupRow['thumbnail_url'] = $creator->thumbnail_url;
                $meetupRow['what'] = $meetup->what;
                $meetupRow['where'] = $meetup->where;
                $meetupRow['meet_count'] = $meetup->meet_count;
                $meetupRow['is_meetup'] = false;

                if($user)
                {
                    if($this->isMeetupUser($meetup->id, $user->id))
                    {
                        $meetupRow['is_meetup'] = true;
                    }
                }

                array_push($meetupsData, $meetupRow);
            }
        }

        return $meetupsData;
    }

    public function getMeetupCount(Request $request)
    {
        $meetupCount = Meetup_user::where('meetup_id', $request->meetup_id)->count();
        return ['state' => 'success', 'counter' => $meetupCount];
    }

    public function meetUp(Request $request)
    {
        $user = User::find(\Auth::user()->id);
        if(!$user)
        {
            return ['state' => 'error', 'message' => 'ERROR!! 유저 정보가 없습니다. 로그인을 해주세요.'];
        }

        $meetUp = Meetup::find($request->meetup_id);
        if(!$meetUp)
        {
            return ['state' => 'error', 'message' => 'ERROR!! 만나요 정보가 없습니다. 다시 시도해주세요.'];
        }

        $creator = Creator::find($meetUp->creator_id);
        if(!$creator)
        {
            return ['state' => 'error', 'message' => 'ERROR!! 크리에이터 정보가 없습니다. 다시 시도해주세요.'];
        }

        /*
        $haveMeetupUser = Meetup_user::where('meetup_id', $meetUp->id)->where('user_id', $user->id)->get();
        if(count($haveMeetupUser) > 0)
        {
            return ['state' => 'error', 'message' => 'ERROR!! 이미 만나요를 요청 했습니다!'];
        }
        */

        if($this->isMeetupUser($meetUp->id, $user->id))
        {
            return ['state' => 'error', 'message' => 'ERROR!! 이미 만나요를 요청 했습니다!'];
        }

        if(!$request->has('gender') ||
            !$request->has('age'))
        {
            return ['state' => 'error', 'message' => 'ERROR!! 입력값 오류!'];
        }

        if(!$request->anonymity)
        {
            //익명이 아닌데, 닉네임 정보가 다르면 업데이트 해준다.
            if($user->nick_name !== $request->nick_name)
            {
                $user->nick_name = $request->nick_name;
            }
        }

        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->save();

        $meetup_user = new Meetup_user();
        $meetup_user->user()->associate($user);
        $meetup_user->meetup()->associate($meetUp);
        $meetup_user->anonymity = $request->anonymity;
        $meetup_user->save();

        $meetUp->increment('meet_count');
        $meetUp->save();

        return ['state' => 'success', 'data' => ['creator_title' => $creator->title, 'contact' => $user->contact, 'email' => $user->email]];
    }

    public function getMannayoList(Request $request)
    {
        $orderBy = 'meetups.id';
        $orderType = 'desc';

        if((int)$request->sort_type === self::SORT_TYPE_POPULAR)
        {
            $orderBy = 'meetups.meet_count';
            $orderType = 'desc';
        }
        else if((int)$request->sort_type === self::SORT_TYPE_MY_MEETUP)
        {
            $orderBy = 'meetups.id';
            $orderType = 'desc';
        }
        else
        {
            //$orderType = 'asc';
            $orderBy = 'meetups.id';
            $orderType = 'desc';
        }

        $skip = $request->call_skip_counter;
        $take = $request->call_once_max_counter;

        $creators = [];
        $meetups = [];

        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
        }

        if($request->keytype === self::INPUT_KEY_TYPE_ENTER)
        {
            $creators = Creator::where('title', 'LIKE', '%'.$request->searchvalue.'%')->get();
            $creatorIds = [];
            foreach($creators as $creator)
            {
                array_push($creatorIds, $creator->id);
            }

            if((int)$request->sort_type === self::SORT_TYPE_MY_MEETUP)
            {
                if($user)
                {
                    $meetups = \DB::table('meetups')
                        ->whereIn('creator_id', $creatorIds)
                        ->where('user_id', $user->id)
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy($orderBy, $orderType)->get();
                }
            }
            else
            {
                $meetups = \DB::table('meetups')
                        ->whereIn('creator_id', $creatorIds)
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy($orderBy, $orderType)->get();
            }

            /*
            $meetups = \DB::table('meetups')
                        ->whereIn('creator_id', $creatorIds)
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
                        */
        }
        else
        {
            if((int)$request->sort_type === self::SORT_TYPE_MY_MEETUP)
            {
                if($user)
                {
                    $meetups = \DB::table('meetups')
                        ->where('user_id', $user->id)
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
                }
            }
            else
            {
                $meetups = \DB::table('meetups')
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
            }
        }

        foreach($meetups as $meetup)
        {
            $meetup->meetup_users = [];
            $meetup->is_meetup = false;
            if($user)
            {
                $meetup_user_my = Meetup_user::where('meetup_id', $meetup->id)->where('user_id', $user->id)->first();
                if($meetup_user_my)
                {
                    $userMyInfo = $meetup_user_my->user;
                    $userMyProfileURL = $userMyInfo->getPhotoUrl();

                    $meetup_user_my->user_profile_url = $userMyProfileURL;

                    array_push($meetup->meetup_users, $meetup_user_my);

                    $meetup->is_meetup = true;
                }
            }

            $meetup_users = null;

            if($user)
            {
                $meetup_users = Meetup_user::where('meetup_id', $meetup->id)->where('user_id', '<>', $user->id)->orderBy('id', 'desc')->take(3)->get();
            }
            else
            {
                $meetup_users = Meetup_user::where('meetup_id', $meetup->id)->orderBy('id', 'desc')->take(3)->get();
            }

            foreach($meetup_users as $meetup_user)
            {
                $userInfo = $meetup_user->user;
                $userProfileURL = $userInfo->getPhotoUrl();

                $meetup_user->user_profile_url = $userProfileURL;

                array_push($meetup->meetup_users, $meetup_user);

                if(count($meetup->meetup_users) >= 3)
                {
                    break;
                }
            }
        }

        return ['state' => 'success', 'meetups' => $meetups, 'creators' => $creators, 'keytype' => $request->keytype];
    }

    public function meetUpCancel(Request $request)
    {
        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
        }

        if(!$user)
        {
            return ['state' => 'error', 'message' => '로그인이 되어 있지 않습니다. 로그인 해주세요.'];
        }

        $meetUp = Meetup::find($request->meetup_id);
        if(!$meetUp)
        {
            return ['state' => 'error', 'message' => 'ERROR!! 만나요 정보가 없습니다. 다시 시도해주세요.'];
        }

        $meetupUser = Meetup_user::where('meetup_id', $request->meetup_id)->where('user_id', $user->id)->first();
        if(!$meetupUser)
        {
            //return ['state' => 'success', 'meetupUser' => $meetupUser, 'message' => '값이 있음!'];
            return ['state' => 'error', 'message' => 'ERROR!! 만나요 정보와 유저 정보가 다릅니다!'];
        }

        $meetupUser->delete();

        if($meetUp->meet_count > 0)
        {
            $meetUp->decrement('meet_count');
        }

        $meetupUserRealCounter = Meetup_user::where('meetup_id', $request->meetup_id)->count();

        if($meetupUserRealCounter === 0)
        {
            //밋업 유저가 한명도 없으면 밋업을 제거한다.
            $meetUp->delete();
        }

        
        return ['state' => 'success'];



        /*
        $creator = Creator::find($meetUp->creator_id);
        if(!$creator)
        {
            return ['state' => 'error', 'message' => 'ERROR!! 크리에이터 정보가 없습니다. 다시 시도해주세요.'];
        }
        */

        return ['state' => 'success'];
    }

    //해당 밋업을 이미 한 유저인지 체크 한다.
    public function isMeetupUser($meetup_id, $user_id)
    {
        $haveMeetupUser = Meetup_user::where('meetup_id', $meetup_id)->where('user_id', $user_id)->get();
        if(count($haveMeetupUser) > 0)
        {
            return true;
        }

        return false;
    }
}
