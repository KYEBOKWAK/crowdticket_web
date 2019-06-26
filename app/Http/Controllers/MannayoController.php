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
        
        return ['state' => 'success', 'data' => $creators];
        //return $creators;
    }

    public function callYoutubeSearch(Request $request)
    {
        $searchValue = urlencode($request->searchvalue);
        $referrer = url('/');
        $api_key = env("GOOGLE_YOUTUBE_API_KEY");

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&order=viewCount&type=channel&q=".$searchValue."&maxResults=50&key=".$api_key."&referrer=".$referrer;
        $json = file_get_contents($url);
        $objs = json_decode($json);

        //$objs = json_encode($objs);
        //return "asdfddd";
        //return $objs->items;

        return ['state' => 'success', 'data' => $objs->items];
        //return count($objs);
    }
}
