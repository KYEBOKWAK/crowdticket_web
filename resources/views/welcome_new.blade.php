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
    <link href="{{ asset('/css/welcome.css?version=3') }}" rel="stylesheet">
@endsection

@section('content')
      @include('template.carousel_main')
    <!-- first section 끝 -->
    <!-- second section 시작 -->
      <div class="welcome_main_thumb_container">
        <div class="welcome_main_thumb_title_container">
          <h4 style="float:left">크라우드 티켓 추천</h4>
          <!-- Controls -->
          <div class="controls pull-right">
              <a href="#ct-recommend" data-slide="prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></a><a href="#ct-recommend" data-slide="next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
          </div>
        </div>

        <div id="ct-recommend" class="carousel slide">
                  <!-- Wrapper for slides -->
          <div class="carousel-inner">
            @include('template.carousel_main_project', ['projects' => $projects ])
          </div>
        </div>
      </div>

    <!-- 크라우드 티켓 브랜딩 영역 시작 -->
    <div class="container-fluid ct-res-text">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 main-leftimgbox">
                <div class="imgbox-overlay">
                </div>
                <h1 style="word-break:keep-all;">티켓, 그 이상의 경험, 크라우드티켓팅</h1>
                <a href="{{ url('blueprints/welcome') }}" class="ct-btn ct-btn-default" style="background-color:#EF4D5D;">프로젝트 개설하기</a>
            </div>
        </div>
    </div>
    <!-- 크라우드 티켓 브랜딩 영역 끝 -->
<input type="hidden" id="isNotYet" value="{{ $isNotYet }}">
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

            if($("#isNotYet").val() == "TRUE"){
              alert("준비중입니다.");
            }
        });
    </script>
    <script src="{{ asset('/js/project/jssor.slider.min.js') }}"></script>
@endsection
