<div class="form-body-default-container">
  <img src="{{ asset('/img/app/img_update_project_ticket.png') }}" class="center-block"/>
  <h2>분류</h2>
  <div class="project-form-subtitle">
      <h5>
        프로젝트의 종류와 결제 방식을 선택해주세요.<br>
        선택 하셔야 다음으로 진행이 됩니다.
      </h5>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">프로젝트 종류</p>
    <div class="project-form-required-type-container-grid">
      <button id="artistsButton" class="project-form-required-type-button @if($project->project_type === 'artist') project-form-required-type-button-select @endif" onClick="setProjectType('artist'); return false;">아티스트 프로젝트</button>
      <button id="creatorsButton" class="project-form-required-type-button @if($project->project_type === 'creator') project-form-required-type-button-select @endif" onClick="setProjectType('creator'); return false;">크리에이터 프로젝트</button>
    </div>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">결제 방식</p>
    <div class="project-form-required-type-container-grid">
      <button id="saleTypeButton" class="project-form-required-type-button @if($project->type === 'sale') project-form-required-type-button-select @endif" onClick="setSaleType('sale'); return false;">일반 티켓팅(즉시 결제)</button>
      <button id="fundingTypeButton" class="project-form-required-type-button @if($project->type === 'funding') project-form-required-type-button-select @endif" onClick="setSaleType('funding'); return false;">목표가 있는 티켓팅(예약 결제)</button>
      funding에서 sale 선택시 project_target 초기화 시켜줘야 함.
    </div>
  </div>

  <div id="isPlaceContainer" class="project-form-content-grid @if($project->type === 'sale' || $project->type === '') project-form-content-grid-hide @endif">
    <p class="project-form-content-title">이벤트 장소가 없으신가요?</p>
    <div class="project-form-required-type-container-grid">
      <button id="isPlaceButton" class="project-form-required-type-button @if($project->temporary_date) project-form-required-type-button-select @endif" onClick="setIsPlace(); return false;">장소 미정</button>
    </div>
  </div>
  <button id="update_required" class="btn btn-success center-block">저장하기</button>
</div>

<input id="projectType" type="hidden" name="projectType" value="{{ $project->project_type }}"/>
<input id="saleType" type="hidden" name="saleType" value="{{ $project->type }}"/>
<input id="projectTarget" type="hidden" name="projectTarget" value="{{ $project->project_target }}">

<?php
  $temporary_date = "FALSE";
  if($project->temporary_date)
  {
    $temporary_date = "TRUE";
  }
?>
{{$temporary_date}} <br>
{{$project->state}}

<input id="temporary_date" type="hidden" name="temporary_date" value="{{ $temporary_date }}"/>
