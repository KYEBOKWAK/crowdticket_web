@extends('app')

@section('css')
<style>
	#main {
		background-image: url('{{ asset("/img/app/process_bg.jpg") }}');
		background-position: center;
		background-size: cover;
	}
	.box-container {
		margin-bottom: 20px;
	}
	.box-container h4 {
		padding-left: 2em;
	}
	.box-container h5 {
		text-align: center;
	}
	.ps-button-wrapper {
		margin-top: 20px;
	}
	.ps-button-wrapper .btn {
		display: block;
		width: 200px;
		margin: 0 auto;
	}
	#btn-blueprint-help {
		display: block;
		width: 200px;
		margin: 0 auto 50px auto;
	}
</style>
@endsection

@section('content')
<div class="first-container">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 box-container">
				<h2>공연 개설 신청</h2>
				<h4>
					크라우드티켓은 초기 공연기획비용 없이도, <br/>
					음악 콘서트, 토크 콘서트, 강연회, 전시회, 각종 모임 등 <br/>
					모든 종류의 공연을 자유롭게 기획하고 티켓을 판매할 수 있는 열린 공간입니다.
				</h4>
				<div class="row">
					<div class="col-md-6">
						<img src="{{ asset('/img/app/img_blueprint_funding.png') }}" class="img-blueprint" />
						<h5>
							펀딩을 통해 공연기획비용을 마련하고 <br/>
							공연을 기획하고 싶습니다.
						</h5>
					</div>
					<div class="col-md-6">
						<img src="{{ asset('/img/app/img_blueprint_ticket.png') }}" class="img-blueprint" />
						<h5>
							이미 대관 및 공연기획은 완료되었고, <br/>
							크라우드티켓에서 티켓을 판매하고 싶습니다.
						</h5>
					</div>
				</div>
				<div class="row ps-button-wrapper">
					<div class="col-md-6">
						<a role="button" href="{{ url('/blueprints/form?type=funding') }}" class="btn btn-default">펀딩 프로젝트 개설 신청</a>
					</div>
					<div class="col-md-6">
						<a role="button" href="{{ url('/blueprints/form?type=sale') }}" class="btn btn-default">티켓팅 프로젝트 개설 신청</a>
					</div>
				</div>
			</div>
		</div>
		<a id="btn-blueprint-help" role="button" href="{{ url('/help') }}" class="btn btn-default">도움이 필요하신가요?</a>
	</div>
</div>
@endsection
