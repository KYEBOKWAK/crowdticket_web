@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<ul role="tablist" class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#default" aria-controls="default" role="tab" data-toggle="tab">기본정보</a></li>
				<li role="presentation"><a href="#ticket" aria-controls="ticket" role="tab" data-toggle="tab">보상</a></li>
				<li role="presentation"><a href="#poster" aria-controls="poster" role="tab" data-toggle="tab">포스터</a></li>
				<li role="presentation"><a href="#story" aria-controls="story" role="tab" data-toggle="tab">스토리, 공연 소개</a></li>
				<li role="presentation"><a href="#creator" aria-controls="creator" role="tab" data-toggle="tab">기획자 소개</a></li>
			</ul>
			<div class="tab-content">
				<div id="default" role="tabpanel" class="tab-pane active">
					<h3>기본 정보 입력</h3>
					<h4>프로젝트의 기본정보를 입력하는 단계입니다. 입력 하신 후에는 변경할 수 없으니,<br/>모든 항복을 펀딩참여자와 미래의 관객들을 생각하여 신중하게 결정해 주세요!</h4>
					<div class="form-horizontal" data-toggle="validator" role="form">
						<div class="form-group">
							<label for="title" class="col-sm-2 control-label">공연제목</label>
							<div class="col-sm-8">
								<input id="title" name="title" maxlength="30" type="text" class="form-control" value="{{ $project->title }}" />
								<p class="help-block">
									'크라우드밴드의 2015 단독공연', '000 추모공연', '000 봄 전시회' 등<br/>
									직접적으로 공연을 나타낼 수 있는 제목도 좋고요<br/>
									추상적으로 공연의 느낌을 잘 드러낼 수 있는 모호한 느낌의 제목도 좋습니다.<br/>
									진행하고자 하는 프로젝트를 한마디로 설명할 수 있도록 자유롭고 독창적으로 표현해보세요!
								</p>
							</div>
						</div>
						<div class="form-group">
							<label for="category" class="col-sm-2 control-label">분류</label>
							<div class="col-sm-2">
								<select id="category" name="category" class="form-control">
									@foreach($categories as $category)
										@if ($category->id === $project->category_id)
											<option value="{{ $category->id }}" selected>{{ $category->title }}</option>
										@else
											<option value="{{ $category->id }}">{{ $category->title }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="city" class="col-sm-2 control-label">장소</label>
							<div class="col-sm-2">
								<select id="city" name="city" class="form-control">
									@foreach($cities as $city)
										@if ($city->id === $project->city_id)
											<option value="{{ $city->id }}" selected>{{ $city->name }}</option>
										@else
											<option value="{{ $city->id }}">{{ $city->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="alias" class="col-sm-2 control-label">페이지주소</label>
							<div class="col-sm-8 form-inline">
								<div class="input-group">
									<div class="input-group-addon">http://crowdticket.kr/projects/</div>
									<input id="alias" name="alias" type="text" class="form-control" value="{{ $project->alias }}" />
								</div>
								<button id="check_alias" class="btn btn-primary">중복검사</button>
								<p class="help-block">사람들에게 펀딩을 홍보할 때 사용하게 될 URL을 직접 입력해보세요!</p>
							</div>
						</div>
						<div class="form-group">
							<label for="pledged_amount" class="col-sm-2 control-label">목표금액</label>
							<div class="col-sm-8">
								<div class="input-group col-sm-4">
									<input id="pledged_amount" name="pledged_amount" type="number" class="form-control" value="{{ $project->pledged_amount }}" />
									<div class="input-group-addon">원</div>
								</div>
								<p class="help-block">
									*가장 중요한 단계입니다.<br/>
									펀딩 목표 금액은 공연 기획에 필요한 최소 금액으로 책정하는 것이 좋아요<br/>
									목표가 명확하지 않거나, 금액이 너무 높을 때 크라우드 펀딩의 진행은<br/>
									생각보다 스트레스를 받는 일이 될 수도 있거든요.<br/>
									달성할 수 있을 만큼, 그러나 공연 기획에는 꼭 필요한 금액을 산정하여 입력해주세요!
								</p>
							</div>
						</div>
						<div class="form-group">
							<label for="funding_closing_at" class="col-sm-2 control-label">펀딩 마감일</label>
							<div class="col-sm-2">
								<input id="funding_closing_at" name="funding_closing_at" type="text" class="form-control" value="{{ date('Y-m-d', strtotime($project->funding_closing_at)) }}" />
							</div>
						</div>
					</div>
					<button id="update_default" class="btn btn-success pull-right">저장하기</button>
				</div>
				<div id="ticket" role="tabpanel" class="tab-pane">
					<h3>펀딩 보상 입력</h3>
					<h4>
						펀딩에 참여한 감사한 분들에게 어떤 보상을 줄 지 고민해 보는 단계입니다.<br/>
						펀딩에 성공한 후 기획하게 될 공연의 티켓을 비롯하여 싸인CD, 머그컵, 티셔츠 등 <br/>
						여러가지 보상품으로 좀 더 다채로운 펀딩을 기획해 보세요!
					</h4>
					<ul id="ticket_list" class="list-group">
						@foreach ($project->tickets as $ticket)
							<li data-ticket-id="{{ $ticket->id }}" class="ticket list-group-item">
								<p><span class="ticket-price">{{ $ticket->price }}</span><span>원 이상을 후원하시는 분께</span></p>
								<p>
									@if ($ticket->real_ticket_count > 0)
										<span>티켓 </span>
										<span class="ticket-real-count">{{ $ticket->real_ticket_count }}</span>
										<span> + </span>
									@endif
									<span class="ticket-reward">{{ $ticket->reward }}</span>
								</p>
								<p><span>보상 실행일 : </span><span class="ticket-delivery-date">{{ date('Y-m-d', strtotime($ticket->delivery_date)) }}</span></p>
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
										<button class="btn btn-primary modify-ticket">수정</button>
										<button class="btn btn-primary delete-ticket">삭제</button>
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
									<div class="input-group-addon">원</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="ticket_real_count" class="col-sm-2 control-label">포함된 티켓</label>
							<div class="col-sm-8">
								<div class="input-group col-sm-4">
									<input id="ticket_real_count" name="real_ticket_count" type="number" class="form-control" />
									<div class="input-group-addon">매</div>
								</div>
								<p class="help-block">
									앞으로 기획할 공연의 티켓이 몇 매 포함되나요?<br/>
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
									보상품의 제공을 위해 후원자의 주소가 필요한가요?
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="ticket_audiences_limit" class="col-sm-2 control-label">수량 한정</label>
							<div class="col-sm-6">
								<div class="input-group">
									<div class="input-group-addon">본 보상을 선택하는 후원자를</div>
									<input id="ticket_audiences_limit" name="audiences_limit" type="number" class="form-control" />
									<div class="input-group-addon">명으로 제한합니다.</div>
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
							<button id="cancel_modify_ticket" class="btn btn-default">취소하기</button>
							<button id="update_ticket" class="btn btn-success">수정하기</button>
							<button id="create_ticket" class="btn btn-success">추가하기</button>
						</span>
					</div>
				</div>
				<div id="poster" role="tabpanel" class="tab-pane">
					<h3>포스터 만들기</h3>
					<h4>CROWDTICKET에 붙여 놓을 여러분의 공연포스터를 만들어보세요!<br/>멋진 이미지로 더 많은 사람들의 주목을 받을 수 있습니다.</h4>
				</div>
				<div id="story" role="tabpanel" class="tab-pane">
					<h3>스토리 작성</h3>
					<h4>여러분이 펀딩을 받고 공연을 기획하고자 하는 이야기가 무엇인가요?<br/>담백하고 진정성 있는 이야기를 들려주세요.</h4>
				</div>
				<div id="creator" role="tabpanel" class="tab-pane"></div>
			</div>
			<input type="hidden" id="project_id" value="{{ $project->id }}" />
		</div>
		<div class="col-md-3">
			<a href="{{ url('/projects/') }}/{{ $project->id }}" class="btn btn-success" target="_blank">미리보기</a>
			<button class="btn btn-primary">제출하기</button>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/template" id="template_ticket">
	<li data-ticket-id="<%= ticket.id %>" class="ticket list-group-item">
		<p><span class="ticket-price"><%= ticket.price %></span><span>원 이상을 후원하시는 분께</span></p>
		<p>
			<% if (ticket.real_ticket_count > 0) { %>
				<span>티켓 </span>
				<span class="ticket-real-count"><%= ticket.real_ticket_count %></span>
				<span> + </span>
			<% } %>
			<span class="ticket-reward"><%= ticket.reward %></span>
		</p>
		<p><span>보상 실행일 : </span><span class="ticket-delivery-date"><%= ticket.delivery_date %></span></p>
		<p>
			<% if (ticket.audiences_limit > 0) { %>
				<span class="ticket-audiences-limit">제한 없음</span>
			<% } else { %>
				<span class="ticket-audiences-limit"><%= ticket.audiences_limit %></span>
				<span>개 제한</span>
			<% } %>
			<span> / </span>
			<span class="ticket-audiences-count">0</span>
			<span>명이 선택 중</span>
		</p>
		<p>
			<button class="btn btn-primary modify-ticket">수정</button>
			<button class="btn btn-primary delete-ticket">삭제</button>
		</p>
		<input type="hidden" class="ticket-require-shipping" value="<%= ticket.require_shipping %>" />
	</li>
</script>
<script src="{{ asset('/script/project/form.js') }}"></script>
@endsection
