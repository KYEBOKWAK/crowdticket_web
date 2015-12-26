<div class="row">
	@if ($project->type === 'funding')
	<img src="{{ asset('/img/app/img_update_project_reward.png') }}" class="center-block" />
	<h2>펀딩 보상 입력</h2>
	@else
	<img src="{{ asset('/img/app/img_update_project_ticket.png') }}" class="center-block" />
	<h2>티켓 설정</h2>
	@endif
	<div class="col-md-12">
		@if ($project->type === 'funding')
		<h5 class="bg-info">펀딩에 성공한 후 기획하게 될 공연의 티켓을 비롯하여, 싸인CD, 머그컵, 티셔츠 등
		<br/>
		여러가지 보상품으로 좀 더 다채로운 펀딩을 기획해 보세요!
		<br/><br/>
		<span class="text-danger">한명이라도 선택한 보상은 수정할 수 없습니다.</span>
		</h5>
		@else
		<h5 class="bg-info">날짜별, 가격별 공연 티켓을 자유롭게 기획하여 판매해 보세요!
		<br/><br/>
		<span class="text-danger">한명이라도 선택한 티켓은 수정할 수 없습니다.</span>
		</h5>
		@endif
	</div>
</div>
<input type="hidden" id="project_type" value="{{ $project->type }}" />
<input type="hidden" id="tickets_json" value="{{ $project->tickets }}" />
<div id="ticket_list" class="row"></div>
<div class="row">
	<div class="form-horizontal" role="form">
		@if ($project->type === 'sale')
		<div class="form-group">
			<label for="ticket_delivery_date" class="col-sm-2 control-label">공연일시</label>
			<div class="col-sm-2">
				<input id="ticket_delivery_date" name="delivery_date" type="text" class="form-control" value="{{ date('Y-m-d', time()) }}" />
			</div>
			<div class="col-sm-2">
				<select id="ticket_delivery_hour" class="form-control">
					@for ($i = 1; $i < 25; $i++)
					<option value="{{ $i }}">{{ $i }} 시</option>
					@endfor
				</select>
			</div>
			<div class="col-sm-2">
				<select id="ticket_delivery_min" class="form-control">
					@for ($i = 0; $i < 60; $i = $i + 5)
					<option value="{{ $i }}">{{ $i }} 분</option>
					@endfor
				</select>
			</div>
		</div>
		@endif
		<div class="form-group">
			@if ($project->type === 'funding')
			<label for="ticket_price" class="col-sm-2 control-label">최소 후원 금액</label>
			@else
			<label for="ticket_price" class="col-sm-2 control-label">가격</label>
			@endif
			<div class="col-sm-2">
				<div class="input-group">
					<input id="ticket_price" name="price" type="number" class="form-control" min="0" value="0" />
					<div class="input-group-addon">
						원
					</div>
				</div>
			</div>
		</div>
		@if ($project->type === 'funding')
		<div class="form-group">
			<label for="ticket_real_count" class="col-sm-2 control-label">포함된 티켓</label>
			<div class="col-sm-10">
				<div class="input-group ps-col-width-17p2 col-sm-2">
					<input id="ticket_real_count" name="real_ticket_count" type="number" class="form-control" min="0" value="0" />
					<div class="input-group-addon">
						매
					</div>
				</div>
				<p class="help-block">본 보상에 앞으로 기획할 공연의 티켓이 몇 매 포함되나요?
					<br/>
					포함되지 않는다면 숫자 '0'을 입력해 주세요.
				</p>
			</div>
		</div>
		@endif
		<div class="form-group">
			@if ($project->type === 'funding')
			<label for="ticket_reward" class="col-sm-2 control-label">티켓 외 보상내용</label>
			@else
			<label for="ticket_reward" class="col-sm-2 control-label">티켓팅 관련 공지</label>
			@endif
			<div class="col-sm-8">
				<textarea id="ticket_reward" name="reward" class="form-control" ></textarea>
				<label class="help-block">
					@if ($project->type === 'funding')
					<input id="ticket_require_shipping" name="require_shipping" type="checkbox" value="" />보상품의 제공을 위해 후원자의 주소가 필요한가요?
					@else
					티켓을 구매하는 관객들에게 전달해야 하는 메시지를 적어주세요
					@endif
				</label>
			</div>
		</div>
		<div class="form-group">
			<label for="ticket_audiences_limit" class="col-sm-2 control-label">수량 한정</label>
			<div @if ($project->type === 'funding') class="col-sm-6" @else class="col-sm-4" @endif>
				<div class="input-group">
					<div class="input-group-addon">
						@if ($project->type === 'funding')
						본 보상을 선택하는 후원자를
						@else
						본 티켓을
						@endif
					</div>
					<input id="ticket_audiences_limit" name="audiences_limit" type="number" class="form-control" @if ($project->type === 'funding') min="0" value="0" @else min="1" value="1" @endif />
					<div class="input-group-addon">
						@if ($project->type === 'funding')
						명으로 제한합니다.
						@else
						매로 제한합니다.
						@endif
					</div>
				</div>
				@if ($project->type === 'sale')
				<p class="help-block">
					최소 제한 매수는 1매입니다
				</p>
				@endif
			</div>
		</div>
		@if ($project->type === 'funding')
		<div class="form-group">
			<label for="ticket_delivery_date" class="col-sm-2 control-label">예상 보상 실행일</label>
			<div class="col-sm-2">
				<input id="ticket_delivery_date" name="delivery_date" type="text" class="form-control" value="{{ date('Y-m-d', time()) }}" />
			</div>
		</div>
		@endif
		<div class="col-dm-12 text-center">
			<button id="cancel_modify_ticket" class="btn btn-default">
				취소하기
			</button>
			<button id="update_ticket" class="btn btn-success">
				수정하기
			</button>
			<button id="create_ticket" class="btn btn-success">
				추가하기
			</button>
		</div>
	</div>
</div>
