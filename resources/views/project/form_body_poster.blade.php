<input type="hidden" id="posters_json" value="{{ $posters }}"/>
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

<!--
<div class="row ps-update-poster">
    <img src="{{ asset('/img/app/img_update_project_poster.png') }}" class="center-block"/>
    <h2>포스터 설정</h2>
    <div class="col-md-12">
        <h5 class="bg-info">CROWDTICKET에 붙여 놓을 여러분의 공연포스터를 만들어보세요!
            <br/>
            멋진 이미지로 더 많은 사람들의 주목을 받을 수 있습니다.</h5>
    </div>
    <div class="col-md-8">
        <form id="poster_form" action="{{ url('/projects/') }}/{{ $project->id }}" method="post" role="form">
            <div class="form-group">
                <label for="poster_file" class="control-label">대표 이미지</label>
                <input id="poster_file" type="file" name="poster" style="height: 0; visibility: hidden"/>
                <div id="poster_preview" style="background-image: url('{{ $project->getPosterUrl() }}');"
                     class="bg-base">
                    <div class="middle">
                        <a href="#" id="poster_file_fake" class="btn btn-primary">찾아보기</a>
                    </div>
                </div>
                <p class="help-block">
                    여러분의 프로젝트를 가장 잘 나타낼 수 있는 이미지를 업로드 해주세요.<br/>
                    (2MB 이하의 이미지를 올려주세요, 권장사이즈는 620x452px 입니다.)
                </p>
            </div>
            <div class="form-group">
                <label for="poster_description" class="control-label">포스터 설명</label>
                <input id="poster_description" type="text" class="form-control" name="description" maxlength="60"
                       value="{{ $project->description }}"/>
                <p class="help-block">
                    한 문장으로 여러분의 프로젝트를 설명해야 한다면, 뭐라고 하시겠어요?
                </p>
            </div>
            @include('form_method_spoofing', ['method' => 'put'])
            <button type="submit" class="btn btn-success center-block">
                저장하기
            </button>
        </form>
    </div>
    <div class="col-md-4">
        <img src="{{ asset('/img/app/img_sampleview.png') }}" class="ps-update-sampleview-img"/>
        @include('template.project', ['projects' => [$project], 'colOnly' => true])
    </div>
</div>
-->
