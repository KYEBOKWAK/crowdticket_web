<div class="form-body-default-container">
  <div class="project_form_title_wrapper">
    <h2 class="project_form_title"><span class="pointColor">기본 정보</span> 입력</h2>
  </div>
  <div class="project_form_content_container">
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">프로젝트 제목</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="title" name="title" type="text" class="project_form_input_base" maxlength="31" value="{{ $project->title }}" @if ($project->isPublic()) readonly="readonly" @endif/>
            <p class="titleLength project_form_length_text">0/31</p>
          </div>
        </div>
      </div>
    </div>

    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">분류</p>
        <div class="project-form-content">
          <select id="category" name="category" class="project-form-input project-form-input-category"
                  @if ($project->isPublic()) readonly="readonly" disabled="disabled" @endif>
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
    </div>

    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">태그</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <span class="project_form_sharp">#</span><input id="hash_tag1" name="hash_tag1" type="text" class="project_form_input_base project_form_input_hash_tag" value="{{ $project->hash_tag1 }}" @if ($project->isPublic()) readonly="readonly" @endif/>
            <span class="project_form_sharp">#</span><input id="hash_tag2" name="hash_tag2" type="text" class="project_form_input_base project_form_input_hash_tag" value="{{ $project->hash_tag2 }}" @if ($project->isPublic()) readonly="readonly" @endif/>
          </div>
        </div>
      </div>
    </div>

    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">
          @if($project->isPlace == "TRUE")
            지역
          @else
            예상지역
          @endif
        </p>
        <div class="project-form-content">
          <div class="flex_layer_column">
            <div class="project_form_adress_wrapper">
              <div class="flex_layer">
                @if($project->isPlace == "TRUE")
                  <select id="city" name="city" class="project-form-input project-form-input-category"
                          @if ($project->isPublic()) readonly="readonly" disabled="disabled" @endif>
                      @foreach ($cities as $city)
                          @if ($city->id === $project->city_id)
                              <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                          @else
                              <option value="{{ $city->id }}">{{ $city->name }}</option>
                          @endif
                      @endforeach
                  </select>
                @endif
                <input id="concert_hall" name="concert_hall" @if($project->isPlace == "TRUE") style="margin-left:10px;" @endif type="text" class="project_form_input_base"
                    value="{{ $project->concert_hall }}" placeholder="@if($project->isPlace == 'TRUE')공연장 / 장소 명 @else 대략적으로 계획 중인 장소를 적어주세요.@endif" @if ($project->isPublic()) readonly="readonly" @endif />
              </div>
            </div>
            @if($project->isPlace == "TRUE")
              <input id="detailed_address" name="detailed_address" type="text" class="project_form_input_base"
                  value="{{ $project->detailed_address }}" placeholder="상세 주소를 입력해주세요" @if ($project->isPublic()) readonly="readonly" @endif />
            @endif
          </div>
        </div>
      </div>
    </div>

    @if($project->isPlace == "FALSE")
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">예상 공연 날짜</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="temporary_date" name="temporary_date" type="text" class="project_form_input_base" placeholder="예) 1월 첫째주 예정, 1월 즈음" value="{{ $project->temporary_date }}" @if ($project->isPublic()) readonly="readonly" @endif/>
          </div>
        </div>
      </div>
    </div>
    @endif

    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">페이지 주소</p>
        <div class="project-form-content">
          <div class="flex_layer_most_mobile">
            <div class="flex_layer">
              <div class="project_form_input_base project_form_alias_url">{{ url('/projects') }}/</div>
              <input id="alias" name="alias" type="text" maxlength="32" class="project_form_input_base project-form-input-newURL" value="{{ $project->alias }}"
                     @if ($project->isPublic()) readonly="readonly" @endif />
            </div>

            @if (!$project->isPublic())
            <div class="flex_layer">
              <button id="check_alias" class="btn btn-default btn-alias pointBackgroundColor">
                  중복확인
              </button>
              <p class="aliasLength project_form_length_text">0/32</p>
            </div>
            @endif
          </div>

          <p style="font-size: 12px; margin-top:10px; color:#aaaaaa">주변 사람들에게 펀딩을 홍보할 때 사용하게 될 URL을 직접 입력해보세요! <br>
              32자 이내 영문, 숫자, -, _만 입력이 가능합니다. 첫번째 글자는 영문으로 시작되어야 합니다.</p>
        </div>
      </div>
    </div>

    @if($project->isFundingType())
      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">목표 선택</p>
          <div class="project-form-content">
            <button id="targetMoneyButton" class="project-form-required-type-button project_form_funding_type_button_wrapper">
              <p class="project_form_button_text_money project_form_button_title">일정 금액</p>
            </button>
            <button id="targetPeopleButton" class="project-form-required-type-button project_form_funding_type_button_wrapper">
              <p class="project_form_button_text_people project_form_button_title">일정 인원</p>
            </button>

            <div style="width: 100%; margin-top:10px;">
              <div class="flex_layer">
                <input id="pledged_amount" name="pledged_amount" type="number" class="project_form_input_base project_form_input_fund_target" value="{{ $project->pledged_amount }}" min="0" placeholder="목표금액/인원" @if ($project->isPublic()) readonly="readonly" @endif />
                  <span class="project_form_fund_target_sub_title">
                    @if($project->project_target == 'money')
                      원이 모이면 성공!
                    @else
                      명이 모이면 성공!
                    @endif
                  </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">
          @if($project->isFundingType())
            펀딩 마감일
          @else
            티켓팅 마감일
          @endif
        </p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="funding_closing_at" name="funding_closing_at" type="text" class="project_form_input_base project_form_closing_at"
                   value="{{ $project->getFundingClosingAtOrNow() }}"
                   @if ($project->isPublic()) readonly="readonly" disabled="disabled" @endif />
          </div>
        </div>
      </div>
    </div>

    <div class="project_form_button_wrapper">
      @if(!$project->isPublic())
        <div class="flex_layer">
          <button id="update_default" class="btn btn-success center-block project_form_button">저장</button>
          <button id="update_and_next" class="btn btn-success center-block project_form_button pointBackgroundColor">다음</button>
        </div>
      @else
        프로젝트 진행중에는 수정할 수 없습니다.
      @endif
    </div>
  </div>
</div>
