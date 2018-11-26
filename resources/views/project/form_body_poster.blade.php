<input type="hidden" id="posters_json" value="{{ $posters }}"/>

<div class="form-body-default-container">
  <div class="project_form_title_wrapper project_form_title_poster_wrapper">
    <h2 class="project_form_title"><span class="pointColor">대표</span> 이미지 & <span class="pointColor">포스터</span></h2>
  </div>
  <div class="project_form_content_container project_form_content_container_poster">
    <div class="flex_layer">
      <div class="project_form_poster_container">
        <div class="flex_layer">
          <p>대표 이미지</p>
          <div class="project_form_poster_sub_title_container">
            <p>크라우드티켓에서 프로젝트의 대표 이미지로 사용될 파일을 등록해주세요.</p>
            <p>최대 4장까지 등록할 수 있습니다.</p>
            <p>이미지 권장 사이즈는 800px X 600px 입니다.</p>
          </div>
        </div>

        <form id="poster_form" action="{{ url('projects/posters') }}/{{ $project->id }}" method="post" role="form">
          <!-- 포스터 이미지 4개 -->
          <div class="flex_layer">
            @include('template.title_img', ['img_num' => 1, 'project' => $project])
            @include('template.title_img', ['img_num' => 2, 'project' => $project])
          </div>
          <div class="flex_layer">
            @include('template.title_img', ['img_num' => 3, 'project' => $project])
            @include('template.title_img', ['img_num' => 4, 'project' => $project])
          </div>

          <!-- 이미지 추가 -->
          <div class="project_form_input_container" style="display: none;">
            <div class="flex_layer_project">
              <p class="project-form-content-title project_form_poster_title">포스터 이미지</p>
              <div class="project-form-content" style="width: 100%">
                  <a href="javascript:void(0);" id="poster_file_fake"><img style="margin-left: -5px;" src="https://img.icons8.com/windows/40/EF4D5D/plus-2-math.png"></a>
                  <a href="javascript:void(0);" id="poster_file_sub" style="display: none;"><img style="margin-left: -5px;" src="https://img.icons8.com/windows/40/EF4D5D/minus-2-math.png"></a>
                  <p>이미지 권장 사이즈는 500px X 300px 입니다.</p>
                  <p>포스터 미 등록시 메인페이지의 포스터란에 노출되지 않습니다.</p>
                  <div id="poster_img_preview" style="display:none;">
                  </div>
                    <input id="poster_img_file" type="file" name="poster_img_file" style="height: 0; visibility: hidden"/>
              </div>
            </div>
          </div>

          <div class="project_form_input_container" style="width: 100%">
              <p class="project-form-content-title project_form_poster_title" style="margin-bottom: 0px; height: 37px;">프로젝트 한 줄 설명</p>
              <div class="project-form-content" style="width: 100%; margin-left: 0px; padding-right: 90px;">
                <input id="poster_description" name="description" type="text" class="project_form_input_base project_form_poster_input_description" value="{{ $project->description }}"/>
                <p class="project_form_length_text" style="padding-top: 10px; margin-left: 0px;">한 문장으로 여러분의 프로젝트를 설명해야 한다면, 뭐라고 하시겠어요?</p>
              </div>
          </div>

          <div class="project_form_button_wrapper" style="margin-right: 40px;">
            <div class="flex_layer">
              @include('form_method_spoofing', ['method' => 'put'])
              <button id="update_poster" type="button" class="btn btn-success center-block project_form_button">저장</button>
              <button id="update_and_next" type="button" class="btn btn-success center-block project_form_button pointBackgroundColor">다음</button>
            </div>
          </div>
        </form>
      </div>

      <!-- 우측화면 -->
      <div class="project_form_poster_sampleview_container">
        <div style="text-align: left; margin-top: 70px;">
          <img src="{{ asset('/img/app/img_sampleview.png') }}">
        </div>

        @include('template.carousel_main_project', ['projects' => [$project], 'colOnly' => true])
      </div>
    </div>
  </div>
</div>

<!--
<div class="form-body-default-container">
  <form id="poster_form" action="{{ url('projects/posters') }}/{{ $project->id }}" method="post" role="form">
    <div class="project-form-content-grid">
      <p class="project-form-content-title">대표 이미지</p>
      <div class="project-form-poster-title-container-grid">
        <p>크라우드티켓 대표 이미지로 사용될 파일을 등록해 주세요. 최대 4장까지 등록할 수 있습니다.</p>
        <div class="project-form-poster-title-img-container-grid">
          @include('template.title_img', ['img_num' => 1, 'project' => $project])
          @include('template.title_img', ['img_num' => 2, 'project' => $project])
          @include('template.title_img', ['img_num' => 3, 'project' => $project])
          @include('template.title_img', ['img_num' => 4, 'project' => $project])
        </div>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">포스터 이미지</p>
      <div class="project-form-poster-img-preview-container">
        <div id="poster_img_preview" style="background-image: url('{{ $project->getDefaultImgUrl() }}');"
             class="bg-base">
            <div class="middle">
                <a href="#" id="poster_file_fake" class="btn btn-primary">찾아보기</a>
                <button id="delete-poster-img" type="button" data-poster-id="" class="btn btn-primary delete-poster-title-img">삭제</button>
            </div>
        </div>
        <input id="poster_img_file" type="file" name="poster_img_file" style="height: 0; visibility: hidden"/>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">프로젝트 할 줄 설명</p>
      <div>
        <input id="poster_description" type="text" class="form-control" name="description" maxlength="60"
               value="{{ $project->description }}"/>
        <p class="help-block">
            한 문장으로 여러분의 프로젝트를 설명해야 한다면, 뭐라고 하시겠어요?
        </p>
      </div>
    </div>
    @include('form_method_spoofing', ['method' => 'put'])
    <button type="submit" class="btn btn-success center-block">
        저장하기
    </button>
  </form>
</div>
-->
