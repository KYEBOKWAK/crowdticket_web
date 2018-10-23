@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/project/form.css?version=1') }}"/>
    <link href="{{ asset('/css/calendar.css?version=1') }}" rel="stylesheet">
    <link href="{{ asset('/css/order/ticket.css?version=1') }}" rel="stylesheet">
    <style>
        .order {
            cursor: pointer;
        }

        .order .col-md-9 {
            padding-right: 80px;
        }

        .order .form-group,
        .order .ps-submit-wrapper {
            display: none;
        }

        .order.show-form .form-group,
        .order.show-form .ps-submit-wrapper {
            display: block;
        }

        .ps-submit-wrapper {
            position: absolute;
            height: 100%;
            top: 0;
            right: 0;
        }

        .ps-submit-wrapper div {
            position: relative;
            height: 100%;
        }

        .ps-submit-wrapper div img {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            margin: auto;
        }

        input[type="submit"] {
            display: none;
        }

        footer{
          display: none;
        }
    </style>

@endsection

@section('content')
<div class="project-form-container">
  @include ('order.header', ['project' => $project, 'step' => 1])

  <form id='ticketSubmitForm' action="{{ url('/tickets') }}/orders/form" method="post"
                              class="ticket-body display-table">

    @include('template.calendar', ['isDetail' => 'FALSE'])

    <div class="order_ticket_discount_md_container_flex">
      <div class="order_ticket_discount_container">
        <div class="order_ticket_discount_md_title">
          <p>할인선택</p>
        </div>
        <div class="order_ticket_content_container">
          @if(count($project->discounts) == 0)
            <div class="order_no_discount_goods"><p>선택 가능한 할인이 없습니다.</p></div>
          @else
          @foreach ($project->discounts as $discount)
            @include('template.order.discount', ['discount' => $discount])
          @endforeach
          @endif

        </div>
      </div>
      <div class="order_ticket_md_container">
        <div class="order_ticket_discount_md_title">
          <p>굿즈선택</p>
        </div>
        <div class="order_ticket_content_container">
          @if(count($project->goods) == 0)
            <div class="order_no_discount_goods"><p>선택 가능한 굿즈가 없습니다.</p></div>
          @else
            @foreach ($project->goods as $goods)
              @include('template.order.goods', ['goods' => $goods])
            @endforeach
          @endif
        </div>
      </div>
    </div>

    <div class="order_ticket_md_container" style="background-color:white;">
      <div class="order_ticket_discount_md_title">
        <p>추가 후원금 입력(선택)</p>
      </div>
      <div class="order_ticket_content_container">
        <div class="order_ticket_support_content">
          공연/이벤트가 성공적으로 진행될 수 있도록
          프로젝트 개설자를 위해 추가 후원을 하실 수 있습니다.
        </div>
        <div class="order_ticket_support_input_wrapper">
          <div class="flex_layer">
            <input id="order_support_price_input" type="number" name="order_support_price" value="" min="0"/><span>원 을 후원할래요!</span>
          </div>
        </div>
      </div>
    </div>

    <div id="order_pay_next_offset"></div>
    <div id="order_pay_next_id" class="order_pay_next_wrapper">
       <button id="order_pay_next_btn" type="button" class="order_pay_next_btn">
         <p class="order_pay_next_btn_price_text">결제 예정 금액: <span id="order_price_text">0</span>원</p>
         <p class="order_pay_next_btn_next_text">다음 단계로</p>
       </button>
     </div>

    <input type='hidden' id='discount_select_id' name='discount_select_id' value=''/>
    <input type='hidden' id='discount_select_value' name='discount_select_value' value=''/>

    <!-- <button type="submit" id="ticketing-btn-calendar" class="btn btn-primary btn-block ticketing-btn-calendar">금액: <span class="totalPrice">0</span></button> -->
    @include('csrf_field')
  </form>
</div>
@endsection

@section('js')
<script src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.2/angular.min.js'></script>
<script src="{{ asset('/js/calendar/calendar.js?version=4') }}"></script>

    <script>
        $(document).ready(function () {
          $(".order_ticket_discount_item_btn").each(function () {
              $(this).bind('click', function () {
                var discountIdInput = $('#discount_select_id');//필요할지 모르겠음
                var discountValue = $('#discount_select_value');
                var isSameSelect = false;
                if($(this).is('.order_ticket_discount_item_btn_on'))
                {
                  isSameSelect = true;
                  discountIdInput.val('');
                  discountValue.val('');
                }

                //클릭한 아이템을 제외한 나머지 아이템은 초기회
                $(".order_ticket_discount_item_btn").each(function () {
                  $(this).removeClass('order_ticket_discount_item_btn_on');
                });

                if(isSameSelect == false)
                {
                  $(this).addClass('order_ticket_discount_item_btn_on');
                  discountIdInput.val($(this).attr('discount-id'));
                  discountValue.val($(this).attr('discount-value'))
                }
                //alert(discountValue.val());
                setTotalPrice();
              });
          });

            var setTotalPrice = function(){
              //
              var ticketPrice = $('#ticket_select_price').val();
              var ticketCount = $('#ticket_count_input').val();

              var ticketTotalPrice = ticketPrice * ticketCount;

              $('#request_price').val(ticketPrice);
              $('#ticket_count').val(ticketCount);

              //할인율 적용
              var discountValue = $('#discount_select_value').val();
              if(discountValue)
              {
                //alert("discount value : " + discountValue);
                var discoutPrice = ticketTotalPrice * (discountValue/100);
                ticketTotalPrice = ticketTotalPrice - discoutPrice;
              }

              //추가된 md가 있는지 확인

              var goodsArray = new Array();
              $(".ticket_goods_count_input").each(function () {
                var goodsCount = $(this).val();

                if(goodsCount == 0)
                {
                  return true;//for문의 continue와 같음.
                }

                var goodsPrice = $(this).attr('goods-price');
                var goodsTicketDiscountPrice = $(this).attr('goods-ticket-discount-price');
                goodsTicketDiscountPrice = goodsTicketDiscountPrice * goodsCount;
                var goodsTotalPrice = goodsPrice * goodsCount;

                var goodsInfo = new Object();
                goodsInfo.totalPrice = goodsTotalPrice;
                goodsInfo.ticketDiscount = goodsTicketDiscountPrice;

                goodsArray.push(goodsInfo);
              });

              //ticketTotalPrice
              //실제 MD 계산
              var mdTicketTotalPrice = 0;
              var mdTicketDiscountPrice = 0;
              for(var i = 0 ; i < goodsArray.length ; i++)
              {
                mdTicketTotalPrice = mdTicketTotalPrice + goodsArray[i].totalPrice;
                mdTicketDiscountPrice = mdTicketDiscountPrice + goodsArray[i].ticketDiscount
              }

              ticketTotalPrice = ticketTotalPrice + mdTicketTotalPrice - mdTicketDiscountPrice

              //추가 후원이 있는지 확인
              var supportPrice = Number($('#order_support_price_input').val());
              ticketTotalPrice = ticketTotalPrice + supportPrice;

              $('#order_price_text').text( addComma(ticketTotalPrice));
            };

            $('#ticket_count_input').bind("click", setTotalPrice);
            $('#order_support_price_input').bind("click", setTotalPrice);
            $('#order_support_price_input').bind("change", setTotalPrice);

            $('#order_pay_next_btn').click(function(){
              if($('#ticket_select_id_input').val()){
                $('#ticketSubmitForm').submit();
              }
              else{
                alert("티켓을 선택해주세요.");  
              }
            });
            //$('.ticket_goods_count_input').bind("click", setTotalPrice);


            //버튼 스크롤
            var navOffsetHeight = $('#order_pay_next_id').height();
            var mainHeight = $('#main').height();

            var setMainHeight = function(){
              if($('#main').height() < $('#order_pay_next_offset').offset().top + navOffsetHeight);
              {
                $('#main').height($('#order_pay_next_offset').offset().top + navOffsetHeight);
              }
            };

            var sizeHeightCheck = function(){
                mainHeight = $('#main').height();
                setMainHeight();
            };

            var nextBtnScrollCheck = function(){
              $('#order_pay_next_id').addClass('navbar-fixed-bottom');
            };

            //var goodsCountUp =

            $(window).scroll(function() {
              sizeHeightCheck();
          		nextBtnScrollCheck();
            });

            $(window).resize(function() {
          		//navpos = $('#order_pay_next_offset').offset();
            });

            var goodsCountUp = function(){
              var goodsId = $(this).attr('goods-id');
              var goodsInputInfo = $("#goods_count_input"+goodsId);

              var goodsCount = goodsInputInfo.val();
              goodsCount++;

              setGoodsCount(goodsId, goodsCount);
            };

            var goodsCountDown = function(){
              var goodsId = $(this).attr('goods-id');
              var goodsInputInfo = $("#goods_count_input"+goodsId);

              var goodsCount = goodsInputInfo.val();
              goodsCount--;
              if(goodsCount < 0)
              {
                goodsCount = 0;
              }

              setGoodsCount(goodsId, goodsCount);
            };

            var setGoodsCount = function(goodsId, goodsCount)
            {
              $(".goods_count_text"+goodsId).text(goodsCount+"개");
              $("#goods_count_input"+goodsId).val(goodsCount);
            }

            $(".goods_count_up").bind('click', goodsCountUp);
            $(".goods_count_down").bind('click', goodsCountDown);

            setMainHeight();
            nextBtnScrollCheck();

            setTotalPrice();
        });
    </script>
    @include('template.detail_ticket_time')
    @include('template.detail_ticket_seat')
@endsection
