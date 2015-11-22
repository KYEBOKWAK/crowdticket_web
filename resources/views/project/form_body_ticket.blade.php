<div class="row">
	<img src="{{ asset('/img/app/img_update_project_reward.png') }}" class="center-block" />
	<h2>펀딩 보상 입력</h2>
	<div class="col-md-12">
		<h5 class="bg-info">펀딩에 성공한 후 기획하게 될 공연의 티켓을 비롯하여, 싸인CD, 머그컵, 티셔츠 등
		<br/>
		여러가지 보상품으로 좀 더 다채로운 펀딩을 기획해 보세요!</h5>
	</div>
</div>
<input type="hidden" id="tickets_json" value="{{ $project->tickets }}" />
<div id="ticket_list" class="row"></div>
<div class="row">
	<div class="form-horizontal" role="form">
		<div class="form-group">
			<label for="ticket_price" class="col-sm-2 control-label">최소 후원 금액</label>
			<div class="col-sm-8">
				<div class="input-group col-sm-4">
					<input id="ticket_price" name="price" type="number" class="form-control" min="0" value="0" />
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
		<div class="form-group">
			<label for="ticket_reward" class="col-sm-2 control-label">티켓 외 보상내용</label>
			<div class="col-sm-8">
				<textarea id="ticket_reward" name="reward" class="form-control" ></textarea>
				<label class="help-block">
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
					<input id="ticket_audiences_limit" name="audiences_limit" type="number" class="form-control" min="0" value="0" />
					<div class="input-group-addon">
						명으로 제한합니다.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="ticket_delivery_date" class="col-sm-2 control-label">예상 보상 실행일</label>
			<div class="col-sm-2">
				<input id="ticket_delivery_date" name="delivery_date" type="text" class="form-control" value="{{ date('Y-m-d', time()) }}" />
			</div>
		</div>
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
