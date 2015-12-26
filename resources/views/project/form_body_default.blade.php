<div class="row">
	<img src="{{ asset('/img/app/img_update_project_base.png') }}" class="center-block" />
	<h2>기본 정보 입력</h2>
	<div class="col-md-12">
		<h5 class="bg-info">입력하신 후에는 변경할 수 없으니, 신중히 고민하신 후 입력하시기 바랍니다 :)</h5>
	</div>
	<div class="form-horizontal" data-toggle="validator" role="form">
		<div class="form-group">
			<label for="title" class="col-sm-2 control-label">공연제목</label>
			<div class="col-sm-8">
				<input id="title" name="title" maxlength="30" type="text" class="form-control" value="{{ $project->title }}" />
				<p class="help-block">
					'00밴드의 단독공연' 등 직접적으로 공연을 나타낼 수 있는 제목도 좋고요, <br/>
					추상적으로 공연의 느낌을 잘 드러낼 수 있는 모호한 느낌의 제목도 좋습니다. <br/>
					진행하고자 하는 프로젝트를 한마디로 설명할 수 있도록 자유롭고 독창적으로 표현해보세요!
				</p>
			</div>
		</div>
		<div class="form-group">
			<label for="category" class="col-sm-2 control-label">분류</label>
			<div class="col-sm-2">
				<select id="category" name="category" class="form-control">
					@foreach ($categories as $category)
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
			<label for="city" class="col-sm-2 control-label">지역</label>
			<div class="col-sm-2">
				<select id="city" name="city" class="form-control">
					@foreach ($cities as $city)
					@if ($city->id === $project->city_id)
					<option value="{{ $city->id }}" selected>{{ $city->name }}</option>
					@else
					<option value="{{ $city->id }}">{{ $city->name }}</option>
					@endif
					@endforeach
				</select>
			</div>
		</div>
		@if ($project->type === 'sale')
		<div class="form-group">
			<label for="stage" class="col-sm-2 control-label">공연장</label>
			<div class="col-sm-2">
				<input id="concert_hall" name="concert_hall" maxlength="16" type="text" placeholder="공연장 이름 입력" class="form-control" value="{{ $project->concert_hall }}" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-8">
				<input id="detailed_address" name="detailed_address" maxlength="128" type="text" placeholder="세부 주소 입력" class="form-control" value="{{ $project->detailed_address }}" />
			</div>
		</div>
		@endif
		<div class="form-group">
			<label for="alias" class="col-sm-2 control-label">페이지주소</label>
			<div class="col-sm-8 form-inline">
				<div class="input-group">
					<div class="input-group-addon">{{ url('/projects') }}</div>
					<input id="alias" name="alias" type="text" class="form-control" value="{{ $project->alias }}" />
				</div>
				<button id="check_alias" class="btn btn-default">
					중복검사
				</button>
				<p class="help-block">
					주변 사람들에게 펀딩을 홍보할 때 사용하게 될 URL을 직접 입력해보세요! <br/>
					32자 이내 영문, 숫자, -, _만 입력이 가능합니다. <br/>
					첫 글자는 영문으로 시작해야 합니다.
				</p>
			</div>
		</div>
		<div class="form-group">
			<label for="pledged_amount" class="col-sm-2 control-label">목표금액</label>
			<div class="col-sm-8">
				<div class="input-group col-sm-4">
					<input id="pledged_amount" name="pledged_amount" type="number" class="form-control" value="{{ $project->pledged_amount }}" />
					<div class="input-group-addon">
						원
					</div>
				</div>
				<p class="help-block">
					*가장 중요한 단계입니다. <br/>
					펀딩 목표 금액은 공연 기획에 필요한 최소 금액으로 책정하는 것이 좋아요 <br/>
					목표가 명확하지 않거나, 금액이 너무 높을 때 크라우드 펀딩의 진행은 생각보다 스트레스를 받는 일이 될 수도 있거든요. <br/>
					달성할 수 있을 만큼의 금액을 산정하여 입력해주세요!
				</p>
			</div>
		</div>
		<div class="form-group">
			<label for="funding_closing_at" class="col-sm-2 control-label">@if ($project->type === 'funding') 펀딩 마감일 @else 티켓팅 마감일 @endif</label>
			<div class="col-sm-2">
				<input id="funding_closing_at" name="funding_closing_at" type="text" class="form-control" value="{{ $project->getFundingClosingAtOrNow() }}" />
			</div>
		</div>
	</div>
	<button id="update_default" class="btn btn-success center-block">저장하기</button>
</div>
