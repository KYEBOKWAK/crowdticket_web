<div class="row ps-update-poster">
	<img src="{{ asset('/img/app/img_update_project_poster.png') }}" class="center-block" />
	<h2>포스터 설정</h2>
	<div class="col-md-12">
		<h5 class="bg-info">CROWDTICKET에 붙여 놓을 여러분의 공연포스터를 만들어보세요!
		<br/>
		멋진 이미지로 더 많은 사람들의 주목을 받을 수 있습니다.</h5>
	</div>
	<div class="col-md-8">
		<form id="poster_form" action="{{ url('/projects/') }}/{{ $project->id }}" method="post"role="form">
			<div class="form-group">
				<label for="poster_file" class="control-label">대표 이미지</label>
				<input id="poster_file" type="file" name="poster" style="height: 0; visibility: hidden" />
				<div id="poster_preview" style="background-image: url('{{ $project->getPosterUrl() }}');" class="bg-base">
					<div class="middle">
						<a href="#" id="poster_file_fake" class="btn btn-primary">찾아보기</a>
					</div>
				</div>
				<p class="help-block">
					여러분의 프로젝트를 가장 잘 나타낼 수 있는 이미지를 업로드 해주세요. (2MB 이하의 이미지를 올려주세요)
				</p>
			</div>
			<div class="form-group">
				<label for="poster_description" class="control-label">포스터 설명</label>
				<input id="poster_description" type="text" class="form-control" name="description" maxlength="60" value="{{ $project->description }}" />
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
		<img src="{{ asset('/img/app/img_sampleview.png') }}" class="ps-update-sampleview-img" />
		@include('template.project', ['projects' => [$project], 'colOnly' => true])
	</div>
</div>
