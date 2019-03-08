<div class="form-body-default-container">
  <div class="project_form_title_wrapper">
    <h2 class="project_form_title">프로젝트 <span class="pointColor">분류</span>
      <p style="font-size:14px; font-weight: normal; margin-top: 8px;">개설 절차는 크롬에 최적화 되어 있습니다.</p>
      <p style="font-size:14px; font-weight: normal; margin-top: 8px;">추첨형 티켓팅 진행을 원하시면 크라우드티켓으로 연락주세요.</p>
    </h2>
  </div>
  <div class="project_form_content_container">
    <div class="project_form_required_button_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">
          프로젝트 종류
        </p>

        <button id="artistsButton" class="project-form-required-type-button project_form_required_type_button_resize">
          <p class="project_form_button_text_artist project_form_button_title">ARTISTS</p>
          <p class="project_form_button_text_artist project_form_button_subtitle">(공연 / 전시 / 쇼케이스 등)</p>
        </button>

        <button id="creatorsButton" class="project-form-required-type-button project_form_required_type_button_resize">
          <p class="project_form_button_text_creator project_form_button_title">CREATORS</p>
          <p class="project_form_button_text_creator project_form_button_subtitle">(유투버 / 스트리머 / 인플루언서 등)</p>
        </button>

        <button id="cultureButton" class="project-form-required-type-button project_form_required_type_button_resize">
          <p class="project_form_button_text_culture project_form_button_title">CULTURE</p>
          <p class="project_form_button_text_culture project_form_button_subtitle">(문화기획 / 파티 / 이벤트 등)</p>
        </button>
      </div>
    </div>

    <div class="project_form_required_button_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">결제 방식</p>

        <button id="fundingTypeButton" class="project-form-required-type-button">
          <p class="project_form_button_text_schedule project_form_button_title">목표가 있는 티켓팅</p>
          <p class="project_form_button_text_schedule project_form_button_subtitle">(예약결제 / 크라우드펀딩형 티켓팅)</p>
        </button>

        <button id="saleTypeButton" class="project-form-required-type-button">
          <p class="project_form_button_text_direct project_form_button_title">일반 티켓팅(즉시 결제)</p>
          <p class="project_form_button_text_direct project_form_button_subtitle">(즉시결제)</p>
        </button>
<!--
        <button id="pickTypeButton" class="project-form-required-type-button">
          <p class="project_form_button_text_pick project_form_button_title">추첨형 티켓팅</p>
          <p class="project_form_button_text_pick project_form_button_subtitle">(예약결제, 당첨자만 결제됨)</p>
        </button>
      -->
      </div>
    </div>

    <div id="project_form_required_place_container" class="project_form_required_button_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">장소/날짜 확정여부</p>

        <button id="placeDecideButton" class="project-form-required-type-button">
          <p class="project_form_button_text_placeDecide project_form_button_title">장소와 날짜가 확정되어 있습니다.</p>
        </button>

        <button id="placeUnDecidedButton" class="project-form-required-type-button">
          <p class="project_form_button_text_UnDecided project_form_button_title">장소와 날짜가 확정되어 있지 않습니다.</p>
        </button>
      </div>
    </div>


    <div class="project_form_button_wrapper">
      @if(!$project->isPublic())
      <div class="flex_layer">
        <button id="update_required" class="btn btn-success center-block project_form_button">저장</button>
        <button id="update_and_next" class="btn btn-success center-block project_form_button pointBackgroundColor">다음</button>
      </div>
      @else
        프로젝트 진행중에는 수정할 수 없습니다.
      @endif
    </div>

  </div>
</div>

<input id="projectType" type="hidden" name="projectType" value="{{ $project->project_type }}"/>
<input id="saleType" type="hidden" name="saleType" value="{{ $project->type }}"/>
