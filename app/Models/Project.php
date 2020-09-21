<?php namespace App\Models;

class Project extends Model
{
    const DATA_CALL_ONETIME_MAX_COUNTER = 10; //데이터 요청시 한번에 보낼 데이터양

    const STATE_READY = 1;
    const STATE_READY_AFTER_FUNDING = 2;
    const STATE_UNDER_INVESTIGATION = 3;
    const STATE_APPROVED = 4;

    const EVENT_TYPE_DEFAULT = 0; //기본 타입
    const EVENT_TYPE_INVITATION_EVENT = 1;   //이벤트 타입(초대권)
    const EVENT_TYPE_CRAWLING = 2;  //크롤링된 이벤트
    const EVENT_TYPE_PICK_EVENT = 3;  //pick 이벤트
    const EVENT_TYPE_CUSTOM = 4;  //커스텀하게 특정 alias 프로젝트로 구분해서 사용한다.
    const EVENT_TYPE_GROUP_BUY = 5;

    const EVENT_TYPE_SUB_SANDBOX_PICK = 1;  //샌드박스 전용 pick 이벤트
    //2번은 급하게 만들었는데, 어쩔 수 없이 냅둬야함. 1,3번처럼 활용하는게 맞음.
    const EVENT_TYPE_SUB_SECRET_PROJECT = 2;//URL 통해서만 들어올 수 있는 프로젝트. 더보기에 공개 안됨
    const EVENT_TYPE_SUB_Woongjin_play_city = 3;

    const PICK_STATE_NONE = 0;  //pick 상태
    const PICK_STATE_PICKED = 1;  //pick 완료 상태

    const IS_PAY_DEFAULT = 0; //기본값
    const IS_PAY_ACCOUNT = 1; //무통장 계좌이체 추가 옵션(루디 이슈)

    protected static $fillableByState = [
        Project::STATE_READY => [
            'type', 'project_type', 'project_target', 'isDelivery', 'isPlace', 'title', 'alias', 'poster_renew_url', 'poster_sub_renew_url', 'description', 'video_url', 'story', 'ticket_notice',
            'detailed_address', 'concert_hall', 'temporary_date', 'hash_tag1', 'hash_tag2', 'pledged_amount', 'audiences_limit',
            'sale_start_at', 'funding_closing_at', 'picking_closing_at', 'event_type', 'event_type_sub', 'pick_state', 'is_pay_account'
        ],

        Project::STATE_READY_AFTER_FUNDING => [
            'description', 'video_url', 'story',
            'detailed_address', 'concert_hall', 'audiences_limit'
        ],

        Project::STATE_UNDER_INVESTIGATION => [
            // nothing can update
        ],

        Project::STATE_APPROVED => [
          'description', 'video_url', 'story', 'ticket_notice', 'event_type', 'event_type_sub', 'pick_state', 'is_pay_account'
        ]
    ];

    protected static $typeRules = [
        'type'  => 'in:funding,sale',
        'project_type' => 'in:artist,creator,culture',
        'project_target' => 'in:money,people',
        'isPlace' => 'string',
        'title' => 'string|min:1|max:30',
        'alias' => 'regex:/^([a-zA-Z]{1}[a-zA-Z0-9-_]{3,63})?$/',
        'poster_url' => 'url',
        'poster_renew_url' => 'url',
        'poster_sub_renew_url' => 'url',
        'description' => 'string',
        'video_url' => 'url',
        'detailed_address' => 'string',
        'concert_hall' => 'string',
        'temporary_date' => 'string',
        'hash_tag1' => 'string',
        'hash_tag2' => 'string',
        'pledged_amount' => 'integer|min:0',
        'audiences_limit' => 'integer|min:0',
        'event_type' => 'integer|min:0',
        'event_type_sub' => 'integer|min:0',
        'is_pay_account' => 'integer|min:0',
        'funding_closing_at' => 'date_format:Y-m-d H:i:s',
        'performance_opening_at' => 'date_format:Y-m-d',
        'pick_state' => 'integer|min:0'
    ];

    public function update(array $attributes = array())
    {
      //return static::$fillableByState[$this->state];
        $this->fillable = static::$fillableByState[$this->state];
        parent::update($attributes);
    }

    public function submit()
    {
        if ((int)$this->state === Project::STATE_READY ||
            (int)$this->state === Project::STATE_READY_AFTER_FUNDING
        ) {
            $this->setAttribute('state', Project::STATE_UNDER_INVESTIGATION);
            $this->save();
        }
    }

    public function approve()
    {
        $this->setAttribute('state', Project::STATE_APPROVED);
        $this->save();
    }

    public function reject()
    {
      /*
        if ($this->type === 'funding') {
            $this->setAttribute('state', Project::STATE_READY);
        } else if ($this->type === 'sale') {
            if ($this->funding_closing_at) {
                $this->setAttribute('state', Project::STATE_READY_AFTER_FUNDING);
            } else {
                $this->setAttribute('state', Project::STATE_READY);
            }
        }
        */

        $this->setAttribute('state', Project::STATE_READY);

        $this->save();
    }

    public function getProjectID()
    {
      return intval($this->id);
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function tickets()
    {
      return $this->hasMany('App\Models\Ticket')->orderBy('show_date', 'asc');
      /*
        if ($this->type === 'funding') {
            return $this->hasMany('App\Models\Ticket')->orderBy('price', 'asc');
        } else {
            return $this->hasMany('App\Models\Ticket')->orderBy('delivery_date', 'asc');
        }
        */
    }

    //반드시 티켓 순서가 공연 시작순에서 젤 빠른순으로 정렬되어야 한다.
    public function ticketsMustOrderShowDateASC()
    {
      return $this->hasMany('App\Models\Ticket')->orderBy('show_date', 'asc');
    }

    public function ticketsOrderShowDate($show_date)
    {
      return $this->hasMany('App\Models\Ticket')->where('show_date', '=', $show_date)->orderBy('show_date', 'asc');
    }

    public function discounts()
    {
      //return $this->hasMany('App\Models\Discount')->orderBy('show_date', 'asc');
      return $this->hasMany('App\Models\Discount');
    }

    public function goods()
    {
      return $this->hasMany('App\Models\Goods');
    }

    public function posters()
    {
      return $this->hasMany('App\Models\Poster');
      //return $this->belongsTo('App\Models\Poster');
    }

    public function questions()
    {
      return $this->hasMany('App\Models\Question')->orderBy('order_number', 'asc');
    }

    public function orders()
    {
        //return $this->hasMany('App\Models\Order');
        return $this->hasMany('App\Models\Order')->where('state', '<=', Order::ORDER_STATE_PAY_END);
    }

    public function getOrderWithOutCancel()
    {
      return $this->hasMany('App\Models\Order')->where('state', '<', Order::ORDER_STATE_CANCEL_START);
    }

    public function getOrdersWithPickCancel()
    {
      //return $this->hasMany('App\Models\Order')->where('state', '<=', Order::ORDER_STATE_PAY_END)->orWhere('state', '=', Order::ORDER_STATE_PROJECT_PICK_CANCEL)->get();
      return $this->hasMany('App\Models\Order')->where('state', '<=', Order::ORDER_STATE_PAY_END)->orWhere('state', '=', Order::ORDER_STATE_PROJECT_PICK_CANCEL);
    }

    public function getOrdersWithoutPick()
    {
      return $this->hasMany('App\Models\Order')->where('state', '<=', Order::ORDER_STATE_PAY_END)->where('is_pick', '=', '')->get();
      //return $this->hasMany('App\Models\Order')->where('state', '<=', Order::ORDER_STATE_PAY_END)->where('is_pick', '=', '')->orWhere('is_pick', '=', 'Y')->get();
    }

    public function getOrdersOnlyPick()
    {
      //return $this->hasMany('App\Models\Order')->where('state', '<=', Order::ORDER_STATE_PAY_END)->where('is_pick', '!=', '')->get();
      return $this->hasMany('App\Models\Order')->where('state', '<=', Order::ORDER_STATE_PAY_END)->where('is_pick', '=', 'PICK');
    }

    public function getOrdersWithPickY()
    {
      return $this->hasMany('App\Models\Order')->where('state', '<=', Order::ORDER_STATE_PAY_END)->where('is_pick', '=', 'Y')->get();
      //return $this->getOrdersWithoutPick();
    }

    public function ordersAll()
    {
      return $this->hasMany('App\Models\Order');
    }

    public function ordersWithoutError()
    {
      return $this->hasMany('App\Models\Order')->where('state', '<', Order::ORDER_STATE_ERROR_START);
    }

    public function ordersWithoutUserCancel()
    {
      return $this->hasMany('App\Models\Order')->where('state', '<', Order::ORDER_STATE_CANCEL);
    }

    public function supporters()
    {
        return $this->hasMany('App\Models\Supporter')->orderBy('created_at', 'desc');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->orderBy('created_at', 'desc');
    }

    public function news()
    {
        return $this->hasMany('App\Models\News')->orderBy('created_at', 'desc');
    }

    public function url_crawlings()
    {
      return $this->hasMany('App\Models\Url_crawling')->first();
    }

    public function isFinished()
    {
        if ($this->funding_closing_at) {
            return strtotime($this->funding_closing_at) - time() < 0;
        }
        return true;
    }

    //종료후 picking도 종료 되었다.
    public function isFinishedAndPickingFinished()
    {
      if(!$this->isFinished())
      {
        return false;
      }

      if(!$this->picking_closing_at)
      {
        return false;
      }

      $nowTimeUnix = time();

      $pickClosingTimeUnix = strtotime($this->picking_closing_at);

      if($nowTimeUnix > $pickClosingTimeUnix)
      {
        return true;
      }

      return false;
    }

    public function canOrder()
    {
        return !$this->isFinished() && (int)$this->state === self::STATE_APPROVED;
    }

    public function dayUntilFundingClosed()
    {
        $diff = max(strtotime($this->funding_closing_at) - time(), 0);
        $secondsInDay = 60 * 60 * 24;
        return floor($diff / $secondsInDay);
    }

    public function getPosterUrl()
    {
        if($this->poster_url){
            return $this->poster_url;
        }

        if($this->poster_renew_url){
          return $this->poster_renew_url;
        }

        return asset('img/app/img_no_poster.png');
    }

    public function getSubPosterURL()
    {
      if($this->poster_sub_renew_url){
        return $this->poster_sub_renew_url;
      }

      return asset('img/app/img_no_poster.png');
    }

    public function getDefaultImgUrl()
    {
        return asset('img/app/img_no_poster.png');
    }

    public function getProgress()
    {
      //티켓팅과 펀딩으로 구분.
      if($this->type == 'sale')
      {
        return "";
      }


      //펀딩일때
      if ($this->pledged_amount > 0)
      {
        if($this->isOldProject())
        {
          return (int)(($this->funded_amount / $this->pledged_amount) * 100);
        }

        return (int)(($this->getTotalFundingAmount() / $this->pledged_amount) * 100);
      }

      return 0;
    }

    public function getTicketDateFormatted()
    {
      $open = new \DateTime('now');
      $close = new \DateTime('now');

      if($this->funding_closing_at)
      {
        $open = new \DateTime($this->funding_closing_at);
        $close = new \DateTime($this->funding_closing_at);  
      }

      if ($this->performance_opening_at) {
          $open = new \DateTime($this->performance_opening_at);
      }
      if ($this->performance_closing_at) {
          $close = new \DateTime($this->performance_closing_at);
      }

      $openDay = $open->format('Y. m. d');
      $closeDay = $close->format('Y. m. d');
      if ($openDay === $closeDay) {
          return $openDay;
      }

      $startY = $open->format('Y');
      $endY = $close->format('Y');

      $startM = $open->format('m');
      $endM = $close->format('m');

      if($startY === $endY &&
          $startM === $endM)
      {
        //년 월이 같으면 day 만 표시한다.
        $close = $close->format('d');
      }
      else if($startY === $endY)
      {
        $close = $close->format('m. d');
      }

      return $openDay . ' - ' . $close;
    }

    public function getTicketDateFormattedSlash()
    {
      if($this->isPlace == "FALSE" || $this->isEventTypeCrawlingEvent())
      {
        return $this->temporary_date;
      }

      $ticketCount = count($this->tickets);

      if($ticketCount === 0)
      {
        return "";
      }

      $concertStartDayRow = $this->tickets[0]->show_date;
      $concertEndDayRow = $this->tickets[$ticketCount - 1]->show_date;

      $concertStartDayRow = new \DateTime($concertStartDayRow);
      $concertEndDayRow = new \DateTime($concertEndDayRow);

      //$concertStartDay = $concertStartDay->format('Y. m. d');
      $startY = $concertStartDayRow->format('Y');
      $endY = $concertEndDayRow->format('Y');

      $startM = $concertStartDayRow->format('m');
      $endM = $concertEndDayRow->format('m');

      $concertStartDay = $concertStartDayRow->format('Y/m/d');
      $concertEndDay = $concertEndDayRow->format('Y/m/d');

      if($concertStartDay === $concertEndDay)
      {
        //return $concertEndDay;
        return $concertEndDayRow->format('m/d');
      }

      if($startY === $endY &&
          $startM === $endM)
      {
        //년 월이 같으면 day 만 표시한다.
        $concertStartDay = $concertStartDayRow->format('m/d');
        $concertEndDay = $concertEndDayRow->format('d');
      }
      else if($startY === $endY)
      {
        $concertStartDay = $concertStartDayRow->format('m/d');
        $concertEndDay = $concertEndDayRow->format('m/d');
      }
      else
      {
        $concertStartDay = $concertStartDayRow->format('m/d');
      }

      return $concertStartDay . ' - ' . $concertEndDay;
    }

    //리뉴얼 시간 가져오는 함수
    public function getConcertDateFormatted()
    {
      if($this->isOldProject())
      {
        //우선 포스터 URL로 기존 프로젝트인지 판단한다.
        return $this->getTicketDateFormatted();
      }

      if($this->isPlace == "FALSE" || $this->isEventTypeCrawlingEvent())
      {
        return $this->temporary_date;
      }

      $ticketCount = count($this->tickets);

      if($ticketCount == 0)
      {
        return "";
      }

      $concertStartDayRow = $this->tickets[0]->show_date;
      $concertEndDayRow = $this->tickets[$ticketCount - 1]->show_date;

      $concertStartDayRow = new \DateTime($concertStartDayRow);
      $concertEndDayRow = new \DateTime($concertEndDayRow);

      //$concertStartDay = $concertStartDay->format('Y. m. d');
      $startY = $concertStartDayRow->format('Y');
      $endY = $concertEndDayRow->format('Y');

      $startM = $concertStartDayRow->format('m');
      $endM = $concertEndDayRow->format('m');

      $concertStartDay = $concertStartDayRow->format('Y. m. d');
      $concertEndDay = $concertEndDayRow->format('Y. m. d');

      if($concertStartDay === $concertEndDay)
      {
        return $concertEndDay;
      }

      if($startY === $endY &&
          $startM === $endM)
      {
        //년 월이 같으면 day 만 표시한다.
        $concertEndDay = $concertEndDayRow->format('d');
      }
      else if($startY === $endY)
      {
        $concertEndDay = $concertEndDayRow->format('m. d');
      }

      return $concertStartDay . ' - ' . $concertEndDay;
    }

    public function getMainExplain()
    {

      $pledgedTarget = "원";
      //인원, 금액 결정
      if($this->project_target == "people")
      {
        $pledgedTarget = "명";
      }

      $pledgedTarget = number_format($this->pledged_amount) . $pledgedTarget;
      if($this->type == "sale")
      {
        //즉시 결제면 무조건 명수로 나온다.
        $pledgedTarget = $this->getTotalTicketLimitCount()."명";
      }

      $maxText = '';
      $textEnd = '이 참여할 수 있는 이벤트 입니다.';
      if($this->type == "funding")
      {
        $maxText = '최소 ';
        $textEnd = '이 모여야 진행되는 이벤트입니다.';
      }

      $fundingEndTime = strtotime($this->funding_closing_at);
      $fundingEndTime = date('Y년 m월 d일', $fundingEndTime);

      //if($this->type == "pick")
      if($this->isPickType())
      {
        $pickingEndTime = strtotime($this->picking_closing_at);
        $pickingEndTime = date('Y년 m월 d일', $pickingEndTime);
        $mainExplain = '';

        if($this->isFinishedAndPickingFinished())
        {
          $mainExplain = "추첨이 완료되어 이벤트가 종료되었습니다.";
        }
        else if($this->isFinished())
        {
          $mainExplain = $pickingEndTime . "까지 추첨이 진행됩니다.";
        }
        else
        {
          $mainExplain = $fundingEndTime . '까지 신청 가능합니다.';
        }

        return $mainExplain;
      }

      //오픈예정 임시코드
      if($this->isWaitSaling())
      {
        //return "자세한 일정 및 티켓 오픈은 2월중으로 공개 됩니다.";
        //return "추첨을 통해 ".$this->getTotalTicketLimitCount()."명이 참여 할 수 있는 이벤트 입니다.";
      }



      //2018년 8월 31일 까지 최소 100명이 모여야 진행되는 이벤트입니다.(최대 200명) //참여할 수 있는 이벤트 입니다.

      return $fundingEndTime . '까지 ' . $maxText. $pledgedTarget . $textEnd;
    }

    public function getNowAmount()
    {
      //구매 인원 수
      //현재 91명 신청 완료
      $nowAmount = "";

      if($this->isOldProject())
      {
        //예전 프로젝트
        if($this->type == 'sale')
        {
          $nowAmount = "현재 ". number_format($this->funded_amount) ."명 참여 가능";
        }
        else
        {
          $totalFundingAmount = number_format($this->funded_amount);
          $nowAmount = "현재 " . $totalFundingAmount . "원 모임";
        }
      }
      else
      {
        if($this->isWaitSaling())
        {
          //$nowAmount = "오픈 예정일: ".$this->getStartSaleTime();//오픈예정 진짜코드
          $nowAmount = "오픈 예정입니다.";//오픈예정 임시코드
        }
        else
        {
          if($this->type == 'sale')
          {
            /*$nowAmount = "현재 ". number_format($this->getAmountTicketCount()) ."명 참여 가능";*/
            $nowAmount = "현재 참여 가능";
            if($this->isFinished())
            {
              $nowAmount = "티켓팅이 마감되었습니다.";
            }
          }
          else if($this->isPickType())
          {
            $nowAmount = "현재 신청 가능";

            if($this->isFinishedAndPickingFinished())
            {
              $nowAmount = "추첨이 끝났습니다.";
            }
            else if($this->isFinished())
            {
              $nowAmount = "추첨중 입니다.";
            }
          }
          else
          {
            $totalFundingAmount = number_format($this->getTotalFundingAmount());
            $nowAmount = "현재 " . $totalFundingAmount . "원 모임";

            if($this->project_target == "people")
            {
              $nowAmount = "신청자 " . $totalFundingAmount . "명";
            }
          }
        }
      }

      return $nowAmount;
    }

    public function getSaleStartTimeDay()
    {
      $time = '';
      if ($this->sale_start_at) {
          $time = strtotime($this->sale_start_at);
          $time = date('Y-m-d', $time);
      }
      return $time;
    }

    public function getSaleStartTimeHour()
    {
      $time = '';
      if ($this->sale_start_at) {
          $time = strtotime($this->sale_start_at);
          $time = date('H', $time);
      }

      return $time;
    }

    public function getFundingClosingAtOrNow()
    {
        $time = time();
        if ($this->funding_closing_at) {
            $time = strtotime($this->funding_closing_at);
        }
        return date('Y-m-d', $time);
    }

    public function isReady()
    {
        return (int)$this->state === Project::STATE_READY || (int)$this->state === Project::STATE_READY_AFTER_FUNDING;
    }

    public function isUnderConstruction()
    {
        return (int)$this->state === Project::STATE_UNDER_INVESTIGATION;
    }

    public function isPublic()
    {
        return (int)$this->state === Project::STATE_APPROVED;
        //return false;
    }

    public function isEventTypeDefault(){
      return (int)$this->event_type === Project::EVENT_TYPE_DEFAULT;
    }

    public function isEventTypeInvitationEvent(){
      return (int)$this->event_type === Project::EVENT_TYPE_INVITATION_EVENT;
    }

    public function isEventTypeCrawlingEvent(){
      return (int)$this->event_type === Project::EVENT_TYPE_CRAWLING;
    }

    public function isPickType()
    {
        //return $this->type === 'pick';
        return (int)$this->event_type === Project::EVENT_TYPE_PICK_EVENT;
    }

    public function isEventSubTypeSandBox()
    {
      return (int)$this->event_type_sub === Project::EVENT_TYPE_SUB_SANDBOX_PICK;
    }

    public function isEventSubTypeSecretProject()
    {
      return (int)$this->event_type_sub === Project::EVENT_TYPE_SUB_SECRET_PROJECT;
    }

    public function isEventTypeGroupBuy()
    {
      return (int)$this->event_type === Project::EVENT_TYPE_GROUP_BUY;
    }

    public function isEventCustomType(){
      return (int)$this->event_type === Project::EVENT_TYPE_CUSTOM;
    }

    public function isEventSubTypeWoongjinPlayCity(){
      return (int)$this->event_type_sub === Project::EVENT_TYPE_SUB_Woongjin_play_city; 
    }

    public function isSuccess()
    {
        return $this->funded_amount >= $this->pledged_amount;
    }

    public function getValidYouTubeUrl()
    {
        $path = parse_url($this->video_url, PHP_URL_PATH);
        $pathFragments = explode('/', $path);
        $end = end($pathFragments);
        return "https://youtube.com/v/" . $end;
    }

    public function countSessionDependentViewNum()
    {
        $projectIds = session('project_ids');
        if (is_array($projectIds) && in_array($this->id, $projectIds)) {
            return;
        }
        $this->increment('view_count');
        session()->push('project_ids', $this->id);
    }

    public function getFundingOrderConcludeAt()
    {
      $closing_at = $this->funding_closing_at;
      if($this->isPickType())
      {
        //pick 타입 이여도 피킹 closing 타임이 없으면 펀딩 클로딩 at으로 값 사용
        if($this->picking_closing_at)
        {
          $closing_at = $this->picking_closing_at;
        }
      }

      //$nextDay = strtotime("+1 day", strtotime($this->funding_closing_at));
      $nextDay = strtotime("+1 day", strtotime($closing_at));
      $ymd = date("Y-m-d", $nextDay);
      return date('Y-m-d H:i:s', strtotime($ymd . ' 13:00:00'));
    }

    public function isFundingType()
    {
        return $this->type === 'funding';
    }

    public function isSaleType()
    {
        return $this->type === 'sale';
    }

    public function isOldProject()
    {
      if($this->poster_url)
      {
        return "true";
      }

      return "";
    }

    //여기부터 새로운 코드
    public function getTotalTicketLimitCount()
    {
      $tickets = $this->tickets;
      $limitTicketCount = 0;
      foreach($tickets as $ticket){
        $limitTicketCount += $ticket->audiences_limit;
      }

      return $limitTicketCount;
    }

    public function getAmountTicketCount()
    {
      //총 티켓 수량 - 현재 수량
      $totalLimit = $this->getTotalTicketLimitCount();

      $totalBuyCount = $this->getTotalTicketOrderCount();

      return $totalLimit-$totalBuyCount;
    }

    public function getTotalTicketOrderCount()
    {
      //$orders = $this->orders;
      $orders = $this->getOrderWithOutCancel;
      $totalBuyCount = 0;
      foreach($orders as $order){
        $totalBuyCount += $order->count;
      }

      return $totalBuyCount;
    }

    public function getAmountTicketCountInfoList()
    {
      $tickets = $this->tickets;

      $ticketBuyInfoArray = [];

      if($tickets)
      {
        foreach ($tickets as $ticket) {
          $ticketBuyTotalCount = (int)$ticket->ordersOnlySuccess()->sum('count');
          if($ticketBuyTotalCount > 0)
          {
            $ticketInfoObject['id'] = $ticket->id;
            $ticketInfoObject['buycount'] = $ticketBuyTotalCount;

            array_push($ticketBuyInfoArray, $ticketInfoObject);
          }
        }
      }

      return json_encode($ticketBuyInfoArray);
    }
    

    /*
    public function getAmountTicketCountInfoList()
    {
      $orders = $this->orders;
      $tickets = $this->tickets;

      $ticketBuyInfoArray = [];

      if($tickets)
      {
        foreach ($tickets as $ticket) {
          $ticketBuyTotalCount = 0;

          foreach ($orders as $order) {
            if($ticket->id == $order->ticket_id)
            {
              $ticketBuyTotalCount += $order->count;
            }
          }

          if($ticketBuyTotalCount > 0)
          {
            $ticketInfoObject['id'] = $ticket->id;
            $ticketInfoObject['buycount'] = $ticketBuyTotalCount;

            array_push($ticketBuyInfoArray, $ticketInfoObject);
          }
        }
      }

      return json_encode($ticketBuyInfoArray);
    }
    */
    

    //현재 할인 수량
    public function getDiscountCount($discountId)
    {
      $orders = $this->orders;
      $discountCount = 0;

      foreach($orders as $order){
        if($order->discount_id == $discountId)
        {
          $discountCount++;
        }
      }

      return $discountCount;
    }

    //할인 남은 수량
    public function getAmountDiscount($discountId)
    {
      $discounts = $this->discounts;

      $discountAmount = 0;

      foreach($discounts as $discount)
      {
        if($discount->id == $discountId)
        {
          $discountAmount = $discount->limite_count - $this->getDiscountCount($discountId);
          break;
        }
      }


      return $discountAmount;
    }

    public function getTotalFundingAmount()
    {
      $orders = $this->getOrderWithOutCancel;
      $totalFundingAmount = 0;

      if($this->project_target == "people")
      {
        $totalFundingAmount = $this->getTotalTicketOrderCount();
      }
      else
      {
        foreach($orders as $order)
        {
          $totalPrice = $order->total_price;

          $commission = 0;

          if($order->ticket)
          {
            if($order->ticket->price > 0)
            {
              if((int)$order->type_commision === (int)Order::ORDER_TYPE_COMMISION_WITHOUT_COMMISION){
                $commission = 0;
              }else{
                $commission = $order->count * 500;
              }
            }
          }

          $totalFundingAmount += $totalPrice - $commission;
        }
      }

      return (int)$totalFundingAmount;
    }

    public function getCommentCount()
    {
      //임시로 댓글 개수만 나온다. 대댓글은 빠짐. 속도 이슈가 있음.
      $totalCommentCount = Comment::where('commentable_id', '=', $this->id)->where('commentable_type', '=', 'App\Models\Project')->count();

      return $totalCommentCount;
      /*
      $totalCommentCount = 0;
      $comments = Comment::where('commentable_id', '=', $this->id)->where('commentable_type', '=', 'App\Models\Project')->get();

      $totalCommentCount = count($comments);


      foreach($comments as $comment)
      {
        $totalCommentCount += count($comment->comments);
      }

      return $totalCommentCount;
      */
    }

    public function getFundingOrderConcludeAtBeforeOneday()
    {
        $concludeAt = $this->getFundingOrderConcludeAt();
        $beforeDay = strtotime("-1 day", strtotime($concludeAt));
        $ymd = date("Y-m-d", $beforeDay);
        return date('Y-m-d H:i:s', strtotime($ymd . ' 13:00:00'));
    }

    public function getFundingOrderConcludeAtAfterOneday()
    {
        $concludeAt = $this->getFundingOrderConcludeAt();
        $nextDay = strtotime("+1 day", strtotime($concludeAt));
        $ymd = date("Y-m-d", $nextDay);
        return date('Y-m-d H:i:s', strtotime($ymd . ' 13:00:00'));
    }

    public function getProjectURLWithIdOrAlias()
    {
      $url = url('/projects').'/';

      if($this->alias)
      {
        return $url.$this->alias;
      }
      else
      {
        return $url.$this->id;
      }
    }


    //판매를 기다리는지 확인한다
    public function isWaitSaling()
    {
      if($this->sale_start_at)
      {//strtotime
        $nowDate = date(time());
        $sale_start_at_Unix = strtotime($this->sale_start_at);
        if($sale_start_at_Unix > $nowDate)
        {
          return true;
        }

        return false;
      }

      return false;
    }

    public function getStartSaleTime()
    {
        $time = '';
        if ($this->sale_start_at) {
            $time = strtotime($this->sale_start_at);
            $time = date('Y-m-d H:i', $time);
        }

        return $time;
    }

    public function getClosingAt()
    {
      $closingAt = $this->funding_closing_at;

      if($this->isPickType())
      {
        $closingAt = $this->picking_closing_at;
      }

      return $closingAt;
    }

    public function getPickStartTime()
    {
      if(!$this->isPickType())
      {
        return '';
      }

      $nextDay = strtotime("+1 day", strtotime($this->funding_closing_at));
      //$ymd = date("Y-m-d", $nextDay);

      return date("Y-m-d", $nextDay);

      //date('Y-m-d H:i:s', strtotime($ymd . ' 00:00:00'));
      //return date('Y-m-d H:i:s', strtotime($ymd . ' 13:00:00'));
    }

    public function isTemporarilyOrderStory()
    {
      //임시로 들어가는 추가질문 가능한 프로젝트 구분하기
      if((int)$this->id === 359)
      {
        return true;
      }

      return false;
    }

    public function isPickedComplete()
    {
      if((int)$this->pick_state === self::PICK_STATE_PICKED)
      {
        return true;
      }

      return false;
    }

    public function isPayAccount()
    {
      return (int)$this->is_pay_account === Project::IS_PAY_ACCOUNT;
      /*
      if((int)$this->is_pay_account === self::IS_PAY_ACCOUNT)
      {
        return true;
      }

      return false;
      */
    }

}
