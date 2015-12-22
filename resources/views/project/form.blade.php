@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/editor.css') }}"/>
<style>
	.ps-update-tabs {
		margin-top: 48px;
		margin-bottom: 35px;
		margin-left: -2px;
		margin-right: -2px;
	}
	.ps-update-tabs a {
		text-decoration: none;
	}
	.ps-update-tabs .col-md-1,
	.ps-update-tabs .col-md-2 {
		padding-left: 2px;
		padding-right: 2px;
	}
	.ps-update-tabs .col-md-1 {
		padding-top: 5px;
	}
	.ps-update-tab {
		padding: 10px 0 10px 0;
		text-align: center;
		background-color: #eee;
		color: #384150;
	}
	.ps-update-tab img {
		width: 24px;
		height: 25px;
	}
	.ps-update-tab-selected {
		background-color: #7EC52A;
	}
	.ps-update-tab-title {
		display: inline;
		font-size: 15px;
		font-weight: bold;
	    vertical-align: middle;
    	margin-left: 8px;
	}
	.ps-update-tab:hover {
		background-color: #ddd;
	}
	.ps-update-tab-selected:hover {
		background-color: #7EC52A;
	}
	.ps-update-body h2 {
		font-weight: bold;
		margin: 8px auto 30px auto;
		text-align: center;
	}
	.ps-update-body .bg-info {
		text-align: center;
		margin-top: 0;
		margin-bottom: 38px;
		background-color: #eaeaea;
		padding: 8px;
		line-height: 1.3em;
	}
	.ps-update-body .form-group label {
		padding-right: 0;
	}
	.ps-col-width-17p2 {
		width: 17.2%;
	}
	#ticket_reward {
		height: 130px;
	}
	#ticket_list {
		margin-bottom: 3em;
	}
	.ticket .ticket-footer,
	.ticket .ticket-wrapper {
		border-bottom-right-radius: 0;
	}
	.ticket .ticket-body span {
		font-size: 20px;
	}
	.ticket .col-md-1 {
	    position: absolute;
	    bottom: 0;
	    right: 0;
	    margin-right: 14px;
		padding: 0;
	}
	.ticket .col-md-1 button {
		width: 100%;
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
	}
	.ticket .col-md-1 p {
		margin: 0;
	}
	.ticket .col-md-1 .modify-ticket {
		margin-bottom: 5px;
	}
	.ps-update-poster .col-md-8 {
		border-right: 1px #DAD8CC solid;
	}
	.ps-update-sampleview-img {
		margin-top: 17px;
	    margin-left: -15px;
	    margin-bottom: 15px;
	}
	.ps-update-poster .form-group .bg-base {
		position: relative;
		width: 100%;
		height: 480px;
	}
	.ps-update-poster .form-group .bg-base .middle {
		width: 100%;
		position: absolute;
		top: 45%;
		text-align: center;
	}
	#video_url {
		width: 70%;
	}
	.ps-update-creator h3 {
		text-align: center;
		line-height: 1.4em;
	}
	.ps-update-creator .link-user-form {
		margin-top: 30px;
		margin-bottom: 60px;
	}
	.ps-update-creator .link-user-form a {
		font-size: 18px;
	}
	.ps-update-creator .box-creator-profile {
		margin-top: 15px;
	}
</style>
@endsection

@section('content')
@include('helper.btn_admin', ['project' => $project])
<div class="first-container">
	<div class="container">
		<div class="row ps-update-tabs">
			<?php
				$tabs = [
					[
						'key' => 'base',
						'title' => '기본정보',
						'ico_url' => asset('/img/app/ico_tap01.png')
					]
				];
				if ($project->type === 'funding') {
					array_push($tabs, [
						'key' => 'reward',
						'title' => '보상',
						'ico_url' => asset('/img/app/ico_tap02.png')
					]);
				} else {
					array_push($tabs, [
						'key' => 'ticket',
						'title' => '티켓',
						'ico_url' => asset('/img/app/ico_tap02.png')
					]);
				}
				array_push($tabs, [
					'key' => 'poster',
					'title' => '포스터',
					'ico_url' => asset('/img/app/ico_tap03.png')
				]);
				array_push($tabs, [
					'key' => 'story',
					'title' => '스토리',
					'ico_url' => asset('/img/app/ico_tap04.png')
				]);
				array_push($tabs, [
					'key' => 'creator',
					'title' => '개설자소개',
					'ico_url' => asset('/img/app/ico_tap05.png')
				]);
			?>
			
			@foreach ($tabs as $tab)
			<div class="col-md-2">
				<a href="{{ url('/projects/form/') }}/{{ $project->id }}?tab={{ $tab['key'] }}">
					<div class="ps-update-tab @if ($tab['key'] === $selected_tab) ps-update-tab-selected @endif">
						<img src="{{ $tab['ico_url'] }}" />
						<h5 class="ps-update-tab-title">{{ $tab['title'] }}</h5>
					</div>
				</a>
			</div>
			@endforeach
			<div class="col-md-1">
				<a href="{{ url('/projects/') }}/{{ $project->id }}" class="btn btn-success" target="_blank">미리보기</a>
			</div>
			@if ($project->isReady())
			<div class="col-md-1">
				<button id="submit_project" class="btn btn-primary">제출하기</button>
			</div>
			@endif
		</div>
		<div class="ps-update-body">
			@if ($selected_tab === 'base')
				@include('project.form_body_default', [
					'categories' => $categories,
					'cities' => $cities,
					'project' => $project
				])
			@elseif ($selected_tab === 'reward' || $selected_tab === 'ticket')
				@include('project.form_body_ticket', ['project' => $project])
			@elseif ($selected_tab === 'poster')
				@include('project.form_body_poster', ['project' => $project])
			@elseif ($selected_tab === 'story')
				@include('project.form_body_story', ['project' => $project])
			@elseif ($selected_tab === 'creator')
				@include('project.form_body_creator', ['project' => $project, 'user' => Auth::user()])
			@endif
		</div>
	</div>
	<input type="hidden" id="project_id" value="{{ $project->id }}" />
</div>
@endsection

@section('js')
	@include('template.ticket')
	<script src="{{ asset('/js/project/form.js') }}"></script>
@endsection
