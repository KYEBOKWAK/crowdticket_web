<div class="row">
	<img src="{{ asset('/img/app/img_update_project_story.png') }}" class="center-block" />
	<h2>스토리</h2>
	<div class="col-md-12">
		<h5 class="bg-info">여러분이 펀딩을 받고 공연을 기획하고자 하는 이야기가 무엇인가요?
		<br/>
		담백하고 진정성 있는 이야기를 들려주세요.</h5>
	</div>
	<div id="story_form" class="col-md-12">
		<div class="form-group">
			<label for="video_url" class="control-label">영상 등록</label>
			<input id="video_url" type="text" name="video_url" class="form-control" value="{{ $project->video_url }}" />
			<p class="help-block">
				성공적인 프로젝트를 위해서 멋진 영상을 등록해주세요.<br/>
				(YouTube 영상 하단에 공유 버튼을 누르면 나오는  URL을 넣어주세요!)
				<br/>
				영상을 올리지 않으시면 [포스터] 이미지로 대체 됩니다.
			</p>
		</div>
		<div class="form-group">
			<label class="control-label">스토리</label>
			<input type="hidden" id="tx_image_params" value="url={{ url() }}/projects/{{ $project->id }}/story/images&csrf_token={{ csrf_token() }}" />
			<textarea id="tx_load_content" style="display: none">{{ $project->story }}</textarea>										
			@include('editor')
		</div>
		<button id="update_story" class="btn btn-success center-block">
			저장하기
		</button>
	</div>
</div>