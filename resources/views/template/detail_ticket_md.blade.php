<div class='detail_ticket_md_container'>
  <div id="detail_ticket_md" class="tab-pane">
    @if(!$project->isEventTypeCrawlingEvent())
      <div class="detail_calender_container">
        <h4 style="font-weight:600; margin-top:0px">
          TICKET <span class="detail_date_sub_title"> | @if($project->isEventSubTypeSandBox()) @elseif($project->isEventTypeInvitationEvent()) 신청 가능날짜 @else 티켓팅 가능날짜 @endif @if(!$project->isEventSubTypeSandBox()): {{ $project->getConcertDateFormatted() }} @endif</span>
        </h4>
        <div class="detail_ticket_container">
          @include('template.calendar', ['isDetail' => 'TRUE'])
        </div>
      </div>
    @else
      @if($project->ticket_notice)
        <input type="hidden" id="ticket_notice" value="{{ $project->ticket_notice }}"/>
        <div id="ticket_notice_container">
        </div>
      @endif
      <a href="@if($project->url_crawlings()) {{$project->url_crawlings()->url}} @endif" target="_blank"><button type="button" class="btn btn-primary btn-block detail_main_guide_ticketing_btn">외부페이지로 이동</button></a>
    @endif


    <div class="detail_discount_container @if(count($discounts) == 0) display_none @endif">
        <h4 style="font-weight:600;">할인정보(티켓당)</h4>
        <div class="detail_discount_contant_container">
          @foreach($discounts as $discount)
            @include('template.detail_discount', ['discount' => $discount, 'project' => $project])
          @endforeach
        </div>
    </div>

    <h4 class="@if(count($project->goods) == 0) display_none @endif " style="font-weight:600;">굿즈</h4>
    <div id="detail_goods_list"></div>
  </div>

  <div class='mannayo_banner_container'>
    <a href="https://crowdticket.typeform.com/to/rRUBMA" target='_blank'>
      <img class='mannayo_banner_img' src='https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/200414_online_detail_page_banner.png'>
    </a>
  </div>
</div>
