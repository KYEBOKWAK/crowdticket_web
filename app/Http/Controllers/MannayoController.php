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

use App\Models\Creator as Creator;

use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
//use Storage as Storage;

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Mail;

class MannayoController extends Controller
{
    public function goMannayo()
    {
        return view('mannayo.welcome_mannayo');
    }

    public function findCreatorList(Request $request)
    {   
        $creators = [];
        
        if($request->title)
        {
            $creators = Creator::where('title', 'LIKE', '%'.$request->title.'%')->get();   
        }

        //$meetupsData = [];
        $meetupsData = $this->getMeetupList($creators);

        return ['state' => 'success', 'data' => $creators, 'meetups' => $meetupsData];
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
            $meetupsData = $this->getMeetupList($creators);
            return ['state' => 'success', 'data' => $creators, 'meetups' => $meetupsData];
        }

        $referrer = url('/');
        $api_key = env("GOOGLE_YOUTUBE_API_KEY");

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&order=viewCount&type=channel&channelId=".$channel."&maxResults=50&key=".$api_key."&referrer=".$referrer;
        $json = file_get_contents($url);
        $objs = json_decode($json);

        return ['state' => 'success', 'data' => $objs->items];
    }

    public function getMeetupList($creators)
    {
        $meetupsData = [];
        foreach($creators as $creator)
        {
            $meetups = $creator->meetups;
            foreach($meetups as $meetup)
            {
                $meetupRow['title'] = $creator->title;
                $meetupRow['thumbnail_url'] = $creator->thumbnail_url;
                $meetupRow['what'] = $meetup->what;
                $meetupRow['where'] = $meetup->where;
                array_push($meetupsData, $meetupRow);
            }
        }

        return $meetupsData;
    }
}
