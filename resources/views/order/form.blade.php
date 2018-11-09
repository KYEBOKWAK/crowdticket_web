@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/project/form.css?version=2') }}"/>
    <link href="{{ asset('/css/order/ticket.css?version=6') }}" rel="stylesheet">
    <style>
        .ps-section-title {
            font-weight: bold;
            font-size: 19px;
            margin-top: 30px;
        }

        .ps-section-title span {
            font-size: 14px;
            color: #777;
            margin-left: 2em;
        }

        .ps-section-title:first-child {
            margin-top: 0px;
        }

        .ps-box {
            background-color: #FFFFFF;
            border: 1px #DAD8CC solid;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            padding: 25px 0px 25px 0px;
        }

        .ps-form-control-like {
            padding: 6px 12px 6px 0px;
            font-size: 13px;
            margin-bottom: 0px;
        }

        #order-account-name {
            width: 16.667%;
        }

        form .btn-success,
        form .btn-danger,
        form .btn-muted {
            margin-top: 50px;
        }

        label.commission-label {
            text-align: left !important;
        }

        .total-price input,
        .total-price .input-group-addon {
            border: 1px solid #CC0000;
            font-weight: bold;
        }

        .total-price .input-group-addon {
            border-left: 0
        }

        .prevent-autocomplete {
            width: 1px;
            height: 1px;
            float: right;
            border: none;
        }

        .ps-tooltip {
            margin-top: 1em;
        }
    </style>
@endsection

@section('content')
    <input id="ticketJson" type="hidden" value="{{ $ticket }}"/>
    <input id="discount" type="hidden" value="{{ $discount }}"/>
    <input id="goodsList" type="hidden" value="{{ $goodsList }}"/>
    <input id="tickets_json_category_info" type="hidden" value="{{ $categories_ticket }}"/>
    <input id="project_type" type="hidden" value="{{ $project->type }}"/>
    <input id="orderInfo" type="hidden" value="{{ $order }}"/>
<div class="form_main_container">
  <div class="form_main_head_container">
    @include ('order.header', ['project' => $project, 'step' => $order ? 0 : 2])
  </div>
  <div class="project-form-container">
      <form id="ticketSubmitPayForm" class="row form-horizontal order_form_conform_container" data-toggle="validator" role="form"
            action="{{ $form_url }}/" method="post">
        @include('form_method_spoofing', ['method' => $order ? 'delete' : 'post'])
        <input id="request_price" type="hidden" name="request_price" value="{{ $request_price }}"/>
        <input id="ticket_count" type="hidden" name="ticket_count" value="{{ $ticket_count }}"/>
        <input id="discountId" type="hidden" name="discountId" value=""/>
        <input id="supportPrice" type="hidden" name="supportPrice" value="{{ $supportPrice }}"/>
        <input id="project_id" type="hidden" name="project_id" value="{{ $project->id }}">
        <input id="ticket_id" type="hidden" name="ticket_id" value="@if($ticket){{ $ticket->id }}@endif"/>

        <div class="order_form_conform_container">
          <div class='order_form_conform_title'>
            선택 내역 확인
          </div>

          <div class="order_form_conform_container_grid_rows">
            <div class="order_form_conform_container_grid_columns">
              <p class="order_form_title">티켓</p>
              <div class="flex_layer">
                <div class="order_form_ticket_contant order_form_text">
                </div>
                <div class="order_form_align_right order_form_ticket_price order_form_text">
                </div>
              </div>
            </div>

            <div class="order_form_conform_container_grid_columns">
              <p class="order_form_title">할인내역</p>
              <div class="flex_layer">
                <div class="order_form_discount_contant order_form_text">
                </div>
                <div class="order_form_discount_price order_form_text order_form_align_right">
                </div>
              </div>
            </div>

            <div class="order_form_conform_container_grid_columns">
              <p class="order_form_title">MD</p>
              <div class="order_form_goods_list"></div>
              <!--
              <div class="flex_layer">
                <div class="order_form_md_contant order_form_text">
                </div>
                <div class="order_form_md_price order_form_text order_form_align_right">
                </div>
              </div>
              -->
            </div>

            <div class="order_form_conform_container_grid_columns">
              <p class="order_form_title">추가후원</p>
              <div class="flex_layer">
                <div class="order_form_support_contant order_form_text">
                </div>
                <div class="order_form_support_price order_form_text order_form_align_right">
                </div>
              </div>
            </div>

            <div class="order_form_conform_container_grid_columns">
              <p class="order_form_title">티켓 수수료</p>
              <div class="flex_layer">
                <div class="order_form_commission_contant order_form_text">
                </div>
                <div class="order_form_align_right order_form_commission_price order_form_text">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="order_form_conform_container">
          <div class='order_form_conform_title'>
            <h3>
            @if( $project->project_target == "people" )
            총 결제 금액
            @else
            총 예약 금액
            @endif
            </h3>
            <h4 class='order_form_total_price'></h4>
          </div>
        </div>

        @if($project->isDelivery == "TRUE")
        <div class="order_form_conform_container">
          <div class='order_form_conform_title'>
            @if($order)
              굿즈 배송 정보
              <input id="placeReceive" type="checkbox" disabled="disabled"/><span class="order_form_title">현장 수령</span>
            @else
              굿즈 배송 정보 입력
              <input id="placeReceive" type="checkbox"/><span class="order_form_title">현장 수령</span>
            @endif
          </div>
          <div class="order_form_goods_address_container" style="margin: 20px 0px;">
            <div class="col-md-12">
                <div class="ps-box">
                    <div class="form-group">
                        <label for="order-address" class="col-sm-2 control-label">주소</label>
                        <div class="col-sm-2">
                            @if ($order)
                                <input id="order-address" name="postcode" type="text"
                                       class="form-control postcodify_postcode5" readonly="readonly"
                                       placeholder="우편번호" value="{{ $order->postcode }}"/>
                            @else
                                <input id="order-address" name="postcode" type="text"
                                       class="form-control postcodify_postcode5" required="required"
                                       readonly="readonly" placeholder="우편번호"/>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            @if (!$order)
                                <a href="#" id="postcodify_search_button" style="display: none;">검색</a>
                                <a href="#" class="btn btn-default" id="postcodify_search_button_fake">검색</a>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-2">
                            @if ($order)
                                <input type="text" name="address_main"
                                       class="form-control postcodify_address" readonly="readonly"
                                       value="{{ $order->address_main }}"/>
                            @else
                                <input type="text" name="address_main"
                                       class="form-control postcodify_address" required="required"
                                       readonly="readonly" placeholder="주소를 검색해주세요"/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-2">
                            @if ($order)
                                <input type="text" name="address_detail"
                                       class="form-control postcodify_details" readonly="readonly"
                                       value="{{ $order->address_detail }}"/>
                            @else
                                <input type="text" name="address_detail"
                                       class="form-control postcodify_details" required="required"
                                       placeholder="상세주소를 입력해주세요"/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order-comment" class="col-sm-2 control-label">비고</label>
                        <div class="col-sm-8">
                            @if ($order)
                                <input id="order-comment" name="requirement" type="text"
                                       class="form-control" readonly="readonly"
                                       value="{{ $order->requirement }}"/>
                            @else
                                <input id="order-comment" name="requirement" type="text"
                                       class="form-control" placeholder="보상품 세부사항 및 기타 요청 사항"/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-8">
                            <p class="ps-form-control-like text-danger">
                                입력하신 개인 정보는 결제 확인 알림 및 현재 참여하고 있는 공연 정보 발송 외의 용도로는 절대 사용하지 않으니 걱정하지 마세요!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        @endif <!-- isDelivery -->

        <div class="order_form_conform_container">
          <div class='order_form_conform_title'>
            <h3>
            @if ($order)
              @if( $project->type == "sale" )
              결제 정보
              @else
              예약 정보
              @endif
            @else
              @if( $project->type == "sale" )
              결제 정보 입력
              @else
              예약 정보 입력
              @endif
            @endif
            </h3>
          </div>

          @if($project->type == 'funding')
            <?php
            $funding_closing_date = new DateTime($project->funding_closing_at);
            $funding_closing_date->modify('+1 day');
            $funding_pay_day = $funding_closing_date->format('Y-m-d');
            ?>

            <p class="order_form_title" style="margin-top: 10px; height:30px;">결제 예약에 관하여</p>
            <div class="order_form_conform_container_grid_rows" style="padding-left:10px;">
              <u style="font-size: 18px; font-weight: bold; margin-bottom:10px">지금 결제 정보를 입력해도 결제가 진행되지 않습니다</u>
              <p style="margin-top:6px">1. {{ $project->title }}은 목표에 도달한 경우에 한하여 {{ $funding_pay_day }} 1PM 에 결제가 진행되는 프로젝트 입니다.</p>
              <p>2. 목표에 달성하지 않을 경우 아무 일도 일어나지 않습니다.</p>
              <p>3. 카드분실, 잔액부족으로 인해 예약된 결제가 제대로 처리되지 않을 수 있습니다.</p>
              <h4><u>프로젝트가 목표에 성공하면, {{ $funding_pay_day }} 1pm 에 결제가 진행됩니다!</u></h4>
            </div>
          @endif
        </div>

        <div class="order_user_info_container">
          <div class="order_form_user_container_grid_two_columns">
            <div class="flex_layer">
              <p class="order_form_title order_form_user_title">성명</p>
              @if ($order)
                <input id="name" type="text" name="name" value="{{ $order->name }}" readonly="readonly"/>
              @else
                <input id="name" type="text" name="name" value="{{ \Auth::user()->name }}"/>
              @endif
            </div>
          </div>

          <div class="order_form_user_container_grid_two_columns">
            <div class="flex_layer">
              <p class="order_form_title order_form_user_title">연락처</p>
              @if ($order)
                <input id="phone" type="text" name="contact" value="{{ $order->contact }}" placeholder="-없이 숫자만 입력" readonly="readonly"/>
              @else
                <input id="phone" type="text" name="contact" value="{{ \Auth::user()->contact }}" placeholder="-없이 숫자만 입력"/>
              @endif
            </div>
          </div>

          <div class="order_form_user_container_grid_two_columns">
            <div class="flex_layer">
              <p class="order_form_title order_form_user_title">이메일</p>
              @if ($order)
                <input id="email" type="email" name="email" value="{{ $order->email }}" readonly="readonly"/>
              @else
                <input id="email" type="email" name="email" value="{{ \Auth::user()->email }}"/>
              @endif
            </div>
          </div>

          @if (!$order)
            <div id="order_card_number_container" class="order_form_user_container_grid_two_columns">
              <div class="flex_layer">
                <p class="order_form_title order_form_user_title">카드번호</p>
                <div>
                  <input id="order-card-number" name="card_number" type="text"
                         class="form-control" autocomplete="off" required="required"
                         placeholder="-없이 숫자만 입력"/>
                   <div>
                       *체크카드, 신용카드, 법인카드 모두 가능합니다.
                   </div>
                </div>
              </div>
            </div>

            <div id="expiry_month_container" class="order_form_user_container_grid_two_columns">
              <div class="flex_layer">
                <p class="order_form_title order_form_user_title">유효기간</p>
                <div style="margin-top:8px;">
                  <select id="expiry_month" name="expiry_month" class="form-control" required="required">
                    <option selected disabled>mm</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                  <select id="expiry_year" name="expiry_year" class="form-control" required="required">
                      <option selected disabled>yyyy</option>
                      @for ($i = 2018; $i <= 2030; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                  </select>
                </div>
              </div>
            </div>

            <div id="order-birth_container" class="order_form_user_container_grid_two_columns">
              <div class="flex_layer">
                <div style="flex-basis: 130px; flex-shrink: 0; padding-right: 50px;">
                  <p class="order_form_title order_form_user_title" style="padding-right: 0px;">생년월일</p><p style="text-align:right;">(법인등록번호)</p>
                </div>
                <input style="width:280px;" id="order-birth" name="birth" type="text"
                   class="form-control" autocomplete="off" required="required"
                   placeholder="주민번호 앞6자리(법인등록번호 7자리)"/>
              </div>
            </div>

            <div id="card_password_container" class="order_form_user_container_grid_two_columns">
              <div class="flex_layer">
                <p class="order_form_title order_form_user_title">카드비밀번호</p>
                <div>
                  <div class="flex_layer">
                    <input id="order-card-password" name="card_password" type="password"
                           class="form-control" autocomplete="off" required="required"
                           maxlength="2"/>
                    <span class="input-group-addon password_back">**</span>
                  </div>
                  <div>
                    크라우드티켓에서는 고객의 편의를 위해 비인증 카드결제를 이용하고 있습니다.
                    위 입력 정보는 암호화 되어 1회용으로만 쓰이며 저장되지 않습니다.
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>

        <div class="order_form_conform_container">
          <div class='order_form_conform_title'>
            <p class="order_form_title">
              크라우드티켓 이용 정책 동의
            </p>
          </div>

          <div>
            <h4> 환불 정책 </h4>
            <div class="order_form_conform_container_grid_rows">
              @if($project->type == 'funding')
                <p style="margin-bottom:0px;">
                  본 프로젝트는 목표에 도달하여야 성공하는 프로젝트로, 티켓팅 마감일 하루 전까지는 언제든지 결제 예약을 수수료 없이 취소할 수 있습니다. 다만 티켓팅 마감 24시간 전부터는 프로젝트 진행자의 기대이익에 따라 취소가 불가능합니다.
                </p>
              @else
                <p>1. 관람일 9일전 ~ 1일전 티켓 환불 시 총 결제금액의 10%가 취소 수수료로 부과됩니다.</p>
                <p>2. 티켓을 구매하지 않았을 시 환불 수수료가 붙지 않습니다.</p>
                <p>3. 공연 당일 환불은 불가능합니다.</p>
                <p>4. 관람일을 기준으로 10일 이상 남은 경우, 취소 수수료는 없습니다.</p>
                <p>5. 티켓 환불은 오른쪽 상단 '결제확인' 탬에서 진행하시면 됩니다.</p>
              @endif
              </div>
          </div>
          <div style="text-align:right; margin-top:10px; margin-bottom:10px;">
            <div>
              환불 정책에 동의합니다. <input id="refund_apply" type="checkbox" required="required">
            </div>
            <div>
              크라우드티켓 약관과 정보이용정책에 동의합니다. <input id="policy_apply" type="checkbox" required="required">
            </div>
          </div>
        </div>

        @if ($order)
        <div style="text-align: center">
            @if ($order->deleted_at)
                @if ($project->type === 'funding')
                    <button class="btn btn-muted" disabled="disabled">취소됨</button>
                @else
                    <button class="btn btn-muted" disabled="disabled">환불됨</button>
                @endif
            @else
                @if ($order->canCancel())
                    @if ($project->type === 'funding')
                        <button class="btn btn-danger">취소하기</button>
                    @else
                        <button class="btn btn-danger">환불하기</button>
                        @if ($order->hasCancellationFees())
                            <p class="ps-tooltip text-danger">
                              환불 정책에 따라 취소 수수료 {{ number_format($order->getCancellationFees()) }}원이 차감된 {{ number_format($order->getRefundAmount()) }}원이 환불됩니다.<br/>
                                환불은 2~3일 정도 소요될 수 있습니다.
                            </p>
                        @endif
                    @endif
                @else
                    @if ($project->type === 'funding')
                        <button class="btn btn-muted" disabled="disabled">취소불가</button>
                        <p class="ps-tooltip text-danger">취소 가능 일자가 만료되었습니다.</p>
                    @else
                        <button class="btn btn-muted" disabled="disabled">환불불가</button>
                        <p class="ps-tooltip text-danger">환불 가능 일자가 만료되었습니다.</p>
                    @endif
                @endif
            @endif
          </div>
        @else
          <div class="order_form_conform_container">
            <button type="button" id="ticketing-btn-payment" class="btn btn-primary btn-block ticketing-btn-calendar ticketing-btn-payment"></button>
          </div>
        @endif
      </form>
  </div>
</div>
@endsection

@section('js')
    @include('template.order.form_goods_price')
    <script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>
    <script>
        $(document).ready(function () {
          var g_ticketPrice = 0;
          var g_discoutPrice = 0;
          var g_goodsArray = new Array();
          var g_commission = 0;
          var g_supportPrice = 0;

          var ticketsCategoryJson = $('#tickets_json_category_info').val();
        	var ticketsCategory = '';
        	if (ticketsCategoryJson) {
        		//alert(ticketsCategoryJson);
        		 ticketsCategory = $.parseJSON(ticketsCategoryJson);
        	}

          var g_isGetOrderForm = false;
          if($('#orderInfo').val())
          {
            g_isGetOrderForm = true;
          }

          $("#postcodify_search_button").postcodifyPopUp();
            $('#postcodify_search_button_fake').bind('click', function () {
                $('#postcodify_search_button').trigger('click');
                return false;
            });

          var setTicketInfo = function(){
            var ticketJson = $('#ticketJson').val();
            var ticket = '';
            if (ticketJson) {
               ticket = $.parseJSON(ticketJson);
            }

            if(!ticket)
            {
              $('.order_form_ticket_contant').text("티켓 없음");
              return;
            }

            var rawDate = ticket.show_date.split(" ");
            var d = rawDate[0].split("-");
            var t = rawDate[1].split(":");

            var ticketDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);

            var yyyy = ticketDate.getFullYear();
            var mm = ticketDate.getMonth() + 1;
            var dd = ticketDate.getDate();
            var H = ticketDate.getHours();
            var min = ticketDate.getMinutes();

            if(mm < 10)
            {
              mm = "0"+mm;
            }

            if(dd < 10)
            {
              dd = "0"+dd;
            }

            if(H < 10){
              H = "0" + H;
            }
            if (min < 10) {
              min = "0" + min;
            }

            var ticketCategory = getTicketCategory(ticket);

            var ticketCount = $('#ticket_count').val();

            var fullTicketInfo = yyyy+'.'+mm+'.'+dd+' '+H+':'+min + ' ' + ticketCategory + ' ' + ticketCount + '매';

            if(d[0] == 0000){
              fullTicketInfo = ticketCategory + ' ' + ticketCount + '매';
            }

            $('.order_form_ticket_contant').text(fullTicketInfo);

            g_ticketPrice = ticket.price * ticketCount;
            var fullTicketPrice = addComma(g_ticketPrice) + '원';

            $('.order_form_ticket_price').text(fullTicketPrice);
          };

          var setDiscountInfo = function(){
            var fullDiscountInfo = "할인 없음";
            var discount = $('#discount').val();
            var docDiscountId = $("#discountId");
            docDiscountId.val("");

            if(discount) {
              discount = $.parseJSON(discount);

              //할인율 찾기
              //var discoutPrice = g_ticketPrice * (discount.percent_value/100);
              g_discoutPrice = g_ticketPrice * (discount.percent_value/100);

              fullDiscountInfo = discount.content + ' ' + discount.percent_value + '%';
              var fullDiscountPriceInfo = "-"+addComma(g_discoutPrice)+"원";

              $(".order_form_discount_price").text(fullDiscountPriceInfo);

              docDiscountId.val(discount.id);
            }

            $(".order_form_discount_contant").text(fullDiscountInfo);
          };

          var setGoodsInfo = function(){
            var goods = $('#goodsList').val();
            goods = $.parseJSON(goods);

            var formMDList = $('.order_form_goods_list');
            var goodsCount = goods.length;
            if(goodsCount == 0){
              formMDList.text("MD 없음")
            }
            else {
              for(var i = 0 ; i < goodsCount ; ++i){
                var isLast = false;

                if(i == goodsCount - 1)
                {
                  isLast = true;
                }

                var goodsItem = goods[i];

                var isTicketDiscount = "false";
                if(g_ticketPrice > 0 && Number(goodsItem.info.ticket_discount) > 0 )
                {
                  //alert(goodsItem.info.ticket_discount);
                  isTicketDiscount = "true";
                }

                var goodsTotalPrice = goodsItem.info.price * goodsItem.count;
                var goodsTotalDiscount = goodsItem.info.ticket_discount * goodsItem.count;

                /*
                var templateGoodsContainer = $('#template_order_goods_content_list_item').html();
          			var compiledGoodsContainer = _.template(templateGoodsContainer);
          			var rowGoodsContainer = compiledGoodsContainer({ 'goods': goodsItem.info, 'goodsCount': goodsItem.count, 'isTicketDiscount':isTicketDiscount });
          			var $rowGoodsContainer = $($.parseHTML(rowGoodsContainer));
          			formMDContant.append($rowGoodsContainer);
                */

                var templateGoodsPriceContainer = $('#template_order_goods_price_list_item').html();
          			var compiledGoodsPriceContainer = _.template(templateGoodsPriceContainer);
          			var rowGoodsPriceContainer = compiledGoodsPriceContainer({ 'goods': goodsItem.info, 'goodsTotalPrice': goodsTotalPrice, 'goodsPrice':goodsItem.info.price, 'goodsCount': goodsItem.count, 'goodsTotalDiscount': goodsTotalDiscount, 'isTicketDiscount':isTicketDiscount, 'isLast': isLast });
          			var $rowGoodsPriceContainer = $($.parseHTML(rowGoodsPriceContainer));
          			formMDList.append($rowGoodsPriceContainer);

                var goodsObject = new Object();
                goodsObject.price = goodsTotalPrice;
                goodsObject.ticketDiscount = goodsTotalDiscount;
                g_goodsArray.push(goodsObject);
              }
            }
          };

          var getTicketCategory = function(ticket){
            var ticketCategoryTemp = ticket.category;
        		if(ticketsCategory.length > 0){
        			var categoryNum = Number(ticket.category);
        			for (var i = 0; i < ticketsCategory.length; i++) {
        				if(Number(ticketsCategory[i].id) === categoryNum){
        					ticketCategoryTemp = ticketsCategory[i].title;
        					break;
        				}
        			}
        		}

            return ticketCategoryTemp;
          };

          var setCommissionInfo = function(){
            var ticketCount = $('#ticket_count').val();

            var discountTicketPrice = g_ticketPrice - g_discoutPrice;
            if(ticketCount > 0 && g_ticketPrice > 0 && discountTicketPrice > 0)
            {
              g_commission = 500 * ticketCount;
              var fullCommission = addComma(g_commission)+"원";
              $('.order_form_commission_price').text(fullCommission);
              $('.order_form_commission_contant').text("매당 500원");
            }
            else
            {
              if(g_ticketPrice == 0 && ticketCount > 0)
              {
                $('.order_form_commission_contant').text("수수료 없음");
              }
              else if(discountTicketPrice <= 0)
              {
                $('.order_form_commission_contant').text("수수료 없음");
              }
              else
              {
                $('.order_form_commission_contant').text("티켓 없음");
              }
            }
          };

          var setSupportInfo = function(){
            var supportPrice = $('#supportPrice').val();
            var formSupportContant = $('.order_form_support_contant');
            var formSupportPrice = $('.order_form_support_price');

            if(supportPrice == 0)
            {
              formSupportContant.text("추가 후원 없음");
            }
            else
            {
              formSupportPrice.text(addComma(supportPrice)+"원");
              g_supportPrice = Number(supportPrice);
            }
          };

          var setTotalPrice = function(){
            var totalPrice = getTitalPrice();
            totalPrice = addComma(totalPrice) + "원";

            $('.order_form_total_price').text(totalPrice);

            //버튼에 가격
            var submitBtn = "총 금액: "+totalPrice + " 결제 하기";

            if( $('#project_type').val() == "funding")
            {
              submitBtn = "총 금액: "+totalPrice + " 예약 하기";
            }

            $('#ticketing-btn-payment').text(submitBtn);

          };

          var getTitalPrice = function(){
            var totalPrice = g_ticketPrice - g_discoutPrice;
            //굿즈 가격 측정
            //alert(g_goodsArray.length);
            var totalGoodsPrice = 0;
            var totalGoodsDiscount = 0;
            for(var i = 0; i < g_goodsArray.length ; i++)
            {
              //totalPrice = totalPrice + g_goodsArray[i].price;
              totalGoodsPrice += g_goodsArray[i].price;
              if(g_ticketPrice > 0)
              {
                totalGoodsDiscount += g_goodsArray[i].ticketDiscount;
              }
            }

            totalPrice = totalPrice + totalGoodsPrice - totalGoodsDiscount;

            //후원추가
            totalPrice = totalPrice + g_supportPrice;
            //var supportPrice = $('#supportPrice').val();
            //총 가격에서 마지막 커미션을 넣어준다.
            totalPrice = totalPrice + g_commission;

            return totalPrice;
          };

          var isSubmit = false;

          $('#ticketing-btn-payment').click(function(){

            if(!$('#name').val())
            {
              alert("이름을 입력해주세요.");
              return;
            }

            if(!$('#phone').val())
            {
              alert("연락처를 입력해주세요.");
              return;
            }

            if(!$('#email').val())
            {
              alert("이메일을 입력해주세요.");
              return;
            }

            if(getTitalPrice() > 0)
            {
              //구매 가격이 있을때만 체크한다.
              if(!$('#order-card-number').val())
              {
                alert("카드 번호를 입력해주세요.");
                return;
              }

              if(!$('#expiry_month').val())
              {
                alert("유효 기간을 선택해주세요");
                return;
              }

              if(!$('#expiry_year').val())
              {
                alert("유효 기간을 선택해주세요");
                return;
              }

              if(!$('#order-birth').val())
              {
                alert("생년월일(법인등록번호)를 입력해주세요.");
                return;
              }

              if(!$('#order-card-password').val())
              {
                alert("카드 비밀번호 앞2자리를 입력해주세요.");
                return;
              }
              else{
                if(isNaN( $('#order-card-password').val() ) == true) {
  				            alert("비밀번호는 숫자만 입력 가능합니다.");
                      return;
  			        }
              }
            }

            if(!$('#refund_apply').is(":checked"))
            {
              alert("환불 정책에 동의 해주세요.");
              return;
            }

            if(!$('#policy_apply').is(":checked"))
            {
              alert("이용 약관에 동의 해주세요.");
              return;
            }

            if(isSubmit == false)
            {
              isSubmit = true;
              $('#ticketSubmitPayForm').submit();
            }
          });



          $('#placeReceive').bind('click', function () {
            if($('#placeReceive').is(":checked"))
            {
              $('.order_form_goods_address_container').hide();

              $('#order-address').val('');
              $('.postcodify_address').val('');
              $('.postcodify_details').val('');
              $('#order-comment').val('');
              //$''('.order_form_goods_address_container').children('input').val('aa');
            }
            else
            {
              $('.order_form_goods_address_container').show();
            }

          });

          var setNoPrice = function(){
            var isNoPrice = false;

            if( getTitalPrice() == 0 )
            {
              isNoPrice = true;
            }

            if(isNoPrice == false)
            {
              return;
            }

            $('#order_card_number_container').hide();
            $('#expiry_month_container').hide();
            $('#order-birth_container').hide();
            $('#card_password_container').hide();
          };

          setTicketInfo();//티켓정보를 먼저 입력해야 함. 티켓 가격을 설정해야 할인가가 나옴. 순서 바뀌면 안됨.
          setDiscountInfo();
          setGoodsInfo();
          setCommissionInfo();
          setSupportInfo();
          setTotalPrice();

          setNoPrice();

          if(g_isGetOrderForm)
          {
            //오더일 경우
            if(!$('.postcodify_postcode5').val())
            {
              $('.order_form_goods_address_container').hide();
              $('#placeReceive').prop("checked", true);
            }
          }

        });
    </script>
@endsection
