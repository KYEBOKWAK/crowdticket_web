<div id="default" role="tabpanel" class="tab-pane active">
	<h3>기본 정보 입력</h3>
	<h4>
		프로젝트의 기본정보를 입력하는 단계입니다. 입력 하신 후에는 변경할 수 없으니,
		<br/>
		모든 항복을 펀딩참여자와 미래의 관객들을 생각하여 신중하게 결정해 주세요!
	</h4>
	<div class="form-horizontal" data-toggle="validator" role="form">
		<div class="form-group">
			<label for="title" class="col-sm-2 control-label">공연제목</label>
			<div class="col-sm-8">
				<input id="title" name="title" maxlength="30" type="text" class="form-control" value="{{ $project->title }}" />
				<p class="help-block">
					'크라우드밴드의 2015 단독공연', '000 추모공연', '000 봄 전시회' 등
					<br/>
					직접적으로 공연을 나타낼 수 있는 제목도 좋고요
					<br/>
					추상적으로 공연의 느낌을 잘 드러낼 수 있는 모호한 느낌의 제목도 좋습니다.
					<br/>
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
					*가장 중요한 단계입니다.
					<br/>
					펀딩 목표 금액은 공연 기획에 필요한 최소 금액으로 책정하는 것이 좋아요
					<br/>
					목표가 명확하지 않거나, 금액이 너무 높을 때 크라우드 펀딩의 진행은
					<br/>
					생각보다 스트레스를 받는 일이 될 수도 있거든요.
					<br/>
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