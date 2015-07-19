@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/editor.css') }}"/>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10">
			@include('helper.nav', [
				'nav_class' => 'nav-tabs',
				'tabs' => [
					0 => [
						'id' => 'tab-default',
						'class' => 'active',
						'title' => '기본정보'
					],
					
					1 => [
						'id' => 'tab-ticket',
						'title' => '보상'
					],
					
					2 => [
						'id' => 'tab-poster',
						'title' => '포스터'
					],
					
					3 => [
						'id' => 'tab-story',
						'title' => '스토리, 공연 소개'
					]
				]
			])
			
			@include('helper.tab_content',[
				'contents' => [
					0 => [
						'id' => 'tab-default',
						'class' => 'active',
						'include' => 'project.form_body_default'
					],
					
					1 => [
						'id' => 'tab-ticket',
						'include' => 'project.form_body_ticket'
					],
					
					2 => [
						'id' => 'tab-poster',
						'include' => 'project.form_body_poster'
					],
					
					3 => [
						'id' => 'tab-story',
						'include' => 'project.form_body_story'
					]
				]
			])
			<input type="hidden" id="project_id" value="{{ $project->id }}" />
		</div>
		<div class="col-md-2">
			<a href="{{ url('/projects/') }}/{{ $project->id }}" class="btn btn-success" target="_blank">미리보기</a>
			<button id="submit_project" class="btn btn-primary">제출하기</button>
		</div>
	</div>
</div>
@endsection

@section('js')
	@include('template.ticket')
	<script src="{{ asset('/js/project/form.js') }}"></script>
@endsection
