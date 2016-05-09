@extends('app')

@section('css')
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
		font-size: 14px;
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
</style>
@endsection

@section('content')
<div class="container first-container">
	@if ($order)
		@include ('order.header', ['project' => $project, 'step' => 0])
	@else
		@include ('order.header', ['project' => $project, 'step' => 2])
	@endif
	
	@if ($order)
	<form class="row form-horizontal" data-toggle="validator" role="form" action="{{ url('/orders/') }}/{{ $order->id }}/" method="post">
	@include('form_method_spoofing', ['method' => 'delete'])
	@else
	<form class="row form-horizontal" data-toggle="validator" role="form" action="{{ url('/tickets/') }}/{{ $ticket->id }}/orders" method="post">
	@include('csrf_field')
	@endif
	
		@if ($project->type === 'funding')
		<h4 class="col-md-12 ps-section-title">선택한 보상</h4>
		@else
		<h4 class="col-md-12 ps-section-title">선택한 티켓</h4>
		@endif
		<div class="ticket order col-md-12">
			<div class="ticket-wrapper">
				<div class="ticket-body row display-table">
					@if ($project->type === 'funding')
					<div class="col-md-3 display-cell text-right">
						<span><strong class="text-primary ticket-price">{{ $ticket->price }}</strong> 원 이상</span>
					</div>
					<div class="col-md-9 display-cell">
						<p class="ticket-reward">{{ $ticket->reward }}</p>
						@if ($ticket->real_ticket_count > 0)
						<span class="ticket-real-count">
							<img src="{{ asset('/img/app/ico_ticket2.png') }}" />
							{{ $ticket->real_ticket_count }}매
						</span>
						@endif
						<span class="ticket-delivery-date">예상 실행일 : {{ date('Y년 m월 d일', strtotime($ticket->delivery_date)) }}</span>
					</div>
					@else
					<div class="col-md-3 display-cell">
						<span>
							<span class="text-primary">공연일시</span><br/> 
							<strong class="ps-strong-small">{{ date('Y.m.d H:m', strtotime($ticket->delivery_date)) }}</strong>
							<span class="pull-right">{{ $ticket->price }} 원</span>
						</span>
					</div>
					<div class="col-md-9 display-cell">
						<p class="ticket-reward ps-no-margin">{{ $ticket->reward }}</p>
					</div>
					@endif
				</div>
			</div>
		</div>
		
		@if ($request_price > 0)
		<h4 class="col-md-12 ps-section-title">결제정보</h4>
		<div class="col-md-12">
			<?php
				$orderPrice = $request_price * $ticket_count;
				$commission = $ticket->real_ticket_count * $ticket_count * 500;
				$totalPrice = $orderPrice + $commission;
			?>
			<div class="ps-box">
				<div class="form-group">
					<label for="order-price" class="col-sm-2 control-label">상품금액</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="hidden" name="ticket_count" value="{{ $ticket_count }}" />
							<input type="hidden" name="request_price" value="{{ $request_price }}" />
							<input id="order-price" type="text" readonly="readonly" class="form-control text-right" value="{{ $orderPrice }}" />
							<div class="input-group-addon">
								원
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">티켓 수수료</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" readonly="readonly" class="form-control text-right" value="{{ $commission }}" />
							<div class="input-group-addon">
								원
							</div>
						</div>
						<p class="help-block text-right">
							1매 500원 X {{ $ticket->real_ticket_count * $ticket_count }}매 = {{ $commission }}원
						</p>
					</div>
					<div class="col-sm-4">
						*티켓 발급 및 알림, 플랫폼 유지를 위해<br/>필요한 최소한의 수수료만을 받고 있습니다.
					</div>
					<label class="col-sm-4 control-label commission-label">
					</label>
				</div>
				<div class="form-group total-price">
					<label class="col-sm-2 control-label">결제금액</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" readonly="readonly" class="form-control text-right" value="{{ $totalPrice }}" />
							<div class="input-group-addon">
								원
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">결제수단</label>
					<div class="col-sm-8">
						<p class="ps-form-control-like">
							크라우드티켓 Beta에서는 무통장 입금만 가능합니다.<br/>
							곧 편리한 결제시스템으로 여러분을 찾아 뵙겠습니다.<br/><br/>
							<strong>
								[입금정보]<br/>
								은행 : 우리은행<br/>
								계좌번호 : 1005-002-918436<br/>
								예금주 : 신효준(나인에이엠)
							</strong>
						</p>
					</div>
				</div>
				<div class="form-group">
					<label for="order-account-name" class="col-sm-2 control-label">입금자성명</label>
					<div class="col-sm-10">
						@if ($order)
						<input id="order-account-name" name="account_name" type="text" class="form-control" value="{{ $order->account_name }}" readonly="readonly" />
						@else
						<input id="order-account-name" name="account_name" type="text" class="form-control" value="{{ \Auth::user()->name }}" required="required" />
						@endif
						<p class="help-block">
							입력한 이름과 동일한 이름으로 입금되지 않을 경우 입금확인이 안될 수 있습니다.<br/>
							"입금 시 상대방의 계좌에 표시될 이름"을 정확히 입력해주세요.
						</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">유의사항</label>
					<div class="col-sm-8">
						<p class="ps-form-control-like text-danger">
							1. 입금이 확인되면 SMS로 결제내역을 알려드립니다! :)<br/>
							2. 입금 확인 후 업무시간 24시간 이내에 펀딩 및 티켓 구매에 반영됩니다.<br/>
							3. 입금 정보는 오른쪽 상단 '결제확인'에서 확인하실 수 있고, 주문 취소도 가능합니다.<br/>
							4. 입금 후 환불 문의 : 070-8819-4308 크라우드티켓 담당자
						</p>
					</div>
				</div>
			</div>
		</div>
		@else
		<input type="hidden" name="ticket_count" value="{{ $ticket_count }}" />
		<input id="order-price" name="request_price" type="hidden" readonly="readonly" class="form-control" value="{{ $request_price }}" />
		<input id="order-account-name" name="account_name" type="hidden" class="form-control" value="{{ \Auth::user()->name }}" readonly="readonly" />
		@endif
		
		<h4 class="col-md-12 ps-section-title">수령정보</h4>
		<div class="col-md-12">
			<div class="ps-box">
				<div class="form-group">
					<label for="order-name" class="col-sm-2 control-label">이름</label>
					<div class="col-sm-2">
						@if ($order)
						<input id="order-name" name="name" type="text" class="form-control" value="{{ $order->name }}" readonly="readonly" />
						@else
						<input id="order-name" name="name" type="text" class="form-control" value="{{ \Auth::user()->name }}" required="required" />
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="order-contact" class="col-sm-2 control-label">휴대폰번호</label>
					<div class="col-sm-2">
						@if ($order)
						<input id="order-contact" name="contact" type="text" class="form-control" value="{{ $order->contact }}" readonly="readonly" />
						@else
						<input id="order-contact" name="contact" type="text" class="form-control" value="{{ \Auth::user()->contact }}" required="required" />
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="order-email" class="col-sm-2 control-label">이메일</label>
					<div class="col-sm-4">
						@if ($order)
						<input id="order-email" name="email" type="email" class="form-control" value="{{ $order->email }}" readonly="readonly" />
						@else
						<input id="order-email" name="email" type="email" class="form-control" value="{{ \Auth::user()->email }}" required="required" />
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
				@if ($ticket->require_shipping)
				<div class="form-group">
					<label for="order-address" class="col-sm-2 control-label">주소</label>
					<div class="col-sm-2">
						@if ($order)
						<input id="order-address" name="postcode" type="text" class="form-control postcodify_postcode5"  readonly="readonly" placeholder="우편번호" value="{{ $order->postcode }}" />
						@else
						<input id="order-address" name="postcode" type="text" class="form-control postcodify_postcode5" required="required" readonly="readonly" placeholder="우편번호" />
						@endif
					</div>
					<div class="col-sm-2">
						@if (!$order)
						<a href="#" id="postcodify_search_button" style="display: none;">검색</a>
						<a href="#" class="btn btn-default" id="postcodify_search_button_fake" >검색</a>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-6 col-sm-offset-2">
						@if ($order)
						<input type="text" name="address_main" class="form-control postcodify_address" readonly="readonly" value="{{ $order->address_main }}" />
						@else
						<input type="text" name="address_main" class="form-control postcodify_address" required="required" readonly="readonly" placeholder="주소를 검색해주세요" />
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-6 col-sm-offset-2">
						@if ($order)
						<input type="text" name="address_detail" class="form-control postcodify_details" readonly="readonly" value="{{ $order->address_detail }}" />
						@else
						<input type="text" name="address_detail" class="form-control postcodify_details" required="required" placeholder="상세주소를 입력해주세요" />
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="order-comment" class="col-sm-2 control-label">비고</label>
					<div class="col-sm-8">
						@if ($order)
						<input id="order-comment" name="requirement" type="text" class="form-control" readonly="readonly" value="{{ $order->requirement }}" />
						@else
						<input id="order-comment" name="requirement" type="text" class="form-control" placeholder="보상품 세부사항 및 기타 요청 사항" />
						@endif
					</div>
				</div>
				@endif
			</div>
		</div>
		
		@if ($request_price > 0 && $project->type === 'funding')
		<h4 class="col-md-12 ps-section-title">환불계좌정보 <span>펀딩 마감일까지 목표한 금액이 모이지 않으면 결제하신 금액은 전액 환불됩니다.</span></h4>
		<div class="col-md-12">
			<div class="ps-box">
				<div class="form-group">
					<label for="order-refund-name" class="col-sm-2 control-label">예금주</label>
					<div class="col-sm-2">
						@if ($order)
						<input id="order-refund-name" name="refund_name" type="text" class="form-control" readonly="readonly" value="{{ $order->refund_name }}" />
						@else
						<input id="order-refund-name" name="refund_name" type="text" class="form-control" value="{{ \Auth::user()->name }}" required="required" />
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="order-refund-bank" class="col-sm-2 control-label">은행명</label>
					<div class="col-sm-2">
						@if ($order)
						<input id="order-refund-bank" name="refund_bank" type="text" class="form-control" readonly="readonly" value="{{ $order->refund_bank }}" />
						@else
						<input id="order-refund-bank" name="refund_bank" type="text" class="form-control" required="required"  />
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="order-refund-account" class="col-sm-2 control-label">계좌번호</label>
					<div class="col-sm-4">
						@if ($order)
						<input id="order-refund-account" name="refund_account" type="text" class="form-control" readonly="readonly" value="{{ $order->refund_account }}" />
						@else
						<input id="order-refund-account" name="refund_account" type="text" class="form-control" placeholder="-를 제외하고 입력해주세요" required="required"  />
						@endif
					</div>
				</div>
				@if (!$order)
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-8">
						<p class="ps-form-control-like text-danger">
							운영진에서 회원님이 입금하신 금액만큼 환불하기 위한 정보입니다.<br/>
							정확하게 입력하셨는지, 한번 더 확인해 주세요!
						</p>
					</div>
				</div>
				@endif
			</div>
		</div>
		@else
		<input id="order-refund-name" name="refund_name" type="hidden" class="form-control" value="{{ \Auth::user()->name }}" required="required" />
		<input id="order-refund-bank" name="refund_bank" type="hidden" class="form-control" readonly="readonly" value=" " />
		<input id="order-refund-account" name="refund_account" type="hidden" class="form-control" value=" " required="required"  />
		@endif
		
		@if (!$order)
		<h4 class="col-md-12 ps-section-title">약관 동의</h4>
		<div class="col-md-12">
			<div class="ps-box">
				<div class="form-group">
					<label class="col-sm-10 col-sm-offset-1">크라우드티켓 이용약관</label>
					<div class="col-sm-10 col-sm-offset-1">
						<p class="scroll-box">@include ('helper.terms_content')</p>
						<div class="checkbox pull-right">
							<label>
								<input type="checkbox" name="approval1" required="required" />동의합니다
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-10 col-sm-offset-1">배송 및 결제 관련 제3자 정보제공 동의</label>
					<div class="col-sm-10 col-sm-offset-1">
						<p class="scroll-box">@include ('helper.privacy_content')</p>
						<div class="checkbox pull-right">
							<label>
								<input type="checkbox" name="approval2" required="required" />동의합니다
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		
		<div class="col-md-12 text-center">
			@if ($order)
				@if ($order->deleted_at)
					@if ($order->confirmed)
					<button class="btn btn-muted">환불처리중</button>
					@else
					<button class="btn btn-muted">취소됨</button>
					@endif
				@else
					@if ($order->confirmed)
					<button class="btn btn-danger">환불하기</button>
					@else
					<button class="btn btn-danger">취소하기</button>
					@endif
				@endif
			@else
			<button class="btn btn-success">결제하기</button>
			@endif
		</div>
	</form>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/postcodify.js') }}"></script>
<script>
	$(document).ready(function() {
		$("#postcodify_search_button").postcodifyPopUp();
		$('#postcodify_search_button_fake').bind('click', function() {
			$('#postcodify_search_button').trigger('click');
			return false;
		});
		$('.btn-muted').each(function() {
			$(this).bind('click', function() {
				return false;
			});
		});
		$('.btn-danger').each(function() {
			$(this).bind('click', function() {
				var form = $(this).closest('form');
				return confirm('정말 취소하시겠습니까?');
			});
		});
	});
</script>
@endsection
