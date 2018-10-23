<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="naver-site-verification" content="8bce253ce1271e2eaa22bd34b508b72cc60044a5"/>
    <!-- <meta name="description" content="오직 공연 예술인을 위한 크라우드 펀딩"/> -->

    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    @section('meta')
      <meta name="description" content="공연 전문 크라우드펀딩 플랫폼. 연극, 뮤지컬, 콘서트, 파티, 페스티벌, 강연 등 펀딩 및 티켓팅."/>
    @show

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T94QPRD');</script>
    <!-- End Google Tag Manager -->

    @section('title')
        <title>크라우드티켓</title>
    @show
    <link rel="shortcut icon" href="{{ asset('/img/app/ct-favicon.ico') }}">
    <link href="{{ asset('/css/base.css?version=2') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css?version=2') }}" rel="stylesheet">
    <link href="{{ asset('/css/main.css?version=2') }}" rel="stylesheet">
    <link href="{{ asset('/css/global.css?version=2') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.toast.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"/>
@yield('css')
    <link href="{{ asset('/css/flex.css?version=2') }}" rel="stylesheet">

    <style>
    /*리얼에 스타일이 적용되지 않아서 임시로 넣어둠 크리에이터 N*/
    .newNavIcon{
      font-size: 10px;
      font-style: normal;
      font-weight: bold;
      position: relative;
      top: -7px;
      left: 2px;
      color: #ea535a;
    }

    #isMobile{
      display: none;
    }

    @media (max-width:1030px){
      #isMobile{
        display: block;
      }
    }
    </style>

<!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <script async="" src="https://www.google-analytics.com/analytics.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-93377526-1', 'auto');
        ga('send', 'pageview');

    </script>

    <!-- sweetAlert JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- facebook js -->
    <script>
    var fbAppID = '{{env('FACEBOOK_ID')}}';
    var fbVer = '{{env('FACEBOOK_VER')}}';
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version='+fbVer+'&appId='+fbAppID+'&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
</head>
<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T94QPRD"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

<input type="hidden" id="base_url" value="{{ url() }}"/>
<input type="hidden" id="asset_url" value="{{ asset('/') }}"/>

@section('navbar')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#ctNavBar">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('/img/app/logo-color.png') }}"/>
                </a>
            </div>

            <div id="ctNavBar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/projects') }}">ARTISTS</a></li>
                    <li><a href="{{ url('/blueprints/welcome') }}">개설 신청</a></li>
                    <!-- <li><a href="{{ url('/creators') }}">CREATORS<i class="newNavIcon">beta</i></a></li> -->
                    <!-- <li><a href="{{ url('/help') }}">도움말</a></li> -->
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/auth/login') }}">LOGIN</a></li>
                        <li><a href="{{ url('/auth/register') }}">JOIN</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}">내 페이지</a></li>
                                <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}/form">내 정보수정</a></li>
                                <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}/orders">결제확인</a></li>
                                <li><a href="#" onclick="logout(); return false;">로그아웃</a></li>
                                <!-- <li><a href="{{ url('/auth/logout') }}">로그아웃</a></li> -->
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

<div id="isMobile"></div>

<footer>
    <div class="container ct-res-text footer-top">
	    <div class="col-md-3">
            <img src="{{ asset('/img/app/logo-color.png') }}" class="footer-logo">
        </div>
        <div class="col-md-3">
            <h2>social media</h2>
            <h2 class="footer-social">
            <li>
            <a href="https://www.facebook.com/crowdticket/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://www.instagram.com/crowdticket/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href="http://blog.naver.com/crowdticket" target="_blank"><img src="{{ asset('/img/app/naver-icon.png') }}" class="naver-icon"></a></li>
            </h2>
        </div>
        <div class="col-md-3">
            <h2>address</h2>
            <h4>서울시 동대문구 회기로 85<br>
             카이스트 경영대학원 7415</h4>
        </div>
        <div class="col-md-3">
            <h2>contact</h2>
            <h4>KAKAOTALK: @크라우드티켓<br>
             TEL: 070-8819-4308<br>
             E-MAIL: contact@crowdticket.kr</h4>
        </div>
        <div class="col-md-12 ct-info">
            <p>
                 나인에이엠 대표: 신효준&nbsp;|&nbsp;사업자 등록번호: 859 12 00216&nbsp;|&nbsp;통신판매업신고: 2017-서울동대문-1218&nbsp;|&nbsp;<a href="{{ url('/terms') }}">이용약관</a> / <a href="{{ url('/privacy') }}">개인정보취급방침</a>
            </p>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <h4>COPYRIGHT © 2016 CROWDTICKET</h4>
            <p>
                 크라우드티켓은 펀딩을 받거나 티켓을 판매하는 공연의 당사자가 아닙니다. 따라서 공연의 진행과 보상 지급에 대한 책임은 해당 프로젝트 기획자에게 있습니다.<br>
                 하지만 크라우드티켓팀은 우리 공연예술의 발전을 위해 안전하고 편리한 플랫폼을 제공할 수 있도록 항상 최선을 다하겠습니다.
            </p>
        </div>
    </div>
</footer>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/util.js') }}"></script>
<script src="{{ asset('/js/underscore-min.js') }}"></script>
<script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('/js/jquery.toast.min.js') }}"></script>
<script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/additional-methods.min.js') }}"></script>
<script src="{{ asset('/js/jquery.form.custom.js') }}"></script>
<script src="{{ asset('/js/app.2.js?version=4') }}"></script>
<script src="{{ asset('/js/loader.js') }}"></script>

<script>
function logout(){
      FB.getLoginStatus(function(response) {
        console.log(JSON.stringify(response));
        if (response.status === 'connected') {
          //페이스북이 연동된 상태에서 로그아웃 들어오면, 페북 로그 아웃 후 페이지 로그아웃 진행
          FB.logout(function(response) {
              var baseUrl = $('#base_url').val();
              window.location.assign(baseUrl+'/auth/logout');
          });
        }
        else {
          //페이스북 연동 안된 상태에서 로그아웃시
          var baseUrl = $('#base_url').val();
          window.location.assign(baseUrl+'/auth/logout');
        }
      });
}
</script>

@yield('js')

</body>
</html>
