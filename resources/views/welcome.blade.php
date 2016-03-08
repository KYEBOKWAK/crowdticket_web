@extends('app')

@section('css')
<style>
	.navbar-default {
		background-color: rgba(0, 0, 0, 0);
	}
	.ps-welcome-header {
		height: 500px;
		background-image: url('{{ asset("/img/app/welcome_header_bg_2.jpg") }}');
		position: relative;
	}
	.ps-welcome-header h1 {
		text-align: center;
		margin-bottom: 0px;
		font-weight: bold;
		font-size: 60px;
	}
	.ps-welcome-header p {
		font-size: 18px;
		font-weight: bold;
		text-align: center;
		margin-bottom: 100px;
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
	}
	.ps-header-message {
		padding-top: 150px;
		width: 100%;
		height: 100%;
		position: absolute;
		top: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, 0.2);
	}
	.ps-welcome-header .btn {
		color: white;
		background: none;
		border-radius: 0;
		border: 2px solid white;
	}
	.ps-detail-title {
		font-size: 20px;
		color: #666;
	}
	.ps-project-wrapper {
		margin-bottom: 20px;
	}
	.ps-help-wrapper {
		width: 100%;
		padding: 0px 0 50px 0;
		background-color: #edefed;
	}
	.ps-help-wrapper .ps-help {
		padding-top: 20px;
		padding-bottom: 20px;
		border-bottom: 1px solid #dedede;
	}
	.ps-help-wrapper .ps-help.no-border {
		border: none;
	}
	.ps-help-wrapper .ps-help:last-child {
		margin-bottom: 0px;
	}
	.ps-help-wrapper h4 {
		font-weight: bold;
		font-size: 22px;
	}
	.ps-help-wrapper p {
		font-size: 14px;
	}
	.ps-help-wrapper .col-md-9 {
		padding-top: 10px;
	}
	.ps-help-wrapper .ps-detail-title {
		font-size: 30px;
	}
	#main {
		padding-bottom: 202px;
	}
	.ps-banner {
		margin-top: 50px;
		margin-bottom: 70px;
	}
</style>
@endsection

@section('content')
<div class="first-container ps-welcome-header bg-base">
	<div class="top-mask"></div>
	<div class="bottom-mask"></div>
	<div class="ps-header-message">
		<h1 class="text-white">BE ON STAGE</h1>
		<p class="text-white">크라우드펀딩으로 공연을 기획하고<br/>바로 티켓을 판매해 보세요 </p>
		<div class="text-center">
			<a href="{{ url('/blueprints/welcome') }}" class="btn btn-default">공연 기획하기</a>
		</div>
	</div>
</div>
<div class="container ps-project-wrapper">
	<h3 class="ps-detail-title"><strong>개설중인 공연</strong></h3>
	@include('template.project', ['projects' => $projects ])
</div>
<div class="ps-help-wrapper">
	<div class="container">
		<h3 class="ps-detail-title text-center"><strong>HOW IT WORKS</strong></h3>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="row ps-help">
					<div class="col-md-3">
						<img src="{{ asset('/img/app/ico_step01.png') }}" />
					</div>
					<div class="col-md-9">
						<h4>공연기획</h4>
						<p>
							공연을 가기획하고 최소 필요금액을 책정해 보세요.<br/>
							예를 들면 대관비용, 포스터 인쇄비용 등을<br/>
							모두 예상해서 합해 보는거죠!
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="row ps-help">
					<div class="col-md-9 text-right">
						<h4>펀딩</h4>
						<p>
							미래의 관객들에게 그 금액을 투자 받으세요.<br/>
							공연 티켓, 기념품 등 다양한 보상을 설계해서<br/>
							더 많은 사람들의 도움을 받아 보세요!
						</p>
					</div>
					<div class="col-md-3">
						<img src="{{ asset('/img/app/ico_step02.png') }}" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="row ps-help">
					<div class="col-md-3">
						<img src="{{ asset('/img/app/ico_step03.png') }}" />
					</div>
					<div class="col-md-9">
						<h4>목표달성</h4>
						<p>
							기획했던대로 무대를 만들어 보세요!<br/>
							펀딩받은 금액으로 공연장을 대관하여<br/>
							공연시간과 장소를 확정합니다.
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="row ps-help">
					<div class="col-md-9 text-right">
						<h4>티켓판매</h4>
						<p>
							매진이 될 때까지 티켓을 판매하세요!<br/>
							펀딩의 보상으로 드렸던 티켓을 제외한<br/>
							잔여티켓을 계속해서 판매하세요!
						</p>
					</div>
					<div class="col-md-3">
						<img src="{{ asset('/img/app/ico_step04.png') }}" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="row ps-help no-border">
					<div class="col-md-3">
						<img src="{{ asset('/img/app/ico_step05.png') }}" />
					</div>
					<div class="col-md-9">
						<h4>공연</h4>
						<p>
							꿈에 그리던 멋진 무대에 오르세요!<br/>
							더 큰 무대에서 더 많은 관객들과 함께하세요.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
