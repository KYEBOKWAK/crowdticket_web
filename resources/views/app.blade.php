<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="naver-site-verification" content="8bce253ce1271e2eaa22bd34b508b72cc60044a5"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1"/>
    <meta name="facebook-domain-verification" content="761h35o1rdduhr3bz5xlvb05760144" />
    @section('meta')
      <meta name="description" content="영상으로만 닿을 수 있었던 크리에이터와 팬, 이제는 크티에서 팬밋업·강연·온라인 선물나눔·랜선팬미팅 등 다양한 이벤트로 더 깊이 소통하고 공감해보세요!"/>
    @show
    <script>
      // 모바일 에이전트 구분
      var g_isMobile={Android:function(){return null!=navigator.userAgent.match(/Android/i)},BlackBerry:function(){return null!=navigator.userAgent.match(/BlackBerry/i)},IOS:function(){return null!=navigator.userAgent.match(/iPhone|iPad|iPod/i)},Opera:function(){return null!=navigator.userAgent.match(/Opera Mini/i)},Windows:function(){return null!=navigator.userAgent.match(/IEMobile/i)},any:function(){return isMobile.Android()||isMobile.BlackBerry()||isMobile.IOS()||isMobile.Opera()||isMobile.Windows()}};
    </script>
    <script>
      var userAgent = window.navigator.userAgent;
      var isKakao = userAgent.indexOf('KAKAOTALK');
      // alert(window.location);
      if(isKakao > 0)
      {
        if(g_isMobile.Android()){
          let protocol = 'http'
          if(window.location.hostname === 'crowdticket.kr'){
            protocol = 'https';
          }

          let intentURL = window.location.host + window.location.pathname;
          location.href=`intent://${intentURL}#Intent;scheme=${protocol};package=com.android.chrome;end`
        }        
      }
    </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T94QPRD');</script>
    <!-- End Google Tag Manager -->

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1148233795612592');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1148233795612592&ev=PageView&noscript=1"
    /></noscript>
<!-- End Facebook Pixel Code -->

    @section('title')
        <title>크티 : 크라우드티켓 - 크리에이터 비즈니스 플랫폼</title>
    @show
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}"/>
    <link href="{{ asset('/css/lib/toast.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/base.css?version=12') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/app.css?version=10') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/main.css?version=7') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/global.css?version=21') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/jquery.toast.min.css') }}" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/login/login.css?version=5') }}" rel="stylesheet"/>

    <link href="{{ asset('/dist/css/Global.css?version=8') }}" rel="stylesheet"/>

    <link href="{{ asset('/dist/css/Profile.css?version=2') }}" rel="stylesheet"/>
    <link href="{{ asset('/dist/css/Footer_React.css?version=3') }}" rel="stylesheet"/>
    <link href="{{ asset('/dist/css/SearchPage.css?version=3') }}" rel="stylesheet"/>
    <link href="{{ asset('/dist/css/SelectBoxLanguage.css?version=1') }}" rel="stylesheet"/>

    <link href="{{ asset('/dist/css/InActivePage.css?version=0') }}" rel="stylesheet"/>

    <link href="{{ asset('/dist/css/App_Top_Banner.css?version=0') }}" rel="stylesheet"/>
    
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
      font-size: 11px;
      color: #acacac;
      text-align: center;
    }

    .register_popup_user_options_container{
      text-align: left;
    }

    .register_popup_user_options_container>p{
      font-size: 12px;
      color: #808080;
    }

    .register_radio_wrapper{
      position: relative;
    }

    .register_radio_img{
      display: none;
      position: absolute;
      top: 3px;
      left: 0px;
    }

    .register_radio_img_unselect{
      display: block;
    }

    .register_popup_user_gender_input[type="radio"]{
      width: 20px;
      margin-right: 0px;
      position: relative;
      opacity: 0;
      zoom: 1;
    }

    .register_popup_user_option_gender_text{
      font-size: 18px !important;
      margin-left: 12px;
    }

    .register_popup_user_age_container{
      width: 160px;
      height: 52px;
      border-radius: 5px;
      background-color: #f7f7f7;
      position: relative;
    }

    .register_popup_city_text_container{
      position: absolute;
      width: 100%;
      font-size: 16px;
      color: #4d4d4d;
      margin-top: 14px;
    }

    #register_popup_user_age_text{
      margin-left: 16px;
      margin-right: auto;
      font-size: 14px;
    }

    .register_age_user_select{
      width: 100%;
      height: 100%;
      opacity: 0;
    }

    footer {
      padding-top: 0px !important;
    }

    @media (max-width:1030px){
      #isMobile{
        display: block;
      }
    }

    /*3.5 START*/
    .navbar{
      min-width: 0;
      /* width: 1060px; */
      /* width: 100%; */
      /* max-width: 1176px; */
      min-height: 60px;

      margin-left: auto;
      margin-right: auto;
    }

    .navbar-default{
      border-bottom: 0px;
    }

    .navbar-brand{
      padding: 0px;
      height: auto;
      margin-top: 18px;
      margin-bottom: 18px;
    }

    .navbar-brand img{
      /*width: 141px;
      height: 16px;
      padding: 0px;*/
      width: 100%;
      /* height: 28px; */
      padding: 0px;
    }

    #ctNavBar{
      padding: 0px;
    }

    .navbar-nav>li>a{
      padding: 0px;
      margin-left: 40px;
      margin-top: 20px;
      margin-bottom: 20px;
      font-size: 13px;

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
      /* .navbar{
        min-width: 0;
        width: 93%;

        margin-left: auto;
        margin-right: auto;
      } */
    }

    @media (max-width:1030px){
      .kakao_chat_icon_wrapper{
        margin-bottom: 66px;
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
      /* .navbar-toggle{
        margin-top: 27px;
        margin-right: 0px;
      } */

      .navbar-brand{
        margin-top: 23px;
        margin-bottom: 23px;
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
        /* margin-bottom: 16px; */
        margin-bottom: 80px;
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
    <script type="text/javascript" src="{{ asset('/js/util_header.js?version=14') }}"></script>

    <!-- 카카오톡 sdk -->
    <script src="{{ asset('/js/lib/kakao.min.js?version=0') }}"></script>
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
<input id="g_app_type" type="hidden" value="{{env('APP_TYPE')}}"/>

<input type="hidden" id="g_language" value="@if(isset($language)){{$language}}@endif">

@yield('event_banner')
<div id="react_top_banner"></div>

@section('navbar')
<div id="navbar_fake_dom"></div>
<nav id="navbar_container" class="navbar navbar-default">
  <div id="navbar_box">
    <div class="navbar-header">
        
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#ctNavBar">
            <img src="{{ asset('/img/icons/svg/ic-menu.svg') }}"/>
        </button>

        <a href="javascript:;" id='button_search_mobile'>
          <img style='width: 32px; height: 32px;' src="{{ asset('/img/icons/svg/ic-search.svg') }}">
        </a>
        @if(!env('REVIEW_ON'))
          <a id='logo_home_link' class="navbar-brand" href="javascript:;">
              <img src="{{ asset('/img/icons/svg/logo-ct.svg') }}"/>
          </a>
        @endif
    </div>

    <div id="ctNavBar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
        @if(env('REVIEW_ON'))
          <li><a id='top_menu_magazine' href="javascript:;">매거진</a></li>
        @else
          <li>
            <a id='top_menu_store' href="javascript:;" style="display: inline-block;">콘텐츠 상점</a>
              <!-- <a href="{{ url('/mannayo') }}" style="display: inline-block;">만나요</a> -->
              <!-- <span style="position:relative; margin-left:2px; top:-4px; color:#43c9f0; font-size:10px">beta</span> -->
          </li>
          <li><a id='top_menu_fanevent' href="javascript:;">팬 이벤트</a></li>
          <!-- <li><a href="{{ url('/blueprints/welcome') }}">이벤트 만들기</a></li> -->
          <li><a id='top_menu_magazine' href="javascript:;">매거진</a></li>
        @endif
        </ul>

        

        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="javascript:;" id='button_search'>
              <img style='width: 24px; height: 24px;' src="{{ asset('/img/icons/svg/ic-search.svg') }}">
            </a>
          </li>
            @if (Auth::guest())
              <li id="g_login"><a id="top_side_menu_login" href="javascript:;" onclick="">로그인</a></li>
              <!-- <li id="g_register"><a href="javascript:;" onclick="">회원가입</a></li> -->
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-expanded="false">{{ Auth::user()->getUserNickName() }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <!-- <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}">내 페이지</a></li> -->
                        <!-- <li><a href="{{ url('/users/') }}/{{ Auth::user()->id }}/mannayo">내 만나요</a></li> -->
                        <li><a id="top_side_menu_profile_edit" href="{{ url('/users/') }}/{{ Auth::user()->id }}/form">프로필 수정</a></li>
                        @if(\Auth::user()->stores()->first())
                        <li><a id="top_side_menu_my_store" href="{{ url('/manager/store') }}">내 상점 관리</a></li>
                        @endif
                        <li><a id="top_side_menu_my_orders" href="{{ url('/users/store/') }}/{{ Auth::user()->id }}/orders">나의 콘텐츠 주문</a></li>
                        <li><a id="top_side_menu_my_events" href="{{ url('/users/') }}/{{ Auth::user()->id }}/orders">나의 이벤트 참여</a></li>
                        <li><a id="top_side_menu_logout" href="#" onclick="logout(); return false;">로그아웃</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
  </div>
</nav>
@show

<div id="main">
@if (Auth::guest())
  <input id='user_nickname' type='hidden' value=''/>
  <input id='user_age' type='hidden' value=''/>
  <input id='user_gender' type='hidden' value=''/>
@else
  <input id='user_nickname' type='hidden' value='{{\Auth::user()->getUserNickName()}}'/>
  <input id='user_age' type='hidden' value='{{\Auth::user()->getUserAge()}}'/>
  <input id='user_gender' type='hidden' value='{{\Auth::user()->getUserGender()}}'/>
@endif
    @yield('content')
</div>

@yield('react_main')

<div id="isMobile"></div>

<div id="g_go_login_react" style="display:none;"></div>
<div id="react_root"></div>
<div id="react_app_login"></div>
<div id="react_App_PC_776"></div>
<div id="react_inactive"></div>

<footer>
  <div id="react_footer">

  </div>
</footer>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/util.js?version=31') }}"></script>
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
  $loginFilePath = asset('/js/fblogin.js?fbid='.env('FACEBOOK_ID').'&fbver='.env('FACEBOOK_VER').'&ggid='.env('GOOGLE_ID').'&version=18');
?>
<script src="{{ $loginFilePath }}"></script>

<script>
function logout(){
      // var baseUrl = $('#base_url').val();
      // window.location.assign(baseUrl+'/auth/logout');

      $('.logout_react').trigger('click');
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
  });
</script>

<script type='text/javascript'>
    Kakao.init('f48f12644c731f65b78a3b0c6788f42e');
    function plusFriendChat() {
      Kakao.PlusFriend.chat({
        plusFriendId: '_JUxkxjM' // 플러스친구 홈 URL에 명시된 id로 설정합니다.
      });
    }

    function plusFriendHelpCenterChat() {
      Kakao.PlusFriend.chat({
        plusFriendId: '_gJyNK' // 플러스친구 홈 URL에 명시된 id로 설정합니다.
      });
    }
</script>

<script type="text/javascript" src="{{ asset('/dist/App.js?version=202') }}"></script>
<script type="text/javascript" src="{{ asset('/dist/App_Login.js?version=34') }}"></script>
<script type="text/javascript" src="{{ asset('/dist/App_PC_776.js?version=13') }}"></script>
<script type="text/javascript" src="{{ asset('/dist/App_Top_Banner.js?version=4') }}"></script>

</body>
</html>
