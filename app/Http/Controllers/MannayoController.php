<?php namespace App\Http\Controllers;

use App\Models\Meetup as Meetup;
use App\Models\Meetup_user as Meetup_user;
use App\Models\Creator as Creator;
use App\Models\User as User;
use App\Models\Comment as Comment;

use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;

class MannayoController extends Controller
{
    const SORT_TYPE_NEW = 0;
    const SORT_TYPE_POPULAR = 1;
    const SORT_TYPE_MY_MEETUP = 2;

    const INPUT_KEY_TYPE_NORMAL = 'key_type_normal';
    const INPUT_KEY_TYPE_ENTER = 'key_type_enter';
    const INPUT_KEY_TYPE_MORE = 'key_type_more_button';

    const YOUTUBE_SEARCH_TYPE_API = 0;
    const YOUTUBE_SEARCH_TYPE_CROLLING = 1;

    public function goMannayo()
    {
        ///////meetup start
        $meetups = \DB::table('meetups')
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count', 'meetups.comments_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy('meetups.id', 'desc')->skip(0)->take(3)->get();
                        //->orderBy('meetups.meet_count', 'desc')->skip(0)->take(4)->get();
        
        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
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
                    $meetup_user_my->user_name = '나';

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
                //$userProfileURL = $userInfo->getPhotoUrl();
                $userProfileURL = $userInfo->getMannayoPhotoURL($meetup_user->anonymity);

                $meetup_user->user_profile_url = $userProfileURL;
                $meetup_user->user_name = $userInfo->getMannayoUserNickName($meetup_user->anonymity);

                array_push($meetup->meetup_users, $meetup_user);

                if(count($meetup->meetup_users) >= 3)
                {
                    break;
                }
            }
        }
        ///////meetup end
        return view('mannayo.welcome_mannayo', ['newmeetups' => $meetups]);
    }

    public function goMannayoCreators($channel_id)
    {
        //$creators = Meetups::where('channel_id', $creator_id)->get();

        return view('mannayo.welcome_mannayo', ['share_channel_id' => $channel_id]);
    }

    public function goMannayoMeetups($meetup_id)
    {
        $meetup = Meetup::find($meetup_id);
        if(!$meetup)
        {
            return view('mannayo.welcome_mannayo', ['share_meetup_info' => 'none']);    
        }

        $meetup->creator;

        return view('mannayo.welcome_mannayo', ['share_meetup_info' => $meetup]);
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

        if($request->has('comment'))
        {
            if($request->comment){
                $this->createComment($meetUp, $request->comment);
            }
        }


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

        $youtubeSearchType = self::YOUTUBE_SEARCH_TYPE_API;

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&order=viewCount&type=channel&q=".$searchValue."&maxResults=50&key=".$api_key."&referrer=".$referrer;
        try{
            $content = file_get_contents($url);
            $objs = json_decode($content);
            return ['state' => 'success', 'data' => $objs->items, 'search_type' => $youtubeSearchType];
        }catch(\Exception $e){
            //어떠한 오류, 리밋 카운트 초과시
            $youtubeSearchType = self::YOUTUBE_SEARCH_TYPE_CROLLING;

            include_once(__DIR__.'/../lib/simple_html_dom.php');
            
            $specialCharToSearch = strip_tags(htmlspecialchars($searchValue));
            $html = file_get_html('https://www.youtube.com/results?search_query='.$specialCharToSearch);

            //$html = file_get_html('https://www.youtube.com/channel/UC4sIlWphHSMk210xl74H3Wg');
            $channelDataTempArray = [];
            //좌측에 나오는 기본 채널들은 제외
            //음악, 스포츠, 영화, 뉴스, 실시간, 가상현실
                            
            foreach($html->find('a') as $element)
            {
                $isPassChannel = false;
                

                if($isPassChannel)
                {
                    continue;
                }

                $channel = '';
                $channelObject = '';
                if(strpos($element->href, 'channel/'))
                {
                    $strPos = strpos($element->href, 'channel/');
                    $channel = substr($element->href, $strPos);

                    $channelTitle = $element->plaintext;

                    if($channelTitle)
                    {
                        //채널 타이틀값이 있으면 플레이 리스트의 채널이다.
                        continue;
                    }

                    $channelObject['channel_id'] = $channel;
                    $channelObject['title'] = $channelTitle;
                }
                else if(strpos($element->href, 'user/'))
                {
                    $strPos = strpos($element->href, 'user/');
                    $channel = substr($element->href, $strPos);
                    
                    $channelTitle = $element->plaintext;
                    if($channelTitle)
                    {
                        //채널 타이틀값이 있으면 플레이 리스트의 채널이다.
                        continue;
                    }
                    
                    $channelObject['channel_id'] = $channel;
                    $channelObject['title'] = $channelTitle;
                }
                else
                {
                    continue;
                }

                if($channelObject['channel_id'] === '')
                {
                    continue;
                }

                $isHaveData = false;
                //겹치는 채널을 제외해준다.
                foreach($channelDataTempArray as $channelDataTemp)
                {
                    if($channelDataTemp['channel_id'] === $channelObject['channel_id'])
                    {
                        $isHaveData = true;
                        break;
                    }
                }

                if($isHaveData)
                {
                    continue;
                }
            
                array_push($channelDataTempArray, $channelObject);
            }

            return ['state' => 'success', 'data' => $channelDataTempArray, 'search_type' => $youtubeSearchType];
        }
        

        //$objs = json_decode($content);
        //return ['state' => 'success', 'data' => $objs->items, 'alldata' => $objs];
    }

    public function callYoutubeSearchCrolling(Request $request)
    {
        include_once(__DIR__.'/../lib/simple_html_dom.php');

        $channels = $request->channels;
        $channel = '';
        if($channels)
        {
            $channel = array_splice($channels, 0, 1);
        }

        if(!$channel)
        {
            return ['state' => 'error', 'message'=> '검색값이 없습니다.', 'channel' => '', 'channels' => '', 'channel_all_count' => 0];
        }
        
        $html_channel = file_get_html("https://www.youtube.com/".$channel[0]['channel_id']);

        $channelDataObject = '';

        foreach($html_channel->find('img.channel-header-profile-image') as $e)
        {
            $channelDataObjectRow['channelTitle'] = $e->title;
            $channelDataObjectRow['thumbnails']['high']['url'] = $e->src;
            //$channelDataObjectRow['channelId'] = $channel[0]['channel_id'];
            $channelDataObject['snippet'] = $channelDataObjectRow;
            break;
        }

        //foreach($html_channel->find('button.yt-uix-subscription-button') as $e)//yt-uix-subscription-button 해당 클래스로 찾는건 위험해 보임
        foreach($html_channel->find('button') as $e)
        {
            $eString = (string)$e;

            //yt-uix-subscription-button 으로 안찾았기 때문에 해당 버튼이 채널 정보가 있는 버튼인지 파악해야 한다.
            if(strpos($eString, 'data-style-type="branded"') <= 0)
            {
                continue;
            }
            
            //$cutString = 'data-channel-external-id="';
            $channelCutString = 'data-channel-external-id="';
            $channelIdPos = strpos($eString, $channelCutString);
            $cutStr = substr($eString, $channelIdPos + strlen($channelCutString));//id의 앞을 찾는다
            $lastCutStrPos = strpos($cutStr, '"');
            $cutStr = substr($cutStr, 0, $lastCutStrPos);

            $channelDataObject['snippet']['channelId'] = $cutStr;
            break;
        }       
        
        $channelDataObject['snippet']['thumbnails']['high']['url'] = str_replace("=s100", "=s800", $channelDataObject['snippet']['thumbnails']['high']['url']);        
        
        return ['state' => 'success', 'channel' => $channelDataObject, 'channels' => $channels, 'channel_all_count' => $request->channel_all_count];
        
    }

    public function getCreatorInfoInCrollingWithChannel(Request $request)
    {
        if(!strpos($request->url, 'youtube.com/channel/') && !strpos($request->url, 'youtube.com/user/')){
            return ['state' => 'error', 'message' => '주소가 잘못 입력되었습니다. 다시 한번 확인 해주세요.'];
        }

        $strPos = strpos($request->url, 'channel/');
        
        $channel_id = '';
        if($strPos <= 0)
        {
            $strPos = strpos($request->url, 'user/');
            if($strPos <= 0)
            {
                return ['state' => 'error', 'message' => '주소가 잘못 입력되었습니다. 다시 한번 확인 해주세요.'];
            }
            $channel = substr($request->url, $strPos);
        }
        else
        {
            $channel = substr($request->url, $strPos);
            $strPos = strpos($channel, '/');
            $channel_id = substr($channel, $strPos+1);
        }
        
        if($channel_id)
        {
             //동일한 채널이 있는지 DB에서 찾아본다.
            $creators = Creator::where('channel_id', $channel_id)->get();
            if(count($creators))
            {
                //동일한 채널이 있다면 채널 정보를 넘겨준다.
                $meetupsData = $this->getMeetupList($creators, null);
                return ['state' => 'success', 'data' => $creators, 'meetups' => $meetupsData];
            }
        }


        include_once(__DIR__.'/../lib/simple_html_dom.php');

        $html_channel = file_get_html("https://www.youtube.com/".$channel);

        $channelDataObject = '';

        foreach($html_channel->find('img.channel-header-profile-image') as $e)
        {
            $channelDataObjectRow['channelTitle'] = $e->title;
            $channelDataObjectRow['thumbnails']['high']['url'] = $e->src;
            //$channelDataObjectRow['channelId'] = $channel[0]['channel_id'];
            $channelDataObject['snippet'] = $channelDataObjectRow;
            break;
        }

        //foreach($html_channel->find('button.yt-uix-subscription-button') as $e)//yt-uix-subscription-button 해당 클래스로 찾는건 위험해 보임
        foreach($html_channel->find('button') as $e)
        {
            $eString = (string)$e;

            //yt-uix-subscription-button 으로 안찾았기 때문에 해당 버튼이 채널 정보가 있는 버튼인지 파악해야 한다.
            if(strpos($eString, 'data-style-type="branded"') <= 0)
            {
                continue;
            }
            
            //$cutString = 'data-channel-external-id="';
            $channelCutString = 'data-channel-external-id="';
            $channelIdPos = strpos($eString, $channelCutString);
            $cutStr = substr($eString, $channelIdPos + strlen($channelCutString));//id의 앞을 찾는다
            $lastCutStrPos = strpos($cutStr, '"');
            $cutStr = substr($cutStr, 0, $lastCutStrPos);

            $channelDataObject['snippet']['channelId'] = $cutStr;
            break;
        }       
        
        $channelDataObject['snippet']['thumbnails']['high']['url'] = str_replace("=s100", "=s800", $channelDataObject['snippet']['thumbnails']['high']['url']);        

        $channelArray = [];
        array_push($channelArray, $channelDataObject);
        
        return ['state' => 'success', 'data' => $channelArray];
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
                $meetupRow['comments_count'] = $meetup->comments_count;
                $meetupRow['is_meetup'] = false;
                $meetupRow['channel_id'] = $creator->channel_id;

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

        if($request->has('comment'))
        {
            if($request->comment){
                $this->createComment($meetUp, $request->comment);
            }
        }

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
            if(count($creators) === 0)
            {
                //검색값이 없으면, creatorid 로도 찾아본다.
                $creators = Creator::where('channel_id', $request->searchvalue)->get();
            }

            $creatorIds = [];
            foreach($creators as $creator)
            {
                array_push($creatorIds, $creator->id);
            }

            if((int)$request->sort_type === self::SORT_TYPE_MY_MEETUP)
            {
                if($user)
                {

                    $rowMeetupUsers = Meetup_user::where('user_id', $user->id)->get();
                    $meetupsIds = [];
                    foreach($rowMeetupUsers as $rowMeetupUser)
                    {
                        array_push($meetupsIds, $rowMeetupUser->meetup_id);
                    }

                    $meetups = \DB::table('meetups')
                        ->whereIn('creator_id', $creatorIds)
                        ->whereIn('meetups.id', $meetupsIds)
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count', 'meetups.comments_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
                }
            }
            else
            {
                $meetups = \DB::table('meetups')
                        ->whereIn('creator_id', $creatorIds)
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count', 'meetups.comments_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy($orderBy, $orderType)->get();
            }
        }
        else
        {
            if((int)$request->sort_type === self::SORT_TYPE_MY_MEETUP)
            {
                if($user)
                {
                    $rowMeetupUsers = Meetup_user::where('user_id', $user->id)->get();
                    $meetupsIds = [];
                    foreach($rowMeetupUsers as $rowMeetupUser)
                    {
                        array_push($meetupsIds, $rowMeetupUser->meetup_id);
                    }

                    $meetups = \DB::table('meetups')
                        ->whereIn('meetups.id', $meetupsIds)
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count', 'meetups.comments_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
                        
                }
            }
            else
            {
                $meetups = \DB::table('meetups')
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count', 'meetups.comments_count',
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
                    //$userMyProfileURL = $userMyInfo->getMannayoPhotoURL($meetup_user_my->anonymity);

                    $meetup_user_my->user_profile_url = $userMyProfileURL;
                    $meetup_user_my->user_name = '나';
                    //$meetup_user_my->user_name = $userMyInfo->getMannayoUserNickName($meetup_user_my->anonymity);

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
                //$userProfileURL = $userInfo->getPhotoUrl();
                $userProfileURL = $userInfo->getMannayoPhotoURL($meetup_user->anonymity);

                $meetup_user->user_profile_url = $userProfileURL;
                $meetup_user->user_name = $userInfo->getMannayoUserNickName($meetup_user->anonymity);

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

    public function setUserInfo(Request $request)
    {
        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
        }

        if(!$user)
        {
            return ['state' => 'error', 'message' => ''];
        }

        $user->contact = $request->contact;
        $user->save();
    }

    public function getUserInfo(Request $request)
    {
        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
        }

        if(!$user)
        {
            return ['state' => 'error', 'message' => ''];
        }

        $user_nickname = $user->getUserNickName();
        $user_age = $user->getUserAge();
        $user_gender = $user->getUserGender();

        return ['state' => 'success', 'user_nickname' => $user_nickname, 'user_age' => $user_age, 'user_gender' => $user_gender];
    }

    public function getMannayoUsers(Request $request)
    {
        $user_me = null;
        if(\Auth::check() && \Auth::user())
        {
            $user_me = \Auth::user();
        }

        $skip = $request->call_skip_counter;
        $take = $request->call_once_max_counter;
        
        $meetup_users = Meetup_user::where('meetup_id', $request->meetup_id)->skip($skip)->take($take)->get();
        foreach($meetup_users as $meetup_user)
        {
            $user = $meetup_user->user;

            if($user_me && $user_me->id === $user->id)
            {
                $meetup_user->user->nick_name = '나';
            }
            else
            {
                $meetup_user->user->nick_name = $user->getMannayoUserNickName($meetup_user->anonymity);
                $meetup_user->user->profile_photo_url = $user->getMannayoPhotoURL($meetup_user->anonymity);
            }
        }

        return ['state' => 'success', 'meetup_users' => $meetup_users, 'meetup_id' => $request->meetup_id];
    }

    public function getComments(Request $request)
    {
        $user_me = null;
        if(\Auth::check() && \Auth::user())
        {
            $user_me = \Auth::user();
        }

        $skip = $request->call_skip_counter;
        $take = $request->call_once_max_counter;

        //$targetMeetupId = $request->target_meetup_id;//현재 불러온 마지막 밋업 id 기준으로 가져온다.
        //$meetup_comments = Meetup::comments()->skip($skip)->take($take)->get();
        $meetup = Meetup::find($request->meetup_id);
        if(!$meetup)
        {
            return ['state' => 'error', 'message' => '만나요 정보가 없습니다.'];
        }
        //$request->last_comment_id = 465;

        $meetup_comments = [];
        if((int)$request->last_comment_id === 0)
        {
            $meetup_comments = $meetup->comments()->with('user', 'comments', 'comments.user')->skip($skip)->take($take)->get();
        }
        else
        {
            $meetup_comments = $meetup->comments()->where('id', '<', $request->last_comment_id)->with('user', 'comments', 'comments.user')->skip($skip)->take($take)->get();
        }

        foreach($meetup_comments as $meetup_comment)
        {
            $user = $meetup_comment->user;

            if($user_me && $user_me->id === $user->id)
            {
                $meetup_comment->user->nick_name = '나';
                //$meetup_comment->user->profile_photo_url = $user->getPhotoUrl();
            }
            else
            {
                $meetup_comment->user->nick_name = $user->getMannayoUserNickName($meetup_comment->anonymity);
                $meetup_comment->user->profile_photo_url = $user->getMannayoPhotoURL($meetup_comment->anonymity);
            }
        }

        return ['state' => 'success', 'meetup_comments' => $meetup_comments, 'comments_count' => $meetup->comments_count, 'meetup_id' => $request->meetup_id];
    }

    public function createComment($meetup, $contents)
    {
        $comment = new Comment();
        $comment->contents = $contents;
        $comment->user()->associate(\Auth::user());
        $meetup->comments()->save($comment);
        $comment->save();

        $meetup->increment('comments_count');
    }
}
