@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $project->title }}</h1>
			@if ($project->city)
				<span>{{ $project->city->name }}</span>
			@endif
			@if ($project->category)
				<span>{{ $project->category->title }}</span>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-7">
			@if ($project->video_url)
				<iframe width="650" height="380" src="{{ $project->video_url }}" frameborder="0" allowfullscreen></iframe>
			@elseif ($project->poster_url)
				<img width="650" height="380" src="{{ $project->poster_url }}" />
			@else
				<p>no image</p>
			@endif
			<div class="row">
				<div class="col-md-9">
					{{ $project->description }}
				</div>
				<div class="col-md-3">
					<button class="btn btn-default">프로젝트 공유하기</button>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<p>목표금액 {{ $project->pledged_amount }}원 중 모인금액</p>
			<h3>{{ $project->funded_amount }}원, {{ $project->audiences_count }}장, {{ $project->getProgress() }}%</h3>
			<p>후원자</p>
			<h3>{{ $project->audiences_count }}명</h3>
			<p>펀딩 마감까지 남은 시간</p>
			<h3>{{ $project->dayUntilFundingClosed() }}일</h3>
			<a href="{{ url('/projects/') }}/{{ $project->id }}/tickets" class="btn btn-primary">후원하기</a>
			<p>프로젝트 진행자</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-2">
			@include('helper.nav', [
				'nav_class' => 'nav-pills',
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
	</div>
	<div class="row">
		<div class="col-md-7 tab-content">
			<div id="tab-story" role="tabpanel" class="tab-pane active">
				{!! html_entity_decode($project->story) !!}
			</div>
			<div id="tab-news" role="tabpanel" class="tab-pane loadable">
				@if ($is_master)
					<a href="{{ url('/projects') }}/{{ $project->id }}/news/form" class="btn btn-default">작성하기</a>
				@endif
				<ul id="news_container" class="list-group"></ul>
			</div>
			<div id="tab-comments" role="tabpanel" class="tab-pane loadable">
				@if (\Auth::check())
					<textarea id="input_comment" class="form-control" rows="3" placeholder="댓글을 입력해주세요"></textarea>
				@endif
				<ul id="comments_container" class="list-group"></ul>
			</div>
			<div id="tab-supporters" role="tabpanel" class="tab-pane loadable">
				<ul id="supporters_container" class="list-group"></ul>
			</div>
		</div>
		<ul class="col-md-4 list-group">
			@foreach ($project->tickets as $ticket)
				<li class="ticket list-group-item">
					<a href="{{ url('/tickets/') }}/{{ $ticket->id }}/orders">
						<h4>{{ $ticket->price }}원 이상 후원, 티켓 {{ $ticket->real_ticket_count }}매 포함</h4>
					</a>
					<p>{{ $ticket->reward }}</p>
					<p>예상 실행일 : {{ date('Y-m-d', strtotime($ticket->delivery_date)) }}</p>
					<p>{{ $ticket->audiences_count }}명이 선택중 / {{ $ticket->audiences_limit }}명 제한</p>
				</li>
			@endforeach
		</ul>
	</div>
	<input type="hidden" id="project_id" value="{{ $project->id }}" />
</div>
@endsection

@section('js')
	@include('template.news')
	<script src="{{ asset('/js/project/detail.js') }}"></script>
@endsection

