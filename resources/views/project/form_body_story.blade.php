<div class="row">
    <img src="{{ asset('/img/app/img_update_project_story.png') }}" class="center-block"/>
    <h2>스토리</h2>
    <div class="col-md-12">
        <h5 class="bg-info">여러분이 펀딩을 받고 공연을 기획하고자 하는 이야기가 무엇인가요?
            <br/>
            담백하고 진정성 있는 이야기를 들려주세요.</h5>
    </div>
    <div id="story_form" class="col-md-12">
        <div class="form-group">
            <label class="control-label">스토리</label>
            <input type="hidden" id="tx_image_params"
                   value="url={{ url() }}/projects/{{ $project->id }}/story/images&csrf_token={{ csrf_token() }}"/>
            <textarea id="tx_load_content" style="display: none">{{ $project->story }}</textarea>
            @include('editor_summernote')
        </div>
        <button id="update_story" class="btn btn-success center-block">
            저장하기
        </button>
    </div>
</div>
