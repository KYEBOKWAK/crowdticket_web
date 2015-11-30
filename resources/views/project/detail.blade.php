@extends('app')

@section('css')
<style>
	.container h2 {
		margin-top: 60px;
		margin-bottom: 25px;
	}
	.ps-detail-admin {
		position: fixed;
	    left: 0;
	    top: 100px;
	}
	.ps-detail-category {
		margin-bottom: 30px;
	}
	.ps-detail-category img {
		margin-right: 5px;
	}
	.ps-detail-category span {
		font-size: 1.2em;
	}
	.ps-detail-left-page {
		padding-left: 20px;
		padding-right: 20px;
	}
	.project-video,
	.project-thumbnail {
		width: 100%;
		height: 450px;
	}
	.ps-detail-description p,
	.ps-detail-share-facebook button {
		width: 100%;
		height: 50px;
	}
	.ps-detail-description {
		padding-right: 0;
	}
	.ps-detail-description p {
		padding-left: 24px;
		background-color: #aaa;
		color: white;
		font-weight: bold;
		font-size: 18px;
		line-height: 50px;
	}
	.ps-detail-share-facebook {
		padding-left: 0;
	}
	.ps-detail-share-facebook button {
		border: none;
		border-radius: 0;
		color: white;
		font-size: 12px;
		background-color: #3a5795;
	}
	.ps-detail-share-facebook button:hover {
		color: #eee;
	}
	.ps-detail-tabs {
		margin-top: 40px;
	}
	.ps-detail-tabs .nav-tabs {
		font-size: 14px;
		color: #8a8273;
	}
	.ps-detail-tabs .active {
		font-weight: bold;
	}
	.tab-pane {
		border-bottom-left-radius: 4px;
		border-bottom-right-radius: 4px;
		border-left: 1px #ddd solid;
		border-right: 1px #ddd solid;
		border-bottom: 1px #ddd solid;
		background-color: white;
		padding: 27px 27px 40px 27px;
	}
	#news-container {
		margin-bottom: 20px;
	}
	
	.ps-detail-comment-wrapper {
		margin-bottom: 20px;
	}
	.ps-detail-comment-wrapper button {
		margin-top: 10px;
	}
	#comments-container {
		padding: 0;
	}
</style>
@endsection

@section('content')
@if (\Auth::check() && \Auth::user()->isOwnerOf($project))
<a href="{{ url('/projects') }}/form/{{ $project->id }}" class="ps-detail-admin"><img src="{{ asset('img/app/btn_admin.png') }}" /></a>
@endif
<div class="first-container container">
	<div class="row">
		<div class="col-md-12">
			<h2 class="text-center"><strong>{{ $project->title }}</strong></h2>
			<div class="text-center ps-detail-category">
				<img src="{{ asset('/img/app/ico_map.png') }}" />
				@if ($project->city)
				<span><strong>{{ $project->city->name }}</strong></span>
				@endif
				@if ($project->category)
				<span><strong> / {{ $project->category->title }}</strong></span>
				@endif
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="row ps-detail-left-page">
				<div class="col-md-12">
					@if ($project->video_url)
					<iframe class="project-video" src="{{ $project->video_url }}" frameborder="0" allowfullscreen></iframe>
					@else ($project->poster_url)
					<div class="bg-base project-thumbnail" style="background-image: url('{{ $project->getPosterUrl() }}')"></div>
					@endif
				</div>
				<div class="col-md-9 ps-detail-description">
					<p class="text-ellipsize">{{ $project->description }}</p>
				</div>
				<div class="col-md-3 ps-detail-share-facebook">
					<button class="btn">페이스북 공유하기</button>
				</div>
				<div class="col-md-12 ps-detail-tabs">
					@include('helper.nav', [
						'nav_class' => 'nav-tabs nav-justified',
						'tabs' => [
							0 => [
								'id' => 'tab-story',
								'class' => 'active',
								'title' => '공연소개'
							],
							
							1 => [
								'id' => 'tab-news',
								'title' => '업데이트 (' . $project->news_count . ')'
							],
							
							2 => [
								'id' => 'tab-comments',
								'title' => '댓글 (' . $project->comments_count . ')'
							],
							
							3 => [
								'id' => 'tab-supporters',
								'title' => '후원자 (' . $project->supporters_count . ')'
							]
						]
					])
				</div>
				<div class="col-md-12 tab-content">
					<div id="tab-story" role="tabpanel" class="tab-pane active">
						{!! html_entity_decode($project->story) !!}
					</div>
					<div id="tab-news" role="tabpanel" class="tab-pane loadable">
						<ul id="news-container" class="list-group"></ul>
						@if ($is_master)
						<div class="text-center">
							<button class="btn btn-success"><a href="{{ url('/projects') }}/{{ $project->id }}/news/form">업데이트 작성</a></button>
						</div>
						@endif
					</div>
					<div id="tab-comments" role="tabpanel" class="tab-pane loadable">
						<form action="{{ url('/projects') }}/{{ $project->id }}/comments" method="post" data-toggle="validator" role="form" class="ps-detail-comment-wrapper">
							<textarea id="input_comment" name="contents" class="form-control" rows="3" placeholder="프로젝트 진행자에게 궁금한 사항, 혹은 응원의 한마디를 남겨주세요!" required></textarea>
							<button class="btn btn-success pull-right">댓글달기</button>
							<div class="clear"></div>
							@include('csrf_field')
						</form>
						<ul id="comments-container"></ul>
					</div>
					<div id="tab-supporters" role="tabpanel" class="tab-pane loadable">
						<ul id="supporters-container" class="list-group"></ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<p>목표금액 {{ $project->pledged_amount }}원 중 모인금액</p>
					<h3>{{ $project->funded_amount }}원, {{ $project->audiences_count }}장, {{ $project->getProgress() }}%</h3>
					<p>후원자</p>
					<h3>{{ $project->audiences_count }}명</h3>
					<p>펀딩 마감까지 남은 시간</p>
					<h3>{{ $project->dayUntilFundingClosed() }}일</h3>
					<a href="{{ url('/projects/') }}/{{ $project->id }}/tickets" class="btn btn-primary">후원하기</a>
				</div>
				<div class="col-md-12">
					@include('template.creator_profile', ['user' => $project->user])
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="project_id" value="{{ $project->id }}" />
</div>
@endsection

@section('js')
	@include('template.comment')
	@include('template.news')
	@include('template.supporter')
	<script src="{{ asset('/js/project/detail.js') }}"></script>
@endsection

