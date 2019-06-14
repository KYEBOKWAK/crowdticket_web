@extends('app')
@section('meta')
   <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
@endsection
@section('css')
    <style>
        .blueprint_welcome_container{
            position: relative;
            top: 140px;
            height: 3720px;
        }

        .blueprint_welcome_title{
            margin-bottom: 0px;
        }

        .blueprint_welcome_title>h4{
            font-size: 32px;
            font-weight: 500;
            line-height: 1.38;
        }

        .blueprint_welcome_title>p{
            margin-top: 28px;
            font-size: 20px;
            margin-bottom: 0px;
        }

        .blueprint_welcome_start_container{
            width: 440px; 
            height: 566px; 
            background-color:white; 
            position:absolute;
            border-radius: 10px;
            box-shadow: 2px 2px 12px 0 rgba(0, 0, 0, 0.1);
            top: 160px; 
            right:15%;
        }

        .blueprint_welcome_start_form_container{
            margin-right: 30px;
            margin-left: 30px;
            margin-top: 30px;
        }

        .blueprint_start_button_wrapper{
            text-align: center;
        }

        .form-group{
            margin-bottom: 28px;
        }

        .blue_button{
            border-radius: 5px;
            background-color: #43c9f0;
            font-size: 20px;
            font-weight: 500;
            border-color: white;
            color: white;
        }

        #blueprint_start_button{
            width: 154px;
            height: 56px;
        }

        .bluprint_carousel_container{
            margin-top: 40px;
        }

        .blueprint_slide_button_container{
            margin-bottom: 36px;
        }

        .blueprint_solution_container{
            margin-top: 293px;
        }

        .blueprint_solution_container>h4{
            font-size: 32px;
            font-weight: 500;
            line-height: 1.38;
            color: #1a1a1a;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .swiper-container{
            /*height: 300px;*/
        }

        .swiper-pagination{
            top: 0 !important;
        }

        .swiper-slide{
            height: 250px !important;
        }

        .blueprint_slide_button {
            display: inline;
            width: 78px;
            font-weight: 500;
            text-align: center;
            line-height: 20px;
            font-size: 16px;
            color:#acacac;
            border-radius: 0;
            margin: 0;
            margin-right: 16px;
            background-color: white;
            border: 0;
            padding: 0;
            padding-bottom: 8px;
            cursor:pointer
        }

        .blueprint_slide_button_active {
            color: black;
            border-bottom: 2px solid #43c9f0;
        }

        .blueprint_carousel_box{
            width: 250px;
            height: 250px;
            border-radius: 10px;
            background-color: #f7f7f7;
            margin-left: 20px;
        }

        .bluprint_carousel_box_circle{
            width: 120px;
            height: 120px;
            background-color: white;
            border-radius: 100%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 43px;
        }

        .blueprint_carousel_box_content_wrapper{
            text-align: center;
            font-size: 16px;
            font-weight: 500;
            margin-top: 20px;
        }

        .blueprint_container{
            margin-top: 120px;
        }

        .blueprint_container_title>h4{
            font-size: 32px;
            font-weight: 500;
            line-height: 1.38;
            margin-bottom: 0px;
        }

        .blueprint_who_make_box{
            display: inline-block;
            width: 160px;
            height: 113px;
            text-align: center;
        }

        .blueprint_who_make_container{
            margin-top: 40px;
        }

        .blueprint_take_container{
            margin-top: 317px;
            width: 100%;
            height: 468px;
        }

        .bluprint_played_event_content{
            font-size: 14px;
            line-height: 1.57;
            margin-top: 28px;
        }

        .blueprint_how_to_start_container{
            width: 100%;
        }

        .blueprint_how_to_start_title{
            font-size: 32px;
            font-weight: 500;
            line-height: 1.38;
            color: #333333;
        }

        .blueprint_how_to_number_background{
            width: 34px;
            height: 34px;
            border-radius: 100%;
            background-color: #f7f7f7;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            padding: 4px;
        }

        .blueprint_how_to_start_content{
            font-size: 20px;
            line-height: 1.7;
        }

        .blueprint_how_to_number_background_wrapper{
            width: 34px;
            margin-right: 20px;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('/css/swiper/swiper.min.css?version=1') }}">
@endsection

@section('content')
    <!-- first section 시작 -->
    <div style="width: 100%; height: 487px; background-color: #f7f7f7; position: absolute;">
    </div>

    <div style="width: 100%; height: 600px; background-color: #f7f7f7; position: absolute; top: 1745px;">
    </div>

    <div class="blueprint_played_event_img" style="width: 100%; height: 600px; background-color: #f7f7f7; position: absolute; top: 2687px;">
    </div>
    
    <div class="welcome_content_container blueprint_welcome_container">
        <div class="blueprint_welcome_title">
            <h4>
                팬들과 같이 만드는<br>
                내 콘텐츠의 새로운 가치
            </h4>
            <p>
            지금 바로 이벤트 페이지를 개설하고<br>
            팬들과 직접 만나 새로운 경험을 만들어 보세요
            </p>
        </div>
        
        

        <div class="blueprint_solution_container">
            <h4>
                크리에이터를 위한<br>이벤트 원스탑 솔루션
            </h4>
            <div class="bluprint_carousel_container">
                <div class="blueprint_slide_button_container">
                    <div id="slide_move_0" class="blueprint_slide_button blueprint_slide_button_active" type="button">이벤트 기획</div>
                    <div id="slide_move_1" class="blueprint_slide_button" type="button">티켓팅 진행</div>
                    <div id="slide_move_2" class="blueprint_slide_button" type="button">현장 관리</div>
                </div>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @for($i = 0 ; $i < 3 ; $i++)
                        <div class="swiper-slide">
                            <div class="flex_layer">
                                @for($j = 0 ; $j < 4 ; $j++)
                                <?php
                                    $iconURL = "";
                                    $content1 = "";
                                    $content2 = "";
                                    if($i === 0)
                                    {
                                        if($j === 0)
                                        {
                                            $iconURL = "티켓이미지";
                                            $content1 = "크리에이터 맞춤형";
                                            $content2 = "콘셉트 제안";
                                        }
                                        else if($j === 1)
                                        {
                                            $iconURL = "폭죽";
                                            $content1 = "이벤트 분위기에";
                                            $content2 = "딱 맞는 장소 대관";
                                        }
                                        else if($j === 2)
                                        {
                                            $iconURL = "병,옷";
                                            $content1 = "이벤트 진행 규모 및";
                                            $content2 = "예산 컨설팅";
                                        }
                                        else if($j === 3)
                                        {
                                            $iconURL = "사람 돈";
                                            $content1 = "티켓 / 베너 제작 ";
                                            $content2 = "";
                                        }
                                    }
                                    else if($i === 1)
                                    {
                                        if($j === 0)
                                        {
                                            $iconURL = "티켓이미지 2";
                                            $content1 = "크리에이터 맞춤형 2";
                                            $content2 = "콘셉트 제안 2";
                                        }
                                        else if($j === 1)
                                        {
                                            $iconURL = "폭죽 2";
                                            $content1 = "이벤트 분위기에 2";
                                            $content2 = "딱 맞는 장소 대관 2";
                                        }
                                        else if($j === 2)
                                        {
                                            $iconURL = "병,옷 2";
                                            $content1 = "이벤트 진행 규모 및 2 ";
                                            $content2 = "예산 컨설팅 2";
                                        }
                                        else if($j === 3)
                                        {
                                            $iconURL = "사람 돈 2";
                                            $content1 = "티켓 / 베너 제작 2";
                                            $content2 = "";
                                        }
                                    }
                                    else if($i === 2)
                                    {
                                        if($j === 0)
                                        {
                                            $iconURL = "티켓이미지 3";
                                            $content1 = "크리에이터 맞춤형 3";
                                            $content2 = "콘셉트 제안 3";
                                        }
                                        else if($j === 1)
                                        {
                                            $iconURL = "폭죽 3";
                                            $content1 = "이벤트 분위기에 3";
                                            $content2 = "딱 맞는 장소 대관 3";
                                        }
                                        else if($j === 2)
                                        {
                                            $iconURL = "병,옷 3";
                                            $content1 = "이벤트 진행 규모 및 3";
                                            $content2 = "예산 컨설팅 3";
                                        }
                                        else if($j === 3)
                                        {
                                            $iconURL = "사람 돈 3";
                                            $content1 = "티켓 / 베너 제작 3";
                                            $content2 = "";
                                        }
                                    }
                                ?>
                                    <div class="blueprint_carousel_box" style="@if($j===0)margin-left: 0px;@endif">
                                        <div class="bluprint_carousel_box_circle">
                                            <span>{{$iconURL}}</span>
                                        </div>
                                        <div class="blueprint_carousel_box_content_wrapper">
                                            {{$content1}}<br>
                                            {{$content2}}
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <div class="blueprint_container">
            <div class="blueprint_container_title">
                <h4>
                    이벤트는 누가 만들 수 있나요?
                </h4>
            </div>

            <div class="blueprint_who_make_container">
                @for($i = 0 ; $i < 8 ; $i++)
                <?php
                $whoMakeImgURL = "";
                $whoMakeContent = "";
                switch($i)
                {
                    case 0:
                    $whoMakeImgURL = "유투브 이미지";
                    $whoMakeContent = "유튜브 크리에이터";
                    break;

                    case 1:
                    $whoMakeImgURL = "라이브 이미지";
                    $whoMakeContent = "라이브 방송 스트리머";
                    break;

                    case 2:
                    $whoMakeImgURL = "팟캐스트 이미지";
                    $whoMakeContent = "팟캐스트 진행자";
                    break;

                    case 3:
                    $whoMakeImgURL = "하트 이미지";
                    $whoMakeContent = "SNS 인플루언서";
                    break;

                    case 4:
                    $whoMakeImgURL = "MCN 이미지";
                    $whoMakeContent = "MCN 소속 매니저/기획자";
                    break;

                    case 5:
                    $whoMakeImgURL = "음표 이미지";
                    $whoMakeContent = "가수/뮤지션";
                    break;

                    case 6:
                    $whoMakeImgURL = "책 이미지";
                    $whoMakeContent = "문화기획단체 / 커뮤니티";
                    break;

                    case 7:
                    $whoMakeImgURL = "번개 이미지";
                    $whoMakeContent = "그외 모든 크리에이터";
                    break;
                }
                ?>
                <div class="blueprint_who_make_box">
                    <div class="img_dummy" style="width: 80px; height: 80px; margin: 0px auto; padding-top: 30px;">
                        {{$whoMakeImgURL}}
                    </div>
                    <div class="blueprint_who_make_content">
                        {{$whoMakeContent}}
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <div class="blueprint_container blueprint_take_container">
            이벤트에 대해 1도 몰라도 괜찮아요?
        </div>

        <div class="blueprint_container text-center" style="height: 820px;">
            <div class="blueprint_container_title">
                <h4>
                    이미 다양한 형태의 이벤트가<br>
                    크라우드티켓에서 진행됐습니다
                </h4>
            </div>

            <div class="bluprint_played_event_content">
                크라우드티켓에서 만들 수 있는 이벤트에 제한은 없습니다.<br>
                크리에이터 여러분의 무한한 상상력으로 세상을 즐겁게 바꿀 오프라인 콘텐츠를 마음껏 만들어주세요.
            </div>

        </div>

        <div class="blueprint_container">
            <div class="flex_layer">
                <div class="blueprint_how_to_start_container">
                    <div class="blueprint_how_to_start_title">
                        화면 밖에서 나의 팬을 만나는<br>
                        완전 쉬운 방법
                    </div>

                    <button id="blueprint_start_up_button" class="blue_button" style="width: 154px; height: 56px; margin-top: 40px" type="button">시작하기</button>
                </div>

                <div class="blueprint_how_to_start_container">
                    <div class="blueprint_how_to_start_content">
                        <div class="flex_layer" style="margin-bottom: 24px; height: 68px;">
                            <div class="blueprint_how_to_number_background_wrapper">
                                <div class="blueprint_how_to_number_background">1</div>
                            </div>
                            <p>내 이름과 만들고 싶은 이벤트 종류, 연락처만 적고 '시작하기'를 누른다.</p>
                        </div>

                        <div class="flex_layer" style="margin-bottom: 24px; height: 68px;">
                            <div class="blueprint_how_to_number_background_wrapper">
                                <div class="blueprint_how_to_number_background">2</div>
                            </div>
                            <p>아직 회원가입을 안 했다면 이름, 이메일, 비밀번호만 적고 10초만에 가입을 끝낸다</p>
                        </div>

                        <div class="flex_layer" style="margin-bottom: 24px; height: 68px;">
                            <div class="blueprint_how_to_number_background_wrapper">
                                <div class="blueprint_how_to_number_background">3</div>
                            </div>
                            <p>이벤트 소개 내용을 직접 쓰거나 크라우드티켓에게 맡긴다</p>
                        </div>

                        <div class="flex_layer" style="margin-bottom: 24px; height: 68px;">
                            <div class="blueprint_how_to_number_background_wrapper">
                                <div class="blueprint_how_to_number_background">4</div>
                            </div>
                            <p>티켓팅 페이지가 오픈 되면 곧바로 나의 이벤트를 팬들에게 알린다!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blueprint_welcome_start_container">
        <div class="blueprint_welcome_start_form_container">
            <div class="form-group">
                <label class="cr_label">이벤트 개설자</label>
                <input class="form-control cr_input" placeholder="뮤지션 ‘000’, 먹방 BJ ‘000’, 게임 스트리머 ‘000’">
            </div>
            <div class="form-group">
                <label class="cr_label">계획중인 이벤트</label>
                <input class="form-control cr_input" placeholder="팬미팅, 팬들과 함께하는 먹방 투어">
            </div>
            <div class="form-group">
                <label class="cr_label">이메일</label>
                <input class="form-control cr_input">
            </div>
            <div class="form-group">
                <label class="cr_label">전화번호</label>
                <input class="form-control cr_input">
            </div>

            <div class="blueprint_start_button_wrapper">
                <button id="blueprint_start_button" type="button" class="blue_button">시작하기</button>
            </div>
        </div>
    </div>
    
    <!-- fourth section 끝 -->
@endsection

@section('js')
    <script src="{{ asset('/js/swiper/swiper.min.js?version=1') }}"></script>
    <script>
        $(document).ready(function () {
            /*
            $('#moveApply').on("click",function(event){
                // 1. pre태그의 위치를 가지고 있는 객체를 얻어온다. => offset 객체
                var scrollPosition = $("#apply").offset().top;

                // offset은 절대 위치를 가져온다. offset.top을 통해 상단의 좌표를 가져온다.
                // position은 부모를 기준으로한 상대위치를 가져온다.
                $('html, body').animate({scrollTop : scrollPosition}, 1000);

            });
            */

            var blueprintStart = function(){
                if(isLogin() == false)
                {
                    //alert("로그인을 해야 댓글을 달 수 있습니다.");
                    loginPopup(blueprintStart, null);
                    return;
                }

                showLoadingPopup("프로젝트 개설중입니다..");
            };

            $("#blueprint_start_button").click(function(){
                blueprintStart();
            });

            var swiper = new Swiper('.swiper-container', {
                slidesPerView: 1,
                spaceBetween: 20
            });

            var changeSlideButtonActive = function(index){
                for(var i = 0 ; i < 3 ; i++)
                {
                    var buttonId = "#slide_move_"+i;
                    $(buttonId).removeClass("blueprint_slide_button_active");
                    
                    if(i === index)
                    {
                        $(buttonId).addClass("blueprint_slide_button_active");
                    }
                }
            };


            swiper.on('slideChange', function() { 
                //console.error(this);
                changeSlideButtonActive(this.activeIndex);
            });

            $("#slide_move_0").click(function(){
                swiper.slideTo(0);
            });
            $("#slide_move_1").click(function(){
                swiper.slideTo(1);
            });
            $("#slide_move_2").click(function(){
                swiper.slideTo(2);
            });
            
            $("#blueprint_start_up_button").click(function(){
                $('html, body').animate({scrollTop : 0}, 1000);
            });
            
        });
    </script>
@endsection
