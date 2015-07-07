<div id="story" role="tabpanel" class="tab-pane">
	<h3>스토리 작성</h3>
	<h4>여러분이 펀딩을 받고 공연을 기획하고자 하는 이야기가 무엇인가요?<br/>담백하고 진정성 있는 이야기를 들려주세요.</h4>
	<div id="story_form"class="form-horizontal">
		<div class="form-group">
			<label for="video_url" class="col-sm-2 control-label">영상 등록</label>
			<div class="col-sm-8">
				<input id="video_url" type="text" name="video_url" class="form-control" value="{{ $project->video_url }}" />
				<p class="help-block">
					성공적인 프로젝트를 위해서 멋진 영상을 등록해주세요.
					<br/>
					영상을 올리지 않으시면 [포스터] 이미지로 대체 됩니다.
				</p>
			</div>
		</div>
		<div class="form-group">
			<label for="story_editor" class="col-sm-2 control-label">포스터 설명</label>
			<div class="col-sm-10">
				@include('editor')
			</div>
		</div>
		<button id="update_story" class="btn btn-success pull-right">저장하기</button>
	</div>
</div>