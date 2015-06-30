@extends('app')

@section('css')
<style>
	.list-group-item-heading {
		font-weight: bold
	}
	.list-group-item-text {
		margin-bottom: 1em
	}
</style>
@endsection

@section('navbar')
<nav class="navbar navbar-default">
	<a class="navbar-brand" href="{{ url('/') }}">CROWD TICKET</a>
	<p class="navbar-text">관리 콘솔 :P</p>
</nav>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<ul role="tablist" class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#blueprint" aria-controls="blueprint" role="tab" data-toggle="tab">제안서</a></li>
				<li role="presentation"><a href="#project" aria-controls="project" role="tab" data-toggle="tab">프로젝트</a></li>
			</ul>
			<div class="tab-content">
				<ul id="blueprint" role="tabpanel" class="tab-pane active list-group">
					@foreach ($blueprints as $blueprint)
						<li class="list-group-item">
							<form action="{{ url('/admin/blueprints/') }}/{{ $blueprint->id }}/approval" method="post">
								<p class="list-group-item-text">아이디 : {{ $blueprint->user->id }}, 이메일 : {{ $blueprint->user->email }}, 이름 : {{ $blueprint->user->name }}</p>
								<h4 class="list-group-item-heading">자신 소개</h4>
								<p class="list-group-item-text">{{ $blueprint->user_introduction }}</p>
								<h4 class="list-group-item-heading">공연 종류</h4>
								<p class="list-group-item-text">{{ $blueprint->project_introduction }}</p>
								<h4 class="list-group-item-heading">공연 스토리</h4>
								<p class="list-group-item-text">{{ $blueprint->story }}</p>
								<h4 class="list-group-item-heading">예상 공연 비용</h4>
								<p class="list-group-item-text">{{ $blueprint->estimated_amount }}</p>
								<h4 class="list-group-item-heading">연락처</h4>
								<p class="list-group-item-text">{{ $blueprint->contact }}</p>
								<h4 class="list-group-item-heading">요청 날짜</h4>
								<p class="list-group-item-text">{{ $blueprint->created_at }}</p>
								<p class="list-group-item-text">프로젝트 생성 주소 : {{ url('/projects/form/') }}/{{ $blueprint->code }}</p>
								@if ($blueprint->hasApproved())
									@if ($blueprint->hasProjectCreated())
										<span class="label label-success">공연 생성됨!</span>
									@else
										<span class="label label-success">승인완료</span>
									@endif
								@else
									<button type="submit" class="btn btn-primary">승인하기</button>
								@endif
								<input type="hidden" name="_method" value="PUT">
    							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							</form>
						</li>
					@endforeach
				</ul>
				<div id="project" role="tabpanel" class="tab-pane">
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
