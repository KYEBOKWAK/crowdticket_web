@extends('app')
@section('meta')
   <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
@endsection
@section('css')
    <style>

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
		#main{
			padding-bottom:0px;
		}

    .landing-icon-grid{
      display: grid;
      /*grid-template-columns: 1fr 1fr 1fr 1fr;*/
      grid-template-columns: 1fr 1fr;

      width:73%;
      height: 100%;

      /*margin-top: 80px;
      margin-bottom: 80px;*/

      margin-top: 120px;
      margin-bottom: 120px;

      margin-left: auto;
      margin-right: auto;
    }

    .landing-icon-wrapping{
      text-align: center;
      width: 450px;
      margin-left: auto;
      margin-right: auto;
    }

    .landing-icon-wrapping img{
      width:40%;
      margin-left: auto;
      margin-right: auto;
    }

    .landing-icon-wrapping h2{
      font-size: 2rem;
      font-weight: 700;
      line-height: 1.5;
    }

    .landing-icon-wrapping p{
      font-size: 1.8rem;
      font-weight: 400;
      line-height: 1.8;
      letter-spacing: -1px;
    }

    .ct-btn-default{
      background-color: #ea535a;
      font-family: 'Noto Sans KR',sans-serif;
    }

    @media (max-width: 768px) {
      .landing-icon-grid{
        display: block;
        margin-top: 0px;
        margin-bottom: 0px;
      }

      .landing-icon-wrapping{
        width: 100%;
        margin-top: 90px;
      }

      .ct-btn-default{
        margin-top: 38px;
      }
    }
    </style>
@endsection

@section('content')
    <!-- first section 시작 -->

    <div class="apply-header ct-res-text">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-8 offset-md-4">
                <div class="row">
                    <h1>여러분의 공연 또는 이벤트,<br>
                    이제는 크라우드티켓에 올리세요!<br>
                     </h1>
                    <h3>크라우드티켓은 예술가부터 크리에이터까지 누구나 공연과 이벤트를 기획, 홍보하고 판매할 수 있는 공간입니다.</h3>
                    <button id="moveApply" type="button" class="ct-btn ct-btn-default">지금 시작하기</button>
                </div>
            </div>
            <div class="img-bg hidden-xs hidden-sm">
            </div>
        </div>
    </div>
    <div class="img-m-bg visible-xs visible-sm">
    </div>
    <!-- first section 끝 -->
    <!-- second section 시작 -->
    <div class="landing-icon-grid">
      <div class="landing-icon-wrapping animate-box">
        <img src="{{ asset('/img/app/feature1.png') }}">
        <h2>누구나 쉽게 티켓팅 개설</h2>
        <p>공연, 팬미팅, 강의, 모임 등 관객이 필요하다면 누구나 손쉽게 지금 바로 이벤트 개설이 가능합니다!</p>
      </div>
      <div class="landing-icon-wrapping animate-box">
        <img src="{{ asset('/img/app/feature2.png') }}">
        <h2>크라우드펀딩 기능</h2>
        <p>개성있는 공연/이벤트를 위한 최소 참가인원 또는 최소 준비 비용을 설정하고 기획을 해보세요! 아이디어만으로도 여러분의 무대를 만들 수 있습니다.</p>
      </div>
    </div>
    <div class="landing-icon-grid">
      <div class="landing-icon-wrapping animate-box">
        <img src="{{ asset('/img/app/feature3.png') }}">
        <h2>상품 판매 가능</h2>
        <p>티켓판매 뿐만 아니라 이벤트 관련 상품 판매와 후원까지 받을 수 있습니다! 여러분의 공연/이벤트 수익을 다양한 방법으로 높여보세요.</p>
      </div>
      <div class="landing-icon-wrapping animate-box">
        <img src="{{ asset('/img/app/feature4.png') }}">
        <h2>관객관리, 결제</h2>
        <p>귀찮은 결제와 정산 관리는 크라우드티켓에 맡기고, 관객 관리는 모바일로 더 간편하게 진행해보세요!</p>
      </div>
    </div>
    <!-- second section 끝 -->
    <!-- third section 시작 -->
    <div class="ct-recommend ct-res-text">
        <div class="container">
            <h1>장르불문, 아마추어부터 프로까지!<br>
            이미 많은 분들이 무대를 만들고 팬을 만났습니다.</h1>
            <div class="short-separator">
            </div>
            <div id="text-carousel" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="carousel-content">
                                    <div>
                                        <h2>크라우드티켓팀에서 SNS 마케팅에 큰 도움을 줬고, 그 덕분에 여러 번의 공연을 성공적으로 진행할 수 있었던 것 같습니다.</h2>
                                        <h3><i class="fa fa-user" aria-hidden="true">&nbsp;&nbsp;</i>힙합공연<br>밝히는 것들 기획 홍*민</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-content">
                                    <div>
                                        <h2>단순히 플랫폼을 이용한 것이 아니라 펀딩 홍보에도 많이 도움을 받았습니다.</h2>
                                        <h3><i class="fa fa-user" aria-hidden="true">&nbsp;&nbsp;</i>직장인 뮤지컬 극단<br>러뷰지컬 배우 홍*나</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-content">
                                    <div>
                                        <h2>이전 과는 다른 티켓팅이 가능할 것 같아서 크라우드티켓을 이용했습니다. 친절하게 공연 펀딩진행을 도와주셔서 큰 무리없이 공연 펀딩에 성공했습니다.</h2>
                                        <h3><i class="fa fa-user" aria-hidden="true">&nbsp;&nbsp;</i>프로젝트 극단<br>일리가있어 대표 박*찬</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-content">
                                    <div>
                                        <h2>공연전문 펀딩사이트라는 것이 가장 좋았습니다. 또한 펀딩 과정에서 크라우드티켓팀과의 소통이 매우 원활했습니다.</h2>
                                        <h3><i class="fa fa-user" aria-hidden="true">&nbsp;&nbsp;</i>백석대학교 연기예술학과 졸업 공연<br>코뿔소 기획팀</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Controls -->
                <a class="left carousel-control" href="#text-carousel" data-slide="prev" style="margin-top:50px; padding-right:30px;">
                <i class="fa fa-chevron-left" aria-hidden="true" "></i>
                </a>
                <a class="right carousel-control" href="#text-carousel" data-slide="next" style="margin-top:50px; padding-left:30px;">
                <i class="fa fa-chevron-right" aria-hidden="true" "></i>
                </a>
            </div>
        </div>
    </div>
    <!-- third section 끝 -->
    <!-- fourth section 시작 -->
    <div id="apply">
        <div class="goapply ct-res-text">
            <div class="container">
                <h1>지금 바로 <br>
                프로젝트를 시작해보세요!</h1>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <img src="{{ asset('img/app/img_blueprint_ticket.png') }}" class="img-blueprint">
                        <h2>공연/이벤트 페이지 개설</h2>
                        <h3>별도의 신청절차 없이 바로 페이지 제작을 시작할 수 있습니다. 크라우드티켓과 함께 공연/이벤트를 준비해보세요!</h3>
                        <a href="{{ url('blueprints/form?isProject=true') }}" class="ct-btn ct-btn-default">프로젝트 시작하기</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <img src="{{ asset('img/app/img_blueprint_funding.png') }}" class="img-blueprint">
                        <h2>협업 및 서비스 이용 문의하기</h2>
                        <h3>펀딩 기획 컨설팅, 홍보 콘텐츠 제작 등을 지원해드리고 있습니다. 이벤트 오픈 전 문의는 이쪽으로 해주세요! </h3>
                        <a href="{{ url('blueprints/form?isProject=false') }}" class="ct-btn ct-btn-default">제휴 문의</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- fourth section 끝 -->
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#moveApply').on("click",function(event){
                // 1. pre태그의 위치를 가지고 있는 객체를 얻어온다. => offset 객체
                var scrollPosition = $("#apply").offset().top;

                // offset은 절대 위치를 가져온다. offset.top을 통해 상단의 좌표를 가져온다.
                // position은 부모를 기준으로한 상대위치를 가져온다.
                $('html, body').animate({scrollTop : scrollPosition}, 1000);

            });
        });
    </script>
@endsection
