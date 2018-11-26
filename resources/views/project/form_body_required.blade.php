<div class="form-body-default-container">
  <div class="project_form_title_wrapper">
    <h2 class="project_form_title">프로젝트 <span class="pointColor">분류</span></h2>
  </div>
  <div class="project_form_content_container">
    <div class="project_form_required_button_container">
      <div class="flex_layer_project">
          <p class="project-form-content-title">프로젝트 종류 @include('template.tooltip', ['content' => '여기로 툴팁오나요'])</p>
        <button id="artistsButton" class="project-form-required-type-button">
          <p class="project_form_button_text_artist project_form_button_title">아티스트 프로젝트</p>
          <p class="project_form_button_text_artist project_form_button_subtitle">(뮤지션 / 극단 / 공연기획자 등)</p>
          @include('template.tooltip', ['content' => '아티스트 프로젝트 설명입니다'])
        </button>
        <button id="creatorsButton" class="project-form-required-type-button">
          <p class="project_form_button_text_creator project_form_button_title">크리에이터 프로젝트</p>
          <p class="project_form_button_text_creator project_form_button_subtitle">(유투버 / bj,스트리머 / 인플루언서 등)</p>
          @include('template.tooltip', ['content' => '크리에이터 프로젝트 설명입니다'])
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
            @include('template.tooltip', ['content' => '날짜와 장소가 확정되어 있지는 않지만 프로젝트를 진행할 수 있습니다. <br> (추후에 프로젝트를 진행하며 기획안이 확정되는대로 구매자들에게 공지할 수 있습니다.)'])
        </button>
      </div>
    </div>

    <div class="project_form_required_button_container">
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
      <div class="flex_layer">
        <button id="update_required" class="btn btn-success center-block project_form_button">저장</button>
        <button id="update_and_next" class="btn btn-success center-block project_form_button pointBackgroundColor">다음</button>
      </div>
    </div>
  </div>
</div>

<input id="projectType" type="hidden" name="projectType" value="{{ $project->project_type }}"/>
<input id="saleType" type="hidden" name="saleType" value="{{ $project->type }}"/>
<input id="isPlace" type="hidden" name="isPlace" value="{{ $project->isPlace }}"/>
