<div class="form-body-default-container">
  <img src="{{ asset('/img/app/img_update_project_base.png') }}" class="center-block"/>
  <h2>기본 정보 입력</h2>
  <div class="project-form-subtitle">
      <h5>제출한 후에는 변경할 수 없으니, 신중히 고민하신 후 입력해 주세요.</h5>
  </div>
  <div class="project-form-content-grid">
    <p class="project-form-content-title">프로젝트 제목</p>
    <div class="project-form-content">
        <input id="title" name="title" maxlength="30" type="text" class="project-form-input"
               value="{{ $project->title }}" @if ($project->isPublic()) readonly="readonly" @endif />
        <p class="project-form-help">
            '00밴드의 단독공연' 등 직접적으로 공연을 나타낼 수 있는 제목도 좋고요, <br/>
            추상적으로 공연의 느낌을 잘 드러낼 수 있는 모호한 느낌의 제목도 좋습니다. <br/>
            진행하고자 하는 프로젝트를 한마디로 설명할 수 있도록 자유롭고 독창적으로 표현해보세요!
        </p>
    </div>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">분류</p>
    <div class="project-form-content">
        <select id="category" name="category" class="project-form-input project-form-input-category"
                @if ($project->isPublic()) readonly="readonly" @endif>
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
  <div class="project-form-content-grid">
    <p class="project-form-content-title">태그</p>
    <div class="form_body_default_tag_container_grid">
        <div class="form_body_default_tag_input_container_grid">
          <p>#</p><input id="hash_tag1" name="hash_tag1" maxlength="30" type="text" class="project-form-input project-form-input-tag"
             value="{{ $project->hash_tag1 }}" @if ($project->isPublic()) readonly="readonly" @endif />
        </div>

        <div class="form_body_default_tag_input_container_grid">
          <p>#</p><input id="hash_tag2" name="hash_tag2" maxlength="30" type="text" class="project-form-input"
              value="{{ $project->hash_tag2 }}" @if ($project->isPublic()) readonly="readonly" @endif />
        </div>
    </div>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">지역</p>
    @if($project->concert_hall === 'none')
    <div class="form_body_default_no_city_container_grid">
      <input id="title" name="title" type="text" class="project-form-input"
          value="" placeholder="대략적으로 계획 중인 장소를 적어 주세요." @if ($project->isPublic()) readonly="readonly" @endif />
    </div>
    @else
    <div class="form_body_default_city_container_grid">
        <select id="city" name="city" class="project-form-input project-form-input-category"
                @if ($project->isPublic()) readonly="readonly" @endif>
            @foreach ($cities as $city)
                @if ($city->id === $project->city_id)
                    <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                @else
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endif
            @endforeach
        </select>
        <input id="concert_hall" name="concert_hall" maxlength="30" type="text" class="project-form-input"
            value="{{ $project->concert_hall }}" placeholder="공연장 / 장소 명" @if ($project->isPublic()) readonly="readonly" @endif />
        <input id="detailed_address" name="detailed_address" type="text" class="project-form-input"
            value="{{ $project->detailed_address }}" placeholder="상세 주소를 입력해주세요" @if ($project->isPublic()) readonly="readonly" @endif />
    </div>
    @endif
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">페이지주소</p>
    <div class="project-form-content">
        <div class="input-group">
            <div class="input-group-addon">{{ url('/projects') }}/</div>
            <input id="alias" name="alias" type="text" class="project-form-input project-form-input-newURL" value="{{ $project->alias }}"
                   @if ($project->isPublic()) readonly="readonly" @endif />
        </div>
        <button id="check_alias" class="btn btn-default">
            중복검사
        </button>
        <p class="project-form-help">
            주변 사람들에게 펀딩을 홍보할 때 사용하게 될 URL을 직접 입력해보세요! <br/>
            32자 이내 영문, 숫자, -, _만 입력이 가능합니다. <br/>
            첫 글자는 영문으로 시작해야 합니다.
        </p>
    </div>
  </div>

  @if($project->type === 'funding')
  <div class="project-form-content-grid">
    <p class="project-form-content-title">목표선택</p>
    <div class="form_body_default_target_container_grid">
      <button id="targetMoneyButton" class="project-form-required-type-button @if($project->project_target === 'money') project-form-required-type-button-select @endif" onClick="setTargetType('money'); return false;">일정 금액이 모였을 때 결제되는 프로젝트</button>
      <button id="targetPeopleButton" class="project-form-required-type-button @if($project->project_target === 'people') project-form-required-type-button-select @endif" onClick="setTargetType('people'); return false;">일정 인원이 모였을때 결제되는 프로젝트</button>
      <input id="project_target" type="hidden" value="{{ $project->project_target }}">
      <div>
        <input id="pledged_amount" name="pledged_amount" type="text" class="project-form-input"
            value="{{ $project->pledged_amount }}" placeholder="목표금액/인원" @if ($project->isPublic()) readonly="readonly" @endif />원/명이 모이면 성공!
      </div>
    </div>
  </div>
  @endif
  <div class="project-form-content-grid">
    <p class="project-form-content-title">@if ($project->type === 'funding') 펀딩
        마감일 @else 티켓팅 마감일 @endif</p>
    <div class="col-sm-2">
        <input id="funding_closing_at" name="funding_closing_at" type="text" class="form-control"
               value="{{ $project->getFundingClosingAtOrNow() }}"
               @if ($project->isPublic()) readonly="readonly" @endif />
    </div>
  </div>
</div>

<button id="update_default" class="btn btn-success center-block">저장하기</button>
