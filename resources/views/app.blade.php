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
        <title>크티: 크라우드티켓 - 팬 중심 크리에이터 밋업 플랫폼 </title>
    @show
    <link rel="shortcut icon" href="{{ asset('/img/icons/pavicon-v-2.png') }}"/>
    <link href="{{ asset('/css/lib/toast.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/base.css?version=6') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/app.css?version=8') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/main.css?version=6') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/global.css?version=19') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/jquery.toast.min.css') }}" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/login/login.css?version=4') }}" rel="stylesheet"/>
@yield('css')
    <link href="{{ asset('/css/flex.css?version=6') }}" rel="stylesheet"/>


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

    .ct-info{
      margin-top: 40px;
      font-size: 10px;
      color: #acacac;
      text-align: center;
    }

    @media (max-width:1030px){
      #isMobile{
        display: block;
      }
    }

    /*3.5 START*/
    .navbar{
      min-width: 0;
      width: 1060px;

      margin-left: auto;
      margin-right: auto;
    }

    .navbar-default{
      border-bottom: 0px;
    }

    .navbar-brand{
      padding: 0px;
      height: auto;
      margin-top: 26px;
      margin-bottom: 26px;
    }

    .navbar-brand img{
      /*width: 141px;
      height: 16px;
      padding: 0px;*/
      width: 100%;
      height: 28px;
      padding: 0px;
    }

    #ctNavBar{
      padding: 0px;
    }

    .navbar-nav>li>a{
      padding: 0px;
      margin-left: 30px;
      margin-top: 30px;
      margin-bottom: 30px;

      font-weight: normal !important;
      font-style: normal !important;
      font-stretch: normal !important;
      line-height: normal !important;
      letter-spacing: normal !important;
    }

    .navbar-right{
      margin-right: 0px;
    }

    .container{
      padding-bottom: 0px;
    }

    .kakao_chat_icon_wrapper{
      left: auto;
      height:95px;
      margin-right: 19px;
      margin-bottom: 5px;
    }

    .kakao_chat_round{
      width: 80px;
      height: 80px;
      box-shadow: 8px 8px 14px 0 rgba(0, 0, 0, 0.1);
      background-color: #fae100;
      border-radius: 100%;
    }

    .kakao_chat_ask{
      position: relative;
      top: 18px;
      right: 1px;
      font-size: 16px;
      text-align: center;
      color: #3c1e1e;
      font-weight: bold;
      line-height: 1.4;
    }

    .kakao_chat_icon_img{
      margin-left:18px;
      margin-top:20px;
    }

    @media (max-width:1060px){
      .navbar{
        min-width: 0;
        width: 93%;

        margin-left: auto;
        margin-right: auto;
      }
    }

    .ct-res-text h2{
      font-size: 14px;
      font-weight: normal;
    }

    .ct-res-text h4{
      font-size: 12px;
      font-weight: normal;
      line-height: 1.5;
    }

    @media (max-width:767px){
      .navbar-toggle{
        margin-top: 27px;
        margin-right: 0px;
      }

      .navbar-nav>li>a{
        margin-top: 2px;
        margin-bottom: 10px;
        margin-left: 17px;
      }

      .kakao_chat_round{
        width: 50px;
        height: 50px;
      }

      .kakao_chat_icon_img{
        width: 40px;
        margin-left:10px;
        margin-top:11px;
      }

      .kakao_chat_icon_wrapper{
        height:auto;
        margin-bottom: 16px;
        margin-right: 18px;
      }

      .kakao_chat_ask{
        top: 11px;
        right: 0px;
        font-size: 12px;
        line-height: 1.2;
      }
    }
    /*3.5 END*/
    </style>

<!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'/>

    <!-- <script async="" src="https://www.google-analytics.com/analytics.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @include('template.data_collect')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-93377526-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-93377526-1');
    </script>
   

    <!-- sweetAlert JS -->
    <script type="text/javascript" src="{{ asset('/js/sweetalert/sweetalert.min.js') }}"></script>

    <!-- toast alert -->
    <script type="text/javascript" src="{{ asset('/js/lib/toast.min.js?version=2') }}"></script>

    <!-- google js -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- crowdticket util before body -->
    <script type="text/javascript" src="{{ asset('/js/util_header.js?version=9') }}"></script>

    <!-- 카카오톡 sdk -->
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T94QPRD"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<input type="hidden" id="base_url" value="{{ url() }}"/>
<input type="hidden" id="asset_url" value="{{ asset('/') }}"/>

<input type="hidden" id="myId" value="@if(Auth::user()){{Auth::user()->id}}@else{{0}}@endif"/>
<input type="hidden" id="notification" value="@if(isset($_COOKIE['cr_config_notification'])){{$_COOKIE['cr_config_notification']}}@endif"/>


@section('navbar')
<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#ctNavBar">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        @if(!env('REVIEW_ON'))
          <a class="navbar-brand" href="{{ url('/') }}">
              <img src="{{ asset('/img/icons/svg/header-logo-color-v-1.svg') }}"/>
          </a>
        @endif
    </div>

    <div id="ctNavBar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
        @if(env('REVIEW_ON'))
          <li><a href="{{ url('/magazine') }}">매거진</a></li>
        @else
          <!-- <li><a href="{{ url('/projects') }}">전체보기</a></li> -->
          <li><a href="{{ url('/magazine') }}">매거진</a></li>
          <li><a href="{{ url('/blueprints/welcome') }}">프로젝트 만들기</a></li>
          <li>
              <a href="{{ url('/mannayo') }}" style="display: inline-block;">만나요</a>
              <span style="position:relative; margin-left:2px; top:-4px; color:#43c9f0; font-size:10px">beta</span>
          </li>
        @endif
        </ul>

        <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <li id="g_login"><a href="javascript:;" onclick="">로그인</a></li>
                <li id="g_register"><a href="javascript:;" onclick="">회원가입</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-expanded="false">{{ Auth::user()->getUserNickName() }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}">내 페이지</a></li>
                        <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}/mannayo">내 만나요</a></li>
                        <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}/form">내 정보수정</a></li>
                        <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}/orders">결제확인</a></li>
                        <li><a href="#" onclick="logout(); return false;">로그아웃</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
    
</nav>
@show

<div id="main">
    @yield('content')

      <div id="kakao_chat_ask" class="kakao_chat_icon_wrapper navbar-fixed-bottom">
          <div class="kakao_chat_round">
          <p class="kakao_chat_ask">카톡<br>문의</p>
          </div>
      </div>

      <div id="kakao_chat_icon" class="kakao_chat_icon_wrapper navbar-fixed-bottom">
          <div class="kakao_chat_round">
            <img class="kakao_chat_icon_img" src="{{asset('/img/icons/svg/ic-bottom-btn-kakao-n.svg')}}">
          </div>
      </div>

      <div id="kakao_chat_empty_area" class="kakao_chat_icon_wrapper navbar-fixed-bottom" style="box-shadow: unset; opacity:0">
          <a href="javascript:void plusFriendChat()">
            <div class="kakao_chat_round">
            </div>
          </a>
      </div>
    
    <!--
    <div id="animate" class="kakao_chat_icon_wrapper navbar-fixed-bottom">
      <a href="javascript:void plusFriendChat()">
        <img src="https://developers.kakao.com/assets/img/about/logos/plusfriend/consult_small_yellow_pc.png"/>
      </a>
    </div>
  -->
</div>

<div id="isMobile"></div>

<footer>
    <div class="container ct-res-text footer-top">
	    <div class="col-md-3 footer_padding_left_remover">
            <img src="{{ asset('/img/icons/svg/footer-logo-color-v-1.svg') }}" class="footer-logo">
        </div>
        <div class="col-md-3">
            <h2>social media</h2>
            <h2 class="footer-social">
            <li>
            <a href="https://www.facebook.com/crowdticket/" target="_blank"><img src="{{ asset('/img/icons/svg/ic-footer-social-01-facebook.svg') }}"></a></li>
            <li><a href="https://www.instagram.com/crowdticket/" target="_blank"><img src="{{ asset('/img/icons/svg/ic-footer-social-02-instagram.svg') }}"></a></li>
            <li><a href="http://blog.naver.com/crowdticket" target="_blank"><img src="{{ asset('/img/icons/svg/ic-footer-social-03-naver.svg') }}"></a></li>
            </h2>
        </div>
        <div class="col-md-3">
            <h2>contact</h2>
            <h4>KAKAO : @크라우드티켓<br>
              T : 070-8819-4308<br>
              E : contact@crowdticket.kr</h4>
        </div>
        <div class="col-md-3">
            <h2>address</h2>
            <h4>서울특별시 관악구 봉천로 545 4층<br>
             (주)나인에이엠</h4>
        </div>
        <div class="col-md-12 ct-info">
            <p style="margin-bottom: 8px;">
                 (주)나인에이엠 대표: 신효준&nbsp;|&nbsp;사업자 등록번호: 407 81 31606&nbsp;|&nbsp;통신판매업신고: 2017-서울동대문-1218&nbsp;|&nbsp;<a href="{{ url('/terms') }}">이용약관</a> / <a href="{{ url('/privacy') }}">개인정보취급방침</a> / <a href="{{ url('/thirdterms') }}">제3자 정보제공 약관</a>
            </p>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container" style="margin-bottom: 20px;">
          @if(env('REVIEW_ON'))
          <h4>COPYRIGHT © 2016 NINEAM</h4>
          @else
          <p>
            크라우드티켓은 이벤트의 당사자가 아닙니다. 따라서 이벤트 진행 전반에 대한 책임은 해당 이벤트를 진행하는 기획자에게 있습니다.<br>
            크라우드티켓팀은 이벤트 티켓팅과 관련된 편리하고 공정한 온라인 솔루션을 제공할 수 있도록 항상 최선을 다하겠습니다.
          </p>
          <p>
            COPYRIGHT © 2016 CROWDTICKET
          </p>
          @endif
        </div>
    </div>
</footer>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/util.js?version=29') }}"></script>
<script src="{{ asset('/js/underscore-min.js') }}"></script>
<script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('/js/jquery.toast.min.js') }}"></script>
<script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/additional-methods.min.js') }}"></script>
<script src="{{ asset('/js/jquery.form.custom.js') }}"></script>
<script src="{{ asset('/js/app.2.js?version=4') }}"></script>
<script src="{{ asset('/js/loader.js?version=1') }}"></script>

<?php
  $loginFilePath = asset('/js/fblogin.js?fbid='.env('FACEBOOK_ID').'&fbver='.env('FACEBOOK_VER').'&ggid='.env('GOOGLE_ID').'&version=11');
?>
<script src="{{ $loginFilePath }}"></script>

<script>
function logout(){
  /*
      FB.getLoginStatus(function(response) {
        console.log(JSON.stringify(response));
        if (response.status === 'connected') {
          //페이스북이 연동된 상태에서 로그아웃 들어오면, 페북 로그 아웃 후 페이지 로그아웃 진행
          FB.logout(function(response) {
            console.error("FB Logout : " + response);
              //var baseUrl = $('#base_url').val();
              //window.location.assign(baseUrl+'/auth/logout');
          });
        }
        else {
          //페이스북 연동 안된 상태에서 로그아웃시
          //var baseUrl = $('#base_url').val();
          //window.location.assign(baseUrl+'/auth/logout');
        }
      });
*/
      var baseUrl = $('#base_url').val();
      window.location.assign(baseUrl+'/auth/logout');
    }

    if($('#notification').val())
    {
      showToast('i', $('#notification').val());
    }
</script>

@yield('js')

<script>
  $(document).ready(function() {
    if(!$("#isFirst"))
    {
      return;
    }

    if($("#isFirst").val())
    {
      var url = '/initialize';
      var method = 'post';

      var success = function(request) {
      };
      var error = function(request) {
        console.error('유저 초기화 실패');
      };

      $.ajax({
        'url': url,
        'method': method,
        'success': success,
        'error': error
      });
    }


    function kakaoIconMove() {
      var elem = document.getElementById("kakao_chat_icon");   
      var pos = 0;
      var id = setInterval(frame, 5);
      //var initPosY = elem.style.bottom;
      var moveTarget = 60;
      function frame() {
        if (pos === moveTarget) {
          elem.style.bottom = moveTarget + "px";
          clearInterval(id);
        } else {
          pos++; 
          elem.style.bottom = pos + "px"; 
          //elem.style.left = pos + "px"; 
        }
      }
    }

    function kakaoIconInitMove() {
      var elem = document.getElementById("kakao_chat_icon");   
      var pos = 0;
      var id = setInterval(frame, 5);
      var initPosY = elem.style.bottom;
      function frame() {
        if (pos <= 0) {
          elem.style.bottom = 0;
          clearInterval(id);
        } else {
          pos--; 
          elem.style.bottom = pos + "px"; 
          //elem.style.left = pos + "px"; 
        }
      }
    }

    $("#kakao_chat_empty_area").mouseenter(function(){
      $("#kakao_chat_icon").fadeOut('slow');
    });

    $("#kakao_chat_empty_area").mouseleave(function(){
      $("#kakao_chat_icon").fadeIn('slow');
    });

    $(window).scroll(function() {
      $("#kakao_chat_icon").hide();
      $("#kakao_chat_ask").hide();
      
      clearTimeout($.data(this, 'scrollTimer'));
      $.data(this, 'scrollTimer', setTimeout(function() {
        $("#kakao_chat_icon").fadeIn('slow', function(){
          $("#kakao_chat_ask").show();
        });
      }, 1000));
    });
/*
    var scrollValue = $(document).scrollTop();
    $(window).scroll(function(){
      if($('.swal-overlay--show-modal').length > 0){
        $(document).scrollTop(0);
      }
      else{
        scrollValue = $(document).scrollTop()
      }

      console.error(scrollValue);
    });
    */
  });
</script>

<script type='text/javascript'>
    Kakao.init('0e5457b479dfe84c5e52e6de84d6d684');
    function plusFriendChat() {
      Kakao.PlusFriend.chat({
        plusFriendId: '_JUxkxjM' // 플러스친구 홈 URL에 명시된 id로 설정합니다.
      });
    }
</script>

</body>
</html>
