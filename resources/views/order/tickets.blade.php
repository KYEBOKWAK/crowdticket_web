@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/project/form.css?version=5') }}"/>
    <link href="{{ asset('/css/calendar.css?version=8') }}" rel="stylesheet">
    <link href="{{ asset('/css/order/ticket.css?version=6') }}" rel="stylesheet">
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

    @if($project->isEventTypeDefault())
      <div class="order_ticket_discount_md_container_flex">
        <div class="order_ticket_discount_container">
          <div class="order_ticket_discount_md_title">
            <p>티켓할인선택</p>
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
    @endif

    <div id="order_pay_next_offset"></div>
    <div id="order_pay_next_id" class="order_pay_next_wrapper">
       <button id="order_pay_next_btn" type="button" class="order_pay_next_btn">
         <p class="order_pay_next_btn_price_text">
          @if($project->isEventTypeDefault())
            결제 예정 금액: <span id="order_price_text">0</span>원
          @elseif($project->isEventTypeInvitationEvent())
            초대권 신청중
          @endif
         </p>
         <p class="order_pay_next_btn_next_text">다음 단계로</p>
       </button>
     </div>

    <input type='hidden' id='project_id' name='project_id' value='{{ $project->id }}'/>
    <input type='hidden' id='discount_select_id' name='discount_select_id' value=''/>
    <input type='hidden' id='discount_select_value' name='discount_select_value' value=''/>

    <input style="VISIBILITY: hidden; WIDTH: 0px">

    @include('csrf_field')
  </form>
</div>
@endsection

@section('js')
<script src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.2/angular.min.js'></script>
<script src="{{ asset('/js/calendar/calendar.js?version=15') }}"></script>

    <script>
        $(document).ready(function () {
          $(".order_ticket_discount_item_btn").each(function () {
              $(this).bind('click', function () {
                //할인 선택은 티켓 먼저 선택 해야 한다.

                if(!$('#ticket_select_id_input').val()){
                  alert("티켓을 선택 해주세요");
                  return;
                }

                /*
                //수량이 0개이면 선택 안됨.
                if( Number($(this).attr('discount-amount')) <= 0 )
                {
                  alert("할인 매수가 없습니다.");
                  return;
                }
                */

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
              var goodsTotalPrice = 0;

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
              var goodsTotalPrice = 0;
              var goodsTicketDiscountPrice = 0;
              for(var i = 0 ; i < goodsArray.length ; i++)
              {
                goodsTotalPrice = goodsTotalPrice + goodsArray[i].totalPrice;
                goodsTicketDiscountPrice = goodsTicketDiscountPrice + goodsArray[i].ticketDiscount
              }

              ticketTotalPrice = ticketTotalPrice - goodsTicketDiscountPrice;
              if(ticketTotalPrice < 0)
              {
                ticketTotalPrice = 0;
              }

              //ticketTotalPrice = ticketTotalPrice + mdTicketTotalPrice - mdTicketDiscountPrice

              //추가 후원이 있는지 확인
              var supportPrice = Number($('#order_support_price_input').val());

              var totalPrice = ticketTotalPrice + goodsTotalPrice + supportPrice;

              //최종 구매 금액
              if(totalPrice < 0)
              {
                totalPrice = 0;
              }

              $('#order_price_text').text( addComma(totalPrice));
            };

            $('#order_support_price_input').bind("click", setTotalPrice);
            $('#order_support_price_input').bind("change", setTotalPrice);

            $('#order_pay_next_btn').click(function(){
              if(!$('#project_id').val())
              {
                //프로젝트 id 는 무조건 있어야 함. 결제시 필요
                alert("프로젝트 ID 오류");
                return;
              }


              if(!$('#ticket_select_id_input').val()) {
                //티켓이 없다면, 최종확인시 카운트 값을 0으로 정해준다.
                $("#ticket_count_input").val(0);
              }

              var ticketCountDom = $( "#ticket_count_input" );
              var ticketCount = ticketCountDom.val();
              if(ticketCount > 0)
              {
                var ticketAmount = Number(ticketCountDom.attr("ticket-data-amount"));
                if(ticketCount > ticketAmount)
                {
                  alert("티켓 수량을 초과하였습니다.");
                  return;
                }

                var limitBuyCount = Number(ticketCountDom.attr("ticket-buy-limit"));
                if(limitBuyCount > 0 && ticketCount > limitBuyCount)
                {
                  alert("1회 구매 수량을 초과하였습니다.");
                  return;
                }
              }

              if(isValidSubmit() == true)
              {
                //구매 가능한 상태가 되었는데, 티켓 수량이 0이면 티켓 초기화
                if($("#ticket_count_input").val() == 0)
                {
                  $('#ticket_select_id_input').val('');
                }

                $('#ticketSubmitForm').submit();
              }
              else
              {
                alert("구매 가능한 상품을 선택해주세요");
              }
            });

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
              var goodsAmount = $(this).attr('goods-amount');
              var goodsInputInfo = $("#goods_count_input"+goodsId);

              var goodsCount = goodsInputInfo.val();

              goodsCount++;
              if(goodsAmount)
              {
                if(goodsAmount < goodsCount)
                {
                  alert("보유 수량을 초과했습니다.");
                  goodsCount = goodsAmount;
                }
              }

              goodsInputInfo.val(goodsCount);

              setGoodsCount(goodsId, goodsCount);

              setTotalPrice();
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
              goodsInputInfo.val(goodsCount);

              setGoodsCount(goodsId, goodsCount);

              setTotalPrice();
            };

            var setGoodsCount = function(goodsId, goodsCount)
            {
              $(".goods_count_text"+goodsId).text(goodsCount+"개");
              $("#goods_count_input"+goodsId).val(goodsCount);
            };

            var isValidSubmit = function()
            {
              //티켓 확인
              var isTickets = false;
              if($('#ticket_select_id_input').val())
              {
                isTickets = true;
                //$('#ticket_select_id_input').val('');
                //티켓을 선택했는데, 스량이 0이라면 선택 안함.
                if($("#ticket_count_input").val() == 0)
                {
                  isTickets = false;
                }
              }

              //굿즈 확인
              var isGoods = false;
              $(".ticket_goods_count_input").each(function () {
                var goodsCount = $(this).val();

                if(goodsCount == 0)
                {
                  return true;//for문의 continue와 같음.
                }

                isGoods = true;

              });

              //굿즈가 있으면 티켓 상관없이 결제 진행
              if(isGoods)
              {
                return true;
              }

              //후원만 있어도 결제 가능
              var supportPrice = Number($('#order_support_price_input').val());
              if(supportPrice > 0)
              {
                return true;
              }

              //굿즈 체크 후 티켓 체크
              if(isTickets)
              {
                return true;
              }

              //후원 확인
              return false;
            };

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
