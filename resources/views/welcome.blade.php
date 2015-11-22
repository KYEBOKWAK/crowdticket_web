@extends('app')

@section('css')
<style>
	.ps-welcome-header {
		padding: 200px 0px 200px 0px;
		margin-bottom: 40px;
		background-image: url('{{ asset("/img/app/welcome_header_bg.jpg") }}');
	}
	.ps-welcome-header h1 {
		text-align: center;
		margin-bottom: 26px;
		font-family: "Open Sans";
		font-weight: bold;
		font-size: 50px;
	}
	.ps-welcome-card {
		width: 700px;
		padding: 16px;
		margin: 17px auto 0 auto;
		text-align: center;
		background-color: rgba(126, 197, 42, 0.7);
		color: #FFFFFF;
		font-weight: bold;
	}
	.ps-welcome-buttons {
		margin-top: 2em;
		margin-bottom: 90px;
	}
</style>
@endsection

@section('content')
<div class="first-container ps-welcome-header bg-base">
	<h1>
		<span class="text-white">BE ON</span>
		<span class="text-primary"> STAGE</span>
	</h1>
	<img src="{{ asset('/img/app/ico-space.png') }}" class="ico-space" />
	<div class="ps-welcome-card">
		안녕하세요 <br/>
		크라우드 티켓입니당.
	</div>
</div>
<div class="container">
	@include('template.project', ['projects' => $projects ])
	<div class="row ps-welcome-buttons">
		<div class="col-md-12 text-center">
			<a href="{{ url('/blueprints/welcome') }}" class="btn btn-default">공연 개설하기</a>
			<a href="{{ url('/projects') }}" class="btn btn-default">공연 더 보기</a>
		</div>
	</div>
</div>
@endsection
