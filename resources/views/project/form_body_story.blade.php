<div class="form-body-default-container">
  <div class="project_form_title_wrapper">
    <h2 class="project_form_title">프로젝트 <span class="pointColor">스토리</span></h2>
  </div>
  <div class="project_form_content_container" style="margin-top: 0px;">
    <form id="editor_image_set_form" action="{{ url('/projects') }}/{{ $project->id }}/story/images" method="post" data-toggle="validator" role="form" enctype="multipart/form-data">
      <input id="editor_image" type="hidden" name="image"/>
      <input id="editor_image_name" type="hidden" name="image_name"/>
      @include('csrf_field')
    </form>
    <div id="story_form" class="col-md-12">
        <div class="form-group">

            <textarea id="tx_load_content" style="display: none">{{ $project->story }}</textarea>
            @include('editor_summernote')
        </div>
        <div class="project_form_button_wrapper">
          <button id="update_story" type="button" class="btn btn-success center-block">
              저장하기
            </button>
        </div>
    </div>
  </div>
</div>
