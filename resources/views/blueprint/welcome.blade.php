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
    </style>
@endsection

@section('content')
    <!-- first section 시작 -->
    <div class="apply-header ct-res-text">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-8 offset-md-4">
                <div class="row">
                    <h1>공연기획비용을 투자 받고,<br>
                    후원해 주신 분들께<br>멋진 공연으로 보답하세요!<br>
                     티켓 오픈 전<br>공연홍보기회는 덤으로!</h1>
                    <h3>크라우드티켓은 초기 공연기획비용 없이도 음악 콘서트, 토크 콘서트, 강연, 전시회, 파티, 각종 모임 등 모든 종류의 공연을 자유롭게 기획하게 티켓을 판매할 수 있는 열린 공간입니다.</h3>
                    <a href="#apply" class="ct-btn ct-btn-default">공연 개설 신청하기</a>
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
    <div class="ct-effect ct-res-text">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <img src="{{ asset('/img/app/money.png') }}">
                    <h2>공연 수익을 올려보세요!</h2>
                    <h3>싸인 CD, 로고가 들어간 텀블러 등으로 티켓 외 수익을 창출해 보세요! 약 30% 정도 공연 수익이 늘어날 수 있습니다.</h3>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <img src="{{ asset('/img/app/people.png') }}">
                    <h2>크라우드티켓 커뮤니티 속 여러분의 팬들과 더 가까워지세요!</h2>
                    <h3>공연에 후원해준 팬들의 리스트를 얻을 수 있습니다. 우리나라 공연예술을 가장 아끼는 그들과 소통해보세요.</h3>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <img src="{{ asset('/img/app/marketing.png') }}">
                    <h2>새로운 공연 홍보 수단</h2>
                    <h3>티켓 오픈 전 한달 정도의 기간으로 크라우드펀딩을 진행해보세요. 초기 자금도 얻을 수 있고 훨씬 더 많은 사람들이 SNS와 온라인에서 여러분의 공연을 접할 수 있게 됩니다.</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- second section 끝 -->
    <!-- third section 시작 -->
    <div class="ct-recommend ct-res-text">
        <div class="container">
            <h1>장르 불문, 아마추어부터 프로까지, 공연예술인이라면 누구나,<br>
            공연 초기 기획 비용을 펀딩 받으세요!</h1>
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
                <h1>크라우드티켓에서<br>
                공연 개설을 신청하세요!</h1>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <img src="{{ asset('img/app/img_blueprint_funding.png') }}" class="img-blueprint">
                        <h2>크라우드펀딩으로 공연기획, 도전!!</h2>
                        <h3>대관 등 공연기획이 어느 정도 되어있는 상태라도 크라우드펀딩을 이용하면 효과적인 홍보와 프로모션을 진행할 수 있습니다. </h3>
                        <a href="{{ url('blueprints/form?type=funding') }}" class="ct-btn ct-btn-default">펀딩 프로젝트 신청</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <img src="{{ asset('img/app/img_blueprint_ticket.png') }}" class="img-blueprint">
                        <h2>티켓 판매만 진행하고 싶습니다.</h2>
                        <h3>크라우드티켓의 간편한 결제시스템과 관객관리 툴을 저렴한 수수료로 이용해 보세요!</h3>
                        <a href="{{ url('blueprints/form?type=sale') }}" class="ct-btn ct-btn-default">티켓팅 프로젝트 신청</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- fourth section 끝 -->
@endsection
