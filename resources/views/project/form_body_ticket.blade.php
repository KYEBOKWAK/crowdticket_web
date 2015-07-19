<h3>펀딩 보상 입력</h3>
<h4> 펀딩에 참여한 감사한 분들에게 어떤 보상을 줄 지 고민해 보는 단계입니다.
<br/>
펀딩에 성공한 후 기획하게 될 공연의 티켓을 비롯하여 싸인CD, 머그컵, 티셔츠 등
<br/>
여러가지 보상품으로 좀 더 다채로운 펀딩을 기획해 보세요! </h4>
<ul id="ticket_list" class="list-group">
	@foreach ($project->tickets as $ticket)
	<li data-ticket-id="{{ $ticket->id }}" class="ticket list-group-item">
		<p>
			<span class="ticket-price">{{ $ticket->price }}</span><span>원 이상을 후원하시는 분께</span>
		</p>
		<p>
			@if ($ticket->real_ticket_count > 0)
			<span>티켓 </span>
			<span class="ticket-real-count">{{ $ticket->real_ticket_count }}</span>
			<span> + </span>
			@endif
			<span class="ticket-reward">{{ $ticket->reward }}</span>
		</p>
		<p>
			<span>보상 실행일 : </span><span class="ticket-delivery-date">{{ date('Y-m-d', strtotime($ticket->delivery_date)) }}</span>
		</p>
		<p>
			@if ($ticket->audiences_limit > 0)
			<span class="ticket-audiences-limit">제한 없음</span>
			@else
			<span class="ticket-audiences-limit">{{ $ticket->audiences_limit }}</span>
			<span>개 제한</span>
			@endif
			<span> / </span>
			<span class="ticket-audiences-count">{{ $ticket->audiences_count }}</span>
			<span>명이 선택 중</span>
		</p>
		@if ($ticket->audiences_count == 0)
		<p>
			<button class="btn btn-primary modify-ticket">
				수정
			</button>
			<button class="btn btn-primary delete-ticket">
				삭제
			</button>
		</p>
		@endif
		<input type="hidden" class="ticket-require-shipping" value="{{ $ticket->require_shipping }}" />
	</li>
	@endforeach
</ul>
<div class="form-horizontal" role="form">
	<div class="form-group">
		<label for="ticket_price" class="col-sm-2 control-label">최소 후원 금액</label>
		<div class="col-sm-8">
			<div class="input-group col-sm-4">
				<input id="ticket_price" name="price" type="number" class="form-control" />
				<div class="input-group-addon">
					원
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="ticket_real_count" class="col-sm-2 control-label">포함된 티켓</label>
		<div class="col-sm-8">
			<div class="input-group col-sm-4">
				<input id="ticket_real_count" name="real_ticket_count" type="number" class="form-control" />
				<div class="input-group-addon">
					매
				</div>
			</div>
			<p class="help-block">
				앞으로 기획할 공연의 티켓이 몇 매 포함되나요?
				<br/>
				펀딩 성공 후, 티켓판매 시 선판매된 티켓을 계산하기 위함입니다.
			</p>
		</div>
	</div>
	<div class="form-group">
		<label for="ticket_reward" class="col-sm-2 control-label">티켓 외 보상내용</label>
		<div class="col-sm-8">
			<textarea id="ticket_reward" name="reward" class="form-control" ></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2"></label>
		<div class="checkbox col-sm-8">
			<label>
				<input id="ticket_require_shipping" name="require_shipping" type="checkbox" value="" />
				보상품의 제공을 위해 후원자의 주소가 필요한가요? </label>
		</div>
	</div>
	<div class="form-group">
		<label for="ticket_audiences_limit" class="col-sm-2 control-label">수량 한정</label>
		<div class="col-sm-6">
			<div class="input-group">
				<div class="input-group-addon">
					본 보상을 선택하는 후원자를
				</div>
				<input id="ticket_audiences_limit" name="audiences_limit" type="number" class="form-control" />
				<div class="input-group-addon">
					명으로 제한합니다.
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="ticket_delivery_date" class="col-sm-2 control-label">보상 실행일</label>
		<div class="col-sm-2">
			<input id="ticket_delivery_date" name="delivery_date" type="text" class="form-control" />
		</div>
	</div>
	<span class="pull-right">
		<button id="cancel_modify_ticket" class="btn btn-default">
			취소하기
		</button>
		<button id="update_ticket" class="btn btn-success">
			수정하기
		</button>
		<button id="create_ticket" class="btn btn-success">
			추가하기
		</button> </span>
</div>
