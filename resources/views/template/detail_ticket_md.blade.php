<div id="detail_ticket_md" class="tab-pane">
  <div class="detail_calender_container">
    <h4 style="font-weight:600; margin-top:0px">
      TICKET <span class="detail_date_sub_title"> | 티켓팅 가능날짜: {{ $project->getConcertDateFormatted() }}</span>
    </h4>
    <div class="detail_ticket_container">
      @include('template.calendar', ['isDetail' => 'TRUE'])
    </div>
  </div>

  <div class="detail_discount_container @if(count($discounts) == 0) display_none @endif">
      <h4 style="font-weight:600;">할인정보</h4>
      <div class="detail_discount_contant_container">
        @foreach($discounts as $discount)
          @include('template.detail_discount', ['discount' => $discount])
        @endforeach
      </div>
  </div>

  <h4 class="@if(count($project->goods) == 0) display_none @endif " style="font-weight:600;">굿즈</h4>
  <div id="detail_goods_list"></div>
</div>
