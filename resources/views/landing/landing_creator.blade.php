@extends('app')

@section('meta')
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:type" content="website"/>
<meta property="og:title" content="크라우드티켓"/>
<meta property="og:description" content="아티스트와 크리에이터를 위한 티켓팅 플랫폼"/>
<meta property="og:image" content="{{ asset('/img/app/og_image_1.png') }}"/>
<meta property="og:url" content="https://crowdticket.kr/"/>
@endsection

@section('css')
<style>
.navbar-default {
  position: static;
}
</style>

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<link rel="shortcut icon" href="favicon.ico">

<!-- Animate.css -->
<link rel="stylesheet" href="{{ asset('/landingcreator/css/animate.css?version=2') }}">
<link rel="stylesheet" href="{{ asset('/landingcreator/css/main.css?version=4') }}">

@endsection

@section('content')
<div class="landing-half-green-container-grid">
  <div class="landing-title-intro">
    <h1>크리에이터를 위한<br> 단 하나의<br> 오프라인 콘텐츠 플랫폼</h1>
    <h3>자유롭게 이벤트를 개설하고 팬들과 직접 만나 소통하세요.<br>
    크리에이터를 위한 티켓팅 서비스,<br> <b>CROWDTICKET CREATORS</b></h3>

    <div class="apply-btn-config">
      <button id="creatorMoveApply" type="button" class="ct-btn ct-btn-default">사전 신청하기</button>
    </div>
  </div>
  <div class="apply-btn-config-M">
    <button id="creatorMoveApply2" type="button" class="ct-btn ct-btn-default">사전 신청하기</button>
  </div>
  <div class="landing-title-img-wrapping">
  </div>
  <div class="landing-title-img-wrapping-M">
    <img src="{{ asset('/img/app/create-title-m.jpg') }}">
  </div>
</div>

<div class="landing-center-container">
  <div class="landing-question-scrolling-wrapping">
    <b>
      <span>
        크리에이터의 팬미팅<br />
        먹방 크리에이터 시청자와 함께하는 맛집 투어<br />
        뷰티 크리에이터의 메이크업 시연 행사<br />
        요가/필라테스 SNS 인플루언서와 함께 운동하기<br />
        영화 리뷰 크리에이터의 영화 감상회<br />
        뮤직 크리에이터의 라이브 공연<br />
        게임 스트리머와 pc방에서 함께하는 게임 토너먼트<br />
        장난감 리뷰 크리에이터와 함께하는 가족 나들이<br />
        영어 교육 콘텐츠 크리에이터의 오프라인 강습<br />
        그리고 당신만의 오프라인 컨텐츠
        </span>
    </b>
  </div>
  <div class="landing-scrolling-contant-wrapping">
    <!-- <p class="landing-scrolling-contant-sub-1 animate-box">그리고 당신만의 오프라인 컨텐츠</p> -->
    <p class="landing-scrolling-contant-sub-2 animate-box">이제는 팬 관리를 위해 꼭 필요한 오프라인 이벤트,<br>개설 & 관리는 어디서 어떻게 할까요?</p>
  </div>
</div>
<div class="landing-icon-grid">
  <div class="landing-icon-wrapping animate-box">
    <img src="{{ asset('/img/app/icon-people.png') }}">
    <h2>00 명이 모여야 이벤트 개설</h2>
    <p>개성있는 오프라인 콘텐츠 제작을 위한 최소 참가 인원을 설정하고 안전하게 기획할 수 있습니다.</p>
  </div>
  <div class="landing-icon-wrapping animate-box">
    <img src="{{ asset('/img/app/icon-card.png') }}">
    <h2>인증서가 필요없는 간편카드결제</h2>
    <p>결제와 정산은 크라우드티켓에 맡기고 컨텐츠에 집중할 수 있습니다.</p>
  </div>
</div>
<div class="landing-icon-grid">
  <div class="landing-icon-wrapping animate-box">
    <img src="{{ asset('/img/app/icon-mobiletk.png') }}">
    <h2>참가자 관리, 검표기능</h2>
    <p>모바일로 간편 하게 현장 참가자를 관리 할 수 있습니다.</p>
  </div>
  <div class="landing-icon-wrapping animate-box">
    <img src="{{ asset('/img/app/icon-gift.png') }}">
    <h2>굿즈 판매가 가능한 티켓팅 서비스</h2>
    <p>티켓과 굿즈를 함께 판매하여 수익성이 높은 이벤트를 기획할 수 있습니다.</p>
  </div>
</div>
<div class="landing-apply-contain">
  <h2>크라우드티켓과 콘텐츠의 판을 바꿀 단 10명의 크리에이터를 찾습니다.</h2>
  <img src="{{ asset('/img/app/creatorlanding.png') }}"/>
  <h3>2018년 9월, CROWDTICKET CREATORS가 여러분을 만납니다.</h3>
  <h3>가장 먼저 이벤트 등록을 예약하세요.</h3>
  <h3>크라우드티켓팀이 기획에서 홍보까지 함께합니다.</h3>
  <button type="button" onclick="window.open('{{ url('/landing/form') }}')" class="ct-btn ct-btn-apply">사전 신청하기</button>
</div>

@endsection

@section('js')

<!-- Waypoints -->
<script src="{{ asset('/landingcreator/js/jquery.waypoints.min.js') }}"></script>
<!-- MAIN JS -->
<script src="{{ asset('/landingcreator/js/main.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#creatorMoveApply').on("click",function(event){
            // 1. pre태그의 위치를 가지고 있는 객체를 얻어온다. => offset 객체
            var scrollPosition = $(".landing-apply-contain").offset().top;

            // offset은 절대 위치를 가져온다. offset.top을 통해 상단의 좌표를 가져온다.
            // position은 부모를 기준으로한 상대위치를 가져온다.
            $('html, body').animate({scrollTop : scrollPosition}, 1000);

        });

        $('#creatorMoveApply2').on("click",function(event){
            // 1. pre태그의 위치를 가지고 있는 객체를 얻어온다. => offset 객체
            var scrollPosition = $(".landing-apply-contain").offset().top;

            // offset은 절대 위치를 가져온다. offset.top을 통해 상단의 좌표를 가져온다.
            // position은 부모를 기준으로한 상대위치를 가져온다.
            $('html, body').animate({scrollTop : scrollPosition}, 1000);

        });
    });
</script>

@endsection
