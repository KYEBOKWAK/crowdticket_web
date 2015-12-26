<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>CrowdTicket</title>

	<link href="{{ asset('/css/base.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/jquery.toast.min.css') }}" rel="stylesheet">
	@yield('css')

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<input type="hidden" id="base_url" value="{{ url() }}" />
	<input type="hidden" id="asset_url" value="{{ asset('/') }}" />
	
	@section('navbar')
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">CROWD TICKET</a>
			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/projects') }}">전체 공연 보기</a></li>
					<li><a href="{{ url('/blueprints/welcome') }}">공연 개설 신청</a></li>
					<li><a href="{{ url('/help') }}">도움말</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">LOGIN</a></li>
						<li><a href="{{ url('/auth/register') }}">JOIN</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}">내 페이지</a></li>
								<li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}/form">내 정보수정</a></li>
								<li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}/orders">결제확인</a></li>
								<li><a href="{{ url('/auth/logout') }}">로그아웃</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	@show

	<div id="main">
		@yield('content')
	</div>
	
	<footer>
		<div class="container">
			<img src="{{ asset('/img/app/logo_bottom.png') }}" class="logo-footer" />
			<div>
				<ul>
					<li><a href="{{ url('/terms') }}">이용약관</a></li>
					<li><a href="{{ url('/privacy') }}">개인정보취급방침</a></li>
				</ul>
				<p>COPYRIGHT (C) 2015 CROWD TICKET</p>
				<p>
					<span>크라우드티켓</span>
					<span><strong>대표</strong>신효준</span>
					<span><strong>사업자등록번호</strong>105-87-52823</span>
					<span><strong>영업소재지</strong>서울시 홍대역 놀이터</span>
				</p>
				<p>
					<span><strong>통신판매업</strong>2011-서울홍대-0081</span>
					<span><strong>전화</strong>010-0000-0000</span>
					<span><strong>팩스</strong>070-0000-0000</span>
					<span><strong>관리자 이메일</strong><a href="mailto:jun@crowdticket.kr">jun@crowdticket.kr</a></span>
				</p>
			</div>
		</div>
	</footer>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ asset('/js/underscore-min.js') }}"></script>
	<script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('/js/jquery.form.min.js') }}"></script>
	<script src="{{ asset('/js/jquery.toast.min.js') }}"></script>
	<script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('/js/additional-methods.min.js') }}"></script>
	<script src="{{ asset('/js/app.js') }}"></script>
	<script src="{{ asset('/js/loader.js') }}"></script>
	
	@yield('js')

</body>
</html>
