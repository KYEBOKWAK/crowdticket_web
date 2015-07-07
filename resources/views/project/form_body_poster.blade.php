<div id="poster" role="tabpanel" class="tab-pane">
	<h3>포스터 만들기</h3>
	<h4>CROWDTICKET에 붙여 놓을 여러분의 공연포스터를 만들어보세요!<br/>멋진 이미지로 더 많은 사람들의 주목을 받을 수 있습니다.</h4>
	<form id="poster_form" action="{{ url('/projects/') }}/{{ $project->id }}" method="post" class="form-horizontal" role="form">
		<div class="form-group">
			<label for="poster_file" class="col-sm-2 control-label">대표 이미지</label>
			<div class="col-sm-8">
				<input id="poster_file" type="file" name="poster" />
				<p class="help-block">여러분의 프로젝트를 가장 잘 나타낼 수 있는 이미지를 업로드 해주세요</p>
				<img id="poster_preview" width="600" height="400" src="{{ $project->poster_url }}" />
			</div>
		</div>
		<div class="form-group">
			<label for="poster_description" class="col-sm-2 control-label">포스터 설명</label>
			<div class="col-sm-8">
				<textarea id="poster_description" class="form-control" name="description" maxlength="60">{{ $project->description }}</textarea>
				<p class="help-block">한 문장으로 여러분의 프로젝트를 설명해야 한다면, 뭐라고 하시겠어요?</p>
			</div>
		</div>
		<input type="hidden" name="_method" value="PUT">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<button type="submit" class="btn btn-success pull-right">저장하기</button>
	</form>
</div>