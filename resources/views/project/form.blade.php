@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<ul role="tablist" class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#default" aria-controls="default" role="tab" data-toggle="tab">기본정보</a></li>
				<li role="presentation"><a href="#ticket" aria-controls="ticket" role="tab" data-toggle="tab">보상</a></li>
				<li role="presentation"><a href="#poster" aria-controls="poster" role="tab" data-toggle="tab">포스터</a></li>
				<li role="presentation"><a href="#story" aria-controls="story" role="tab" data-toggle="tab">스토리, 공연 소개</a></li>
			</ul>
			<div class="tab-content">
				@include('project.form_body_default', ['project' => $project])
				@include('project.form_body_ticket', ['project' => $project])
				@include('project.form_body_poster', ['project' => $project])
				@include('project.form_body_story', ['project' => $project])
			</div>
			<input type="hidden" id="project_id" value="{{ $project->id }}" />
		</div>
		<div class="col-md-3">
			<a href="{{ url('/projects/') }}/{{ $project->id }}" class="btn btn-success" target="_blank">미리보기</a>
			<button id="submit_project" class="btn btn-primary">제출하기</button>
		</div>
	</div>
</div>
@endsection

@section('script')
	@include('template.ticket')
@endsection
