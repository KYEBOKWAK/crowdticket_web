@extends('app')
@section('meta')
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="크라우드티켓"/>
    <meta property="og:description" content="아티스트와 크리에이터를 위한 티켓팅 플랫폼"/>
    <meta property="og:image" content="{{ asset('/img/app/og_image_1.png') }}"/>
    <meta property="og:url" content="https://crowdticket.kr/"/>
@endsection
@section('css')
    <style>
        .navbar-default {
            background-color:rgba(0,0,0,0);
        }
        .ps-welcome-header {
            height:500px;
            background-image:url("{{ asset('/img/app/welcome_header_bg_2.jpg') }}");
            position:relative;
        }
        .ps-welcome-header h1 {
            text-align:center;
            margin-bottom:0px;
            font-weight:bold;
            font-size:60px;
        }
        .ps-welcome-header p {
            font-size:18px;
            font-weight:bold;
            text-align:center;
            margin-bottom:100px;
        }
        .ps-welcome-card {
            width:700px;
            padding:16px;
            margin:17px auto 0 auto;
            text-align:center;
            background-color:rgba(126,197,42,0.7);
            color:#FFFFFF;
            font-weight:bold;
        }
        .ps-welcome-buttons {
            margin-top:2em;
        }
        .ps-header-message {
            padding-top:150px;
            width:100%;
            height:100%;
            position:absolute;
            top:0;
            bottom:0;
            background-color:rgba(0,0,0,0.2);
        }
        .ps-welcome-header .btn {
            color:white;
            background:none;
            border-radius:0;
            border:2px solid white;
        }
        .ps-detail-title {
            font-size:20px;
            color:#666;
        }
        .ps-project-wrapper {
            margin-bottom:20px;
        }
        .ps-help-wrapper {
            width:100%;
            margin-top:30px;
            padding:0px 0 50px 0;
            background-color:#edefed;
        }
        .ps-help-wrapper .ps-help {
            padding-top:20px;
            padding-bottom:20px;
            border-bottom:1px solid #dedede;
        }
        .ps-help-wrapper .ps-help.no-border {
            border:none;
        }
        .ps-help-wrapper .ps-help:last-child {
            margin-bottom:0px;
        }
        .ps-help-wrapper h4 {
            font-weight:bold;
            font-size:22px;
        }
        .ps-help-wrapper p {
            font-size:14px;
        }
        .ps-help-wrapper .col-md-9 {
            padding-top:10px;
        }
        .ps-help-wrapper .ps-detail-title {
            font-size:30px;
        }
        #main {
            padding-bottom:0px;
        }
        .ps-banner {
            margin-top:50px;
            margin-bottom:70px;
        }
    </style>
@endsection

@section('content')
    <div class="ct-header">
        <div class="header-container">
            <div class="video-container">
                <video autoplay loop id="video-background" muted plays-inline><source src="{{ asset('/img/app/headerbackground.mp4') }}" type="video/mp4"></video>
                <div class="container header-content">
                    <h1>BE ON STAGE,<br>
                     BEYOND STAGE</h1>
                    <h3>관객과 예술가가 하나되어 만드는 공연</h3>
                    <a href="{{ url('/projects') }}" class="ct-btn ct-btn-default">지금 함께하기</a>
                </div>
            </div>
            <div class="header-overlay">
            </div>
        </div>
    </div>
    <!-- first section 끝 -->
    <!-- second section 시작 -->
    <div class="container">
        <div class="row mainthumb">
            <div class="row">
                <div class="col-md-9">
                    <h4>크라우드티켓 추천</h4>
                </div>
                <div class="col-md-3">
                    <!-- Controls -->
                    <div class="controls pull-right">
                        <a href="#carousel-example-generic" data-slide="prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></a><a href="#carousel-example-generic" data-slide="next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    @include('template.carousel_project', ['projects' => $projects ])
                </div>
            </div>
        </div>
    </div>
    <!-- second section 끝 -->
    <!-- third section 시작 -->
    <div class="container-fluid ct-res-text">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 main-leftimgbox">
                <div class="imgbox-overlay">
                </div>
                <h1>우리 공연예술을<br>
                 사랑하는 방법</h1>
                <h3>기획단계의 공연에 투자하면 공연자는 초기 자금을 확보할 수 있고 공연의 질은 올라갑니다! 우리 공연에 투자하고 티켓으로 보상받으세요!</h3>
                <a href="{{ url('/auth/register') }}" class="ct-btn ct-btn-default">30초 만에 회원가입</a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 main-rightimgbox">
                <div class="imgbox-overlay">
                </div>
                <h1>제일 먼저, 가장 싸게<br>
                 공연티켓을 구입하세요!</h1>
                <h3>단순 관객이 아닌 서포터가 되어 보세요. 그리고 크라우드티켓에서만 얻을 수 있는 특별 보상이 여러분을 기다립니다. 지금 바로 참여해 보세요! </h3>
                <a href="{{ url('/projects') }}" class="ct-btn ct-btn-default">전체 공연 보기</a>
            </div>
        </div>
    </div>
    <!-- third section 끝 -->
    <!-- fifth section 시작 -->
    <div class="container-fluid counter-bg">
        <div class="container counter ct-res-text">
            <h1>벌써 공연 좀 볼 줄 아는 많은 사람들이 크라우드티켓 커뮤니티에 참여했습니다.</h1>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <h2>누적 공연 후원자수</h2>
                <div class="short-separator">
                </div>
                <h1 class="counting"><span class="count-ani"> {{ $total_suppoter }} </span><span>&nbsp;명</span></h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <h2>공연 조회수</h2>
                <div class="short-separator">
                </div>
                <h1 class="counting"><span class="count-ani"> {{ $total_view }} </span><span>&nbsp;명</span></h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <h2>누적 펀딩 금액</h2>
                <div class="short-separator">
                </div>
                <h1 class="counting"><span class="count-ani"> {{ $total_amount }} </span><span>&nbsp;원</span></h1>
            </div>
        </div>
    </div>
    test
@endsection

@section('js')

    <!-- facebook login check -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '{{env('FACEBOOK_ID')}}',
          cookie     : true,  // enable cookies to allow the server to access
                              // the session
          xfbml      : true,  // parse social plugins on this page
          version    : '{{env('FACEBOOK_VER')}}' // use graph api version 2.8
        });
        console.log("FB Init Success!!!!!");
      };
    </script>


    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <script src="{{ asset('/js/jquery.counterup.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.count-ani').counterUp({
                delay: 10,
                time: 1000
            });
        });
    </script>
@endsection
