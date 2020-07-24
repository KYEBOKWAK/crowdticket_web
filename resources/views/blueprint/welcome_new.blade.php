@extends('app')
@section('meta')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="크티 : 이벤트 만들기"/>
    <meta property="og:description" content="팬을 위한 크리에이터 이벤트를 만들어보세요!"/>
    <meta property="og:image" content="{{ asset('/img/app/og_image_3.png') }}"/>
    <meta property="og:url" content="https://crowdticket.kr/blueprints/welcome"/>
    <meta property="description" content="팬을 위한 크리에이터 이벤트를 만들어보세요!"/>
@endsection
@section('title')
    <title>크티 : 이벤트 만들기</title>
@endsection
@section('css')
    <style>
        .blueprint_welcome_container{
            position: relative;
            top: 140px;
            height: 3800px;
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
            color: #4d4d4d;
        }

        .blueprint_welcome_start_container{
            width: 454px; 
            /*height: 566px; */
            height: auto;
            background-color:white; 
            position:absolute;
            border-radius: 10px;
            box-shadow: 2px 2px 12px 0 rgba(0, 0, 0, 0.1);
            top: 160px; 
            right:15%;
            padding-bottom: 32px;
        }

        .blueprint_welcome_start_container_mobile{
            width: 100%;
            text-align: left;
        }

        .blueprint_welcome_start_form_container{
            margin-right: 32px;
            margin-left: 32px;
            margin-top: 32px;
        }

        .blueprint_start_button_wrapper{
            text-align: center;
        }

        .form-group{
            margin-bottom: 28px;
        }

        .blue_button{
            width: 100%;
            height: 56px;

            border: 0px;

            -webkit-border-radius: 5px;
	        -moz-border-radius: 5px;
            border-radius: 5px;

            background-color: #43c9f0;
            font-size: 20px;
            font-weight: 500;
            /*border-color: white;*/
            color: white;
        }

        #blueprint_start_button{
            
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
            display: none;
            position: relative !important;
            margin-bottom: 16px;
        }

        .swiper-pagination-bullet{
            margin-right: 4px;
            width: 4px !important;
            height: 4px !important;
            border-radius: 4px !important;
            background-color: #ebebeb !important;
            opacity: 1 !important;
        }

        .swiper-pagination-bullet-active{
            width: 12px !important;
            height: 4px !important;
            background-color: #acacac !important;
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
            /*height: 44px;*/
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
            height: 103px;
            text-align: center;
            margin-top: 40px;
        }

        .blueprint_who_make_container{
            margin-top: 0px;
        }

        .blueprint_take_container{
            margin-top: 240px;
            width: 100%;
            /*height: 816px;*/
        }

        .bluprint_played_event_content{
            font-size: 14px;
            line-height: 1.57;
            margin-top: 28px;
            color: #4d4d4d
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
            color: #808080;
        }

        .blueprint_how_to_start_content p{
            color: #4d4d4d;
        }

        .blueprint_title_wrapper{
            width: 100%;
            margin-bottom: 20px;
            position: absolute;
            overflow: hidden;
        }

        .blueprint_title_img{
            width: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform:translateX(-50%);
            /*bottom: 0px;*/
            bottom: 50%;
            right: 0px;
            margin: auto;
        }

        .blueprint_title_image_container{
            /*width: 320px;*/
            width: 100%;
            height: 488px;
            margin-left: auto;
            margin-right: auto;
            overflow: hidden;
        }

        .blueprint_who_make_content{
            font-size: 14px;
            line-height: 1.57;
            color: #333333;
        }

        .blueprint_talk_container{
            width: 100%;
        }

        .blueprint_talk_bubble_wrapper{
            margin-bottom: 40px;
        }

        .blueprint_talk_wrapper{
            /*width: 400px;*/
            width: 100%;
        }

        .slide-test{
            background-color: antiquewhite;
            height: 320px;
        }

        .blueprint_played_image_container{
            width: 100%;
            height: 320px;
            margin-left: auto;
            margin-right: auto;
            overflow: hidden;
        }

        .blueprint_played_image{
            width: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform:translateX(-50%);
            /*bottom: 0px;*/
            bottom: 50%;
            right: 0px;
            margin: auto;
        }

        .blueprint_played_tags_container{
            width: 518px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 40px;
        }

        .blueprint_played_tag_bg{
            width: 74px;
            height: 40px;
            border-radius: 20px;
            background-color: #f7f7f7;
            font-size: 12px;
            margin: 0 6px;
            padding: 10px 0;
        }

        #blueprint_show_event_service_button{
            width: 233px;
        }

        #blueprint_contact_button{
            width: 114px;
        }

        .blueprint_solution_img_wrapper{
            padding-top: 20px;
            text-align: center;
        }

        .blueprint_popup{
            text-align: center;
            width: 560px;
            border-radius: 10px;
            box-shadow: 2px 2px 12px 0 rgba(0, 0, 0, 0.1);
        }

        .blueprint_contact_popup_container{
            width: 380px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 20px;
            margin-bottom: 40px;
        }

        #blueprint_form_contact{
            text-align: left;
        }

        .blueprint_contact_popup_title{
            font-size: 32px;
            font-weight: 500;
            line-height: 1.38;
            color: #1a1a1a;
        }

        .blueprint_contact_popup_content{
            margin-top: 20px;
            margin-bottom: 40px;
            font-size: 16px;
            color: #4d4d4d;
        }

        .blueprint_form_popup_label{
            color:#4d4d4d !important;
        }

        .blueprint_contact_send{
            width: 390px;
            height: 56px;
            border-radius: 5px;
            background-color: #43c9f0 !important;
            margin-bottom: 27px;
            font-size: 20px;
            font-weight: 500;
        }

        .swal-footer{
            text-align: center;
        }

        .popup_close_button_wrapper{
            position: absolute;
            top: 40px;
            right: 40px;
        }

        .popup_close_button{
            border: 0;
            background-color: white;
        }

        .blueprint_welcome_start_mobile_wrapper{
            display: none;
            margin-top: 28px;
        }

        #blueprint_welcome_start_mobile_button{
            width: 110px;
            height: 51px;
        }

        .thumb_margin_left_mobile{
            margin-left: 20px;
        }

        .thumb_margin_left_pc{
            margin-left: 0px;
        }

        .blueprint_who_make_slide_mobile{
            display: none;
        }

        .blueprint_who_make_slide_pc{
        }

        .blueprint_who_make_circle{
            width: 80px;
            height: 80px;
            border: solid 1px #ebebeb;
            background-color: white;
            border-radius: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .blueprint_talk_bg{
          width: 100%; 
          height: 938px; 
          background-color: #f7f7f7; 
          position: absolute; 
          top: 1698px;
        }

        .blueprint_played_event_container{
            /*height: 630px;*/
            margin-top: 235px;
        }

        .blueprint_played_event_img{
            width: 100%; 
            position: absolute; 
            top: 3064px;
        }

        .blueprint_how_to_start_container_container{
            padding-top: 395px;
        }

        .blueprint_how_to_number_background_container{
            margin-bottom: 24px; 
            height: 68px;
        }

        #blueprint_start_bottom_mobile_button{
            display: none;
        }

        #blueprint_form_start_mobile{
            text-align: left;
        }

        @media (max-width:1060px) {
            .blueprint_solution_img_wrapper{
                padding-top: 15px;
            }

            #blueprint_start_bottom_mobile_button{
                display: block;
                margin-top: 40px;
            }

            .blueprint_how_to_start_content{
                margin-top: 40px;
            }
            .blueprint_how_to_number_background_container{
                height: 43px;
            }

            .swiper-pagination{
                display: block;
            }

            .blueprint_container{
                /*display: none;*/
                margin-top: 64px;
            }
            .blueprint_welcome_start_container{
                display: none;
            }
            .blueprint_welcome_container{
                text-align: center;
            }

            .blueprint_welcome_title>h4{
                font-size: 28px;
                font-weight: 500;
                line-height: 1.29;
            }

            .blueprint_welcome_container{
                top: 72px;
                height: 3324px;
            }

            .blueprint_title_image_container{
                height: 355px;
            }

            .blueprint_welcome_title>p{
                font-size: 14px;
                line-height: 1.57;
                margin-top: 16px;
            }

            .blueprint_welcome_start_mobile_wrapper{
                display: block;
            }

            .blueprint_solution_container{
                margin-top: 136px;
            }

            .blueprint_solution_container>h4{
                font-size: 20px;
            }

            .bluprint_carousel_container{
                margin-top: 28px;
            }

            .blueprint_slide_button{
                font-size: 14px;
            }

            .blueprint_carousel_box{
                /*
                width: 164px;
                height: 100%;
                max-height: 164px;
                margin-left: 0px;
                margin-right: 10px;
                margin-bottom: 10px;
                padding: 7.5% 0;
                flex: 1;
                */

                width: 164px;
                height: 100%;
                max-height: 164px;
                margin-left: 0px;
                margin-right: 10px;
                margin-bottom: 10px;
                padding: 26px 0;
                flex: 1;
            }

            .bluprint_carousel_box_circle{
                width: 76px;
                height: 76px;
                margin-top: 0px;
            }

            .blueprint_solution_img{
                width: 48px;
                height: 48px;
            }

            .blueprint_carousel_box_content_wrapper{
                font-size: 10px;
                margin-top: 8px;
            }

            .blueprint_slide_button_container{
                margin-bottom: 31px;
            }

            .thumb_margin_left_mobile{
                margin-left: 0px;
            }

            .thumb_margin_left_pc{
                margin-left: auto;
            }

            .blueprint_container_title>h4{
                font-size: 20px;
                font-weight: normal;
                font-style: normal;
                font-stretch: normal;
                line-height: normal;
            }

            .blueprint_played_tags_container{
                width: 100%;
                margin-top: 32px;
            }

            .blueprint_who_make_box{
                margin-top: 0px;
                width: 100%;
                height: 100%;
            }

            .blueprint_who_make_img{
                width: 52px;
                margin-top: 14px;
            }

            .blueprint_who_make_content{
                font-size: 12px;
                line-height: 1.33;
                margin-top: 8px;
            }

            .blueprint_who_make_slide_mobile{
                display: block;
                margin-top: 28px !important;
            }

            .blueprint_who_make_slide_pc{
                display: none;
            }

            .blueprint_talk_bg{
                top: 1277px;
                height: 924px;
            }

            .blueprint_talk_container{
                padding-top: 40px;
            }

            .blueprint_talk_bubble_wrapper{
                margin-bottom: 24px;
            }

            #blueprint_show_event_service_button{
                margin-top: 21px;
                width: 100%;
            }

            #blueprint_contact_button{
                margin-top: 21px;
                width: 100%;
            }

            .blue_button{
                height: 50px;
            }

            .blueprint_container_title>h4{
                /*margin-top: 128px;*/
            }

            .blueprint_played_first{
                width: 258px;
                margin-left: auto;
                margin-right: auto;
            }

            .blueprint_played_second{
                width: 258px;
                margin-left: auto;
                margin-right: auto;
                margin-top: 16px;
            }

            .blueprint_played_event_img{
                top: 2559px;
            }
            
            .blueprint_how_to_start_title{
                font-size: 20px;
            }

            #blueprint_start_up_button{
                display: none;
            }

            .blueprint_how_to_start_content p{
                font-size: 14px;
                line-height: 1.57;
                text-align: left;
            }

            .blueprint_played_event_container{
                margin-top: 128px;
            }
        }

        @media (max-width:720px) {
            .blueprint_popup{
                width: 100%;
                /*height: 100%;*/
                height: auto;
                margin: 0;
                border: 0;
                border-radius: 0;
            }

            .blueprint_contact_popup_container{
                width: 100%;
                padding-top: 0px;
                /*margin-bottom: 0px;*/
            }

            .blueprint_contact_popup_title{
                font-size: 16px;
                opacity: 0.7;
                color: black;
            }

            .blueprint_contact_popup_content{
                margin-top: 38px;
                font-size: 14px;
                line-height: 1.57;
            }

            .blueprint_form_popup_label{
                font-size: 12px !important;
            }

            .popup_close_button_wrapper{
                top: 20px;
                right: 20px;
            }
        }

        @media (max-width:640px) {
            .blueprint_talk_bg{
                height: 948px;
            }

            .blueprint_played_event_img{
                top: 2583px;
            }

            .blueprint_welcome_container{
                height: 3350px;
            }
        }

        @media (max-width:423px) {
            .blueprint_talk_bg{
                height: 972px;
            }

            .blueprint_played_event_img{
                top: 2606px;
            }

            .blueprint_welcome_container{
                height: 3374px;
            }
        }

        @media (max-width:408px) {
            .blueprint_talk_bg{
                height: 995px;
            }

            .blueprint_played_event_img{
                top: 2630px;
            }

            .blueprint_welcome_container{
                height: 3398px;
            }
        }

        @media (max-width:385px) {
            .blueprint_talk_bg{
                height: 1018px;
            }

            .blueprint_played_event_img{
                top: 2653px;
            }

            .blueprint_welcome_container{
                /*height: 3414px;*/
                height: 3420px;
            }
        }

        @media (max-width:338px) {
            .blueprint_carousel_box{
                padding: 7.5% 0;
            }
        }

        @media (max-width:350px) {
            .blueprint_talk_bg{
                height: 1036px;
            }

            .blueprint_played_event_img{
                top: 2672px;
            }

            .blueprint_welcome_container{
                height: 3438px;
            }
        }

        @media (max-width:338px) {
            .blueprint_talk_bg{
                height: 1055px;
            }

            .blueprint_played_event_img{
                top: 2691px;
            }

            .blueprint_welcome_container{
                height: 3457px;
            }
        }
    </style>

    <link rel="stylesheet" href="{{ asset('/css/swiper/swiper.min.css?version=1') }}">
    <link rel="stylesheet" href="{{ asset('/css/speech_bubble.css?version=2') }}">
@endsection

@section('content')
    <!-- first section 시작 -->

    <div class="blueprint_title_wrapper">
        <div class="blueprint_title_image_container">
            <div class="bg-base" style="width: 100%;">
                <img class="blueprint_title_img" src="{{ asset('/img/makeevent/MakeEvent_01_bg.png') }}" onload='resizeBluePrintTitleImgOnload();'/>
            </div>
        </div>
    </div>

    <div class="blueprint_talk_bg">
    </div>

    <div class="blueprint_played_event_img">
        <div class="swiper-pagination">
        </div>
        
        <div class="swiper-container swiper-event-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide-test">
                    <div class="blueprint_played_image_container">
                        <div class="bg-base" style="width: 100%;">
                            <img class='blueprint_played_image' src="{{ asset('/img/makeevent/MakeEvent_05_CreatorWith_1.png') }}">
                        </div>
                    </div>
                </div>
                
                <div class="swiper-slide slide-test">
                    <div class="blueprint_played_image_container">
                        <div class="bg-base" style="width: 100%;">
                            <img class='blueprint_played_image' src="{{ asset('/img/makeevent/MakeEvent_05_CreatorWith_2.png') }}">
                        </div>
                    </div>
                </div>

                <div class="swiper-slide slide-test">
                    <div class="blueprint_played_image_container">
                        <div class="bg-base" style="width: 100%;">
                            <img class='blueprint_played_image' src="{{ asset('/img/makeevent/MakeEvent_05_CreatorWith_3.png') }}">
                        </div>
                    </div>
                </div>

                <div class="swiper-slide slide-test">
                    <div class="blueprint_played_image_container">
                        <div class="bg-base" style="width: 100%;">
                            <img class='blueprint_played_image' src="{{ asset('/img/makeevent/MakeEvent_05_CreatorWith_4.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="welcome_content_container blueprint_welcome_container">
        <div class="blueprint_welcome_title">
            <h4>
                팬들과 같이 만드는<br>
                내 콘텐츠의 새로운 가치
            </h4>
            <p>
            지금 바로 이벤트를 만들어서<br>
            팬들을 위한 소중한 기억과 함께 채널도 성장시켜보세요!
            </p>
        </div>

        <div class="blueprint_welcome_start_mobile_wrapper">
            <button id="blueprint_welcome_start_mobile_button" class="blue_button">시작하기</button>
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
                <div class="swiper-container swiper-event-plan">
                    <div class="swiper-wrapper">
                    @for($i = 0 ; $i < 3 ; $i++)
                        <?php
                            $itemIndex = 0;
                        ?>
                        <div class="swiper-slide">
                            <div class="flex_layer_thumb">
                                @for($k = 0 ; $k < 2 ; $k++)
                                    @if($k===1)
                                    <div class="flex_layer thumb_margin_left_mobile">
                                    @else
                                    <div class="flex_layer">
                                    @endif
                                        @for($j = 0 ; $j < 2 ; $j++)
                                        <?php
                                            //$iconURL = "ic-make-event-solution-120-1-1.svg";
                                            $iconURL = asset('/img/makeevent/svg/solution/ic-make-event-solution-120-'.($i+1).'-'.($itemIndex+1).'.svg');
                                            $content1 = "";
                                            $content2 = "";
                                            if($i === 0)
                                            {
                                                if($itemIndex === 0)
                                                {
                                                    $content1 = "크리에이터 맞춤형";
                                                    $content2 = "콘셉트 제안";
                                                }
                                                else if($itemIndex === 1)
                                                {
                                                    $content1 = "이벤트 분위기에";
                                                    $content2 = "딱 맞는 장소 대관";
                                                }
                                                else if($itemIndex === 2)
                                                {
                                                    $content1 = "이벤트 진행 규모 및";
                                                    $content2 = "예산 컨설팅";
                                                }
                                                else if($itemIndex === 3)
                                                {
                                                    $content1 = "티켓 / 베너 제작 ";
                                                    $content2 = "&nbsp;";
                                                }
                                            }
                                            else if($i === 1)
                                            {
                                                if($itemIndex === 0)
                                                {
                                                    $content1 = "선착순 / 추첨형 등";
                                                    $content2 = "다양한 티켓팅 옵션";
                                                }
                                                else if($itemIndex === 1)
                                                {
                                                    $content1 = "쉬운 정산과 관객 관리";
                                                    $content2 = "&nbsp;";
                                                }
                                                else if($itemIndex === 2)
                                                {
                                                    $content1 = "굿즈 판매 /";
                                                    $content2 = " 추가 후원";
                                                }
                                                else if($itemIndex === 3)
                                                {
                                                    $content1 = "이벤트 펀딩 진행 가능";
                                                    $content2 = "&nbsp;";
                                                }
                                            }
                                            else if($i === 2)
                                            {
                                                if($itemIndex === 0)
                                                {
                                                    $content1 = "이벤트 진행 보조";
                                                    $content2 = "&nbsp;";
                                                }
                                                else if($itemIndex === 1)
                                                {
                                                    $content1 = "이벤트 공간 세팅";
                                                    $content2 = "&nbsp;";
                                                }
                                                else if($itemIndex === 2)
                                                {
                                                    $content1 = "검표 진행 / ";
                                                    $content2 = "입장 안내";
                                                }
                                                else if($itemIndex === 3)
                                                {
                                                    $content1 = "관객 안전관리 / 위기대응";
                                                    $content2 = "&nbsp;";
                                                }
                                            }
                                        ?>
                                            <!--<div class="blueprint_carousel_box" style="@if($itemIndex===0)margin-left: 0px;@endif">-->
                                            @if($j===0)
                                            <div class="blueprint_carousel_box thumb_margin_left_pc">
                                            @else
                                            <div class="blueprint_carousel_box">
                                            @endif
                                                <div class="bluprint_carousel_box_circle">
                                                    <div class="blueprint_solution_img_wrapper">
                                                        <img class="blueprint_solution_img" src="{{$iconURL}}"/>
                                                    </div>
                                                </div>
                                                <div class="blueprint_carousel_box_content_wrapper">
                                                    {{$content1}}<br>
                                                    {{$content2}}
                                                </div>
                                            </div>
                                            <?php
                                            $itemIndex++;
                                            ?>
                                        @endfor
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

            <div class="blueprint_who_make_container blueprint_who_make_slide_pc">     
                @for($i = 0 ; $i < 8 ; $i++)
                <?php
                $whoMakeImgURL = asset('/img/makeevent/svg/ic-make-event-who-80-'.($i+1).'.svg');
                $whoMakeContent = "";
                switch($i)
                {
                    case 0:
                    //$whoMakeImgURL = "유투브 이미지";
                    $whoMakeContent = "유튜브 크리에이터";
                    break;

                    case 1:
                    //$whoMakeImgURL = "라이브 이미지";
                    $whoMakeContent = "라이브 방송 스트리머";
                    break;

                    case 2:
                    //$whoMakeImgURL = "팟캐스트 이미지";
                    $whoMakeContent = "팟캐스트 진행자";
                    break;

                    case 3:
                    //$whoMakeImgURL = "하트 이미지";
                    $whoMakeContent = "SNS 인플루언서";
                    break;

                    case 4:
                    //$whoMakeImgURL = "MCN 이미지";
                    $whoMakeContent = "MCN 소속 매니저/기획자";
                    break;

                    case 5:
                    //$whoMakeImgURL = "음표 이미지";
                    $whoMakeContent = "가수/뮤지션";
                    break;

                    case 6:
                    //$whoMakeImgURL = "책 이미지";
                    $whoMakeContent = "문화기획단체 / 커뮤니티";
                    break;

                    case 7:
                    //$whoMakeImgURL = "번개 이미지";
                    $whoMakeContent = "그외 모든 크리에이터";
                    break;
                }
                ?>
                <div class="blueprint_who_make_box">
                    <div class="img_dummy" style="margin: 0px auto; padding-top: 0px;">
                        <img class="blueprint_who_make_img" src="{{$whoMakeImgURL}}">
                    </div>
                    <div class="blueprint_who_make_content">
                        {{$whoMakeContent}}
                    </div>
                </div>
                @endfor
            </div>

            <div class="swiper-container blueprint_who_make_container blueprint_who_make_slide_mobile">
                <div class="swiper-wrapper">
                    @for($i = 0 ; $i < 8 ; $i++)
                    <?php
                    $whoMakeImgURL = asset('/img/makeevent/svg/ic-make-event-who-80-'.($i+1).'.svg');
                    $whoMakeContent = "";
                    $whoMakeContent_2 = "&nbsp;";
                    switch($i)
                    {
                        case 0:
                        $whoMakeContent = "유튜브";
                        $whoMakeContent_2 = "크리에이터";
                        break;

                        case 1:
                        $whoMakeContent = "라이브 방송";
                        $whoMakeContent_2 = "스트리머";
                        break;

                        case 2:
                        $whoMakeContent = "팟캐스트";
                        $whoMakeContent_2 = "진행자";
                        break;

                        case 3:
                        $whoMakeContent = "SNS";
                        $whoMakeContent_2 = "인플루언서";
                        break;

                        case 4:
                        $whoMakeContent = "MCN 소속";
                        $whoMakeContent_2 = "매니저/기획자";
                        break;

                        case 5:
                        $whoMakeContent = "가수/뮤지션";
                        $whoMakeContent_2 = "";
                        break;

                        case 6:
                        $whoMakeContent = "문화기획단체";
                        $whoMakeContent_2 = "/ 커뮤니티";
                        break;

                        case 7:
                        $whoMakeContent = "그외 모든";
                        $whoMakeContent_2 = "크리에이터";
                        break;
                    }
                    ?>
                    <div class="swiper-slide">
                        <div class="blueprint_who_make_box">
                            <div class="img_dummy" style="margin: 0px auto; padding-top: 0px;">
                                <div class="blueprint_who_make_circle">
                                    <img class="blueprint_who_make_img" src="{{$whoMakeImgURL}}">
                                </div>
                            </div>
                            <div class="blueprint_who_make_content">
                                {{$whoMakeContent}}<br>
                                {{$whoMakeContent_2}}
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

        </div>

        <div class="blueprint_container blueprint_take_container">
            <div class="blueprint_talk_container">
                <div class="blueprint_talk_wrapper">
                    <div class="flex_layer_thumb">
                        <div class="blueprint_talk_bubble_wrapper" style="margin-bottom: 20px; margin-right: 20px;">
                            <img src="{{asset('/img/makeevent/ic-emoji-make-event-64-1.png')}}" style="width:64px; height:64px"/>
                        </div>

                        <div class="blueprint_talk_bubble_wrapper">
                            <div class="bubble_left">
                                <p>이벤트에 대해 1도 몰라도 괜찮아요?</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="blueprint_talk_bubble_wrapper" style="text-align: right;">
                        <div class="bubble_right">
                            <p>괜찮아요! 크라우드티켓은 누구나 행사나 모임을 열 수 있도록 맞춤형 솔루션을 제공해드리니까요! 👇</p>
                        </div>
                    </div>

                    <div class="blueprint_talk_bubble_wrapper" style="text-align: right; margin-bottom: 0px;">
                        <button id="blueprint_show_event_service_button" type="button" class="blue_button">이벤트기획 서비스 보기</button>
                    </div>                        
                </div>
            </div>
            <div class="blueprint_talk_container" style="margin-top: 64px; padding-top: 0px;">
                <div class="blueprint_talk_wrapper">
                    <div class="flex_layer_thumb">
                        <div class="blueprint_talk_bubble_wrapper" style="margin-bottom: 20px; margin-right: 20px;">
                            <img src="{{asset('/img/makeevent/ic-emoji-make-event-64-2.png')}}" style="width:64px; height:64px"/>
                        </div>

                        <div class="blueprint_talk_bubble_wrapper">
                            <div class="bubble_left">
                                <p>크라우드티켓과 비즈니스를 하고 싶습니다</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="blueprint_talk_bubble_wrapper" style="text-align: right;">
                        <div class="bubble_right">
                            <p>서비스 이용에 대한 질문부터 이벤트 컨설팅, 협업 및 제휴 문의 등 언제든지 연락해주세요! 크리에이터에게 도움이 될 수 있다면 크티는 언제나 열려있습니다. 🙆‍♀️</p>
                        </div>
                    </div>

                    <div class="blueprint_talk_bubble_wrapper" style="text-align: right; margin-bottom: 0px;">
                        <button id="blueprint_contact_button" type="button" class="blue_button">문의하기</button>
                    </div>                        
                </div>
            </div>
        </div>
        <div class="blueprint_container text-center blueprint_played_event_container">
            <div class="blueprint_container_title">
                <h4>
                    이미 다양한 형태의 이벤트가<br>
                    크티를 통해 성공적으로 진행됐습니다
                </h4>
            </div>

            <div class="bluprint_played_event_content">
                여러분만의 크리에이티브한 콘텐츠를<br>
                온/오프라인 제한 없이 영상 밖으로 현실화해보세요
            </div>

            <div class="blueprint_played_tags_container">
                <div class="flex_layer_thumb">
                    <div class="flex_layer blueprint_played_first">
                        <div class="blueprint_played_tag_bg">
                            팬미팅
                        </div>
                        <div class="blueprint_played_tag_bg">
                            영화제
                        </div>
                        <div class="blueprint_played_tag_bg">
                            강의
                        </div>
                    </div>
                    
                    <div class="flex_layer blueprint_played_second">
                        <div class="blueprint_played_tag_bg">
                            페스티벌
                        </div>
                        <div class="blueprint_played_tag_bg">
                            선물나눔
                        </div>
                        <div class="blueprint_played_tag_bg">
                            공동구매
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="blueprint_container blueprint_how_to_start_container_container">
            <div class="flex_layer_thumb">
                <div class="blueprint_how_to_start_container">
                    <div class="blueprint_how_to_start_title">
                        팬과 함께하는 이벤트 만들기<br>
                        어렵지 않아요!
                    </div>

                    <button id="blueprint_start_up_button" class="blue_button" style="width: 154px; height: 56px; margin-top: 40px" type="button">시작하기</button>
                </div>

                <div class="blueprint_how_to_start_container">
                    <div class="blueprint_how_to_start_content">
                        <div class="flex_layer blueprint_how_to_number_background_container">
                            <div class="blueprint_how_to_number_background_wrapper">
                                <div class="blueprint_how_to_number_background">1</div>
                            </div>
                            <p>내 이름과 만들고 싶은 이벤트 종류, 연락처만 적고 '시작하기'를 누른다.</p>
                        </div>

                        <div class="flex_layer blueprint_how_to_number_background_container">
                            <div class="blueprint_how_to_number_background_wrapper">
                                <div class="blueprint_how_to_number_background">2</div>
                            </div>
                            <p>아직 회원가입을 안 했다면 이름, 이메일, 비밀번호만 적고 10초만에 가입을 끝낸다</p>
                        </div>

                        <div class="flex_layer blueprint_how_to_number_background_container">
                            <div class="blueprint_how_to_number_background_wrapper">
                                <div class="blueprint_how_to_number_background">3</div>
                            </div>
                            <p>직접 이벤트를 기획, 또는 크티와 함께 이벤트를 기획하고 페이지를 준비한다</p>
                        </div>

                        <div class="flex_layer blueprint_how_to_number_background_container">
                            <div class="blueprint_how_to_number_background_wrapper">
                                <div class="blueprint_how_to_number_background">4</div>
                            </div>
                            <p>이벤트 신청 페이지를 오픈하고 곧바로 나의 팬들에게 알린다!</p>
                        </div>
                    </div>
                </div>
            </div>

            <button id="blueprint_start_bottom_mobile_button" type="button" class="blue_button">시작하기</button>
        </div>
    </div>

    <div class="blueprint_welcome_start_container">
        <div class="blueprint_welcome_start_form_container">
        
            <form id="blueprint_form_start" action="{{ url('/blueprints') }}" method="post" data-toggle="validator" role="form">
                <div class="form-group">
                    <label class="cr_label">크리에이터 이름</label>
                    <input id="input-user-intro" name="user_introduction" class="form-control cr_input" placeholder="유튜브 채널명, 먹방 BJ ‘000’, 게임 스트리머 ‘000’ 등">
                </div>
                <div class="form-group">
                    <label class="cr_label">만들고 싶은 이벤트</label>
                    <input id="input-project-intro" name="project_introduction" class="form-control cr_input" placeholder="팬미팅, 강연, 온라인 선물나눔, 랜선사인회 등">
                </div>
                <div class="form-group">
                    <label class="cr_label">이메일 주소</label>
                    <input id="input-email" name="contact"  class="form-control cr_input" placeholder="example@email.com">
                </div>
                <div class="form-group">
                    <label class="cr_label">전화번호</label>
                    <input id="input-phone" type="tel" name="tel" class="form-control cr_input" placeholder="'-' 없이 숫자만 입력"/>
                    <p style="font-size: 12px; color: #acacac; margin-top: 8px;">프로젝트 개설을 위한 연락 목적 외에는 절.대. 다른 용도로 사용되지 않습니다. 안심하세요</p>
                </div>

                <input type="hidden" name="type" value="sale"/>
                <input type="hidden" name="story" value="none"/>
                <input type="hidden" name="estimated_amount" value="none"/>
                @include('csrf_field')
            </form>

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

                if(!isCheckPhoneNumber($('#input-phone').val()))
                {
                    return;
                }

                showLoadingPopup("프로젝트 개설중입니다..");
                
                $('#blueprint_form_start').submit();
            };

            $("#blueprint_start_button").click(function(){
                blueprintStart();
            });

            var swiper = new Swiper('.swiper-event-plan', {
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

            var resizeTitleImg = function(){
                var parentData = $('.blueprint_title_image_container')[0];
                var imgData = $('.blueprint_title_img')[0];

                var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);

                if(targetWidth <= window.innerWidth)
                {
                    $('.blueprint_title_img').css('width', '100%');
                    $('.blueprint_title_img').css('height', 'auto');
                }
                else
                {
                    $('.blueprint_title_img').css('width', targetWidth);
                    $('.blueprint_title_img').css('height', parentData.clientHeight);
                }
            };

            var resizePlayedEventImg = function(){
                var parentData = $('.blueprint_played_image_container')[0];
                var imgData = $('.blueprint_played_image')[0];

                var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);
//clientWidth
                if(targetWidth <= parentData.clientWidth)
                {
                    $('.blueprint_played_image').css('width', '100%');
                    $('.blueprint_played_image').css('height', 'auto');
                }
                else
                {
                    $('.blueprint_played_image').css('width', parentData.clientWidth);
                    $('.blueprint_played_image').css('height', parentData.clientHeight);
                    //$('.blueprint_played_image').css('width', targetWidth);
                    //$('.blueprint_played_image').css('height', parentData.clientHeight);
                }
            };

            var replaceTitleImg = function(){
                var assetURL = $("#asset_url").val();
                if(window.innerWidth >= 768){
                    $(".blueprint_title_img").attr('src', assetURL + "img/makeevent/MakeEvent_01_bg.png");
                }
                else{
                    $(".blueprint_title_img").attr('src', assetURL + "img/makeevent/MakeEvent_01_bg_768.png");
                }
            };

            replaceTitleImg();
            //resizeTitleImg();

            $(window).resize(function() {
                //console.error("innerWidth" + window.innerWidth);
                replaceTitleImg();
                resizeTitleImg();                
            });

            var swiper_events = new Swiper('.swiper-event-container', {
                slidesPerView: 4,
                loop: true,
                on: {
                    init: function () {
                        resizePlayedEventImg();
                    },
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    renderBullet: function (index, className) {
                        return '<span class="' + className + '"></span>';
                    },
                },
                breakpoints: {
                // when window width is <= 320px
                    1920: {
                    slidesPerView: 3
                    },
                    1440: {
                    slidesPerView: 2
                    },
                    960: {
                    slidesPerView: 1
                    }
                }
                //spaceBetween: 20
            });

            swiper_events.on('init', function() { 
                /* do something */ 
                
            });

            swiper_events.on('resize', function() { 
                /* do something */ 
                resizePlayedEventImg();
            });
            
            $("#blueprint_show_event_service_button").click(function(){
                window.open('https://drive.google.com/file/d/1B7SC2NWxVDCakYSK001bD6AS5Ho5pDuM/view?usp=sharing', '_blank');
            });

            var contactPopup = function(){
                var elementPopup = document.createElement("div");
                elementPopup.innerHTML = 
                
                "<div class='blueprint_contact_popup_container'>" + 
                    "<div class='blueprint_contact_popup_title'>" + 
                        "제휴 문의" + 
                    "</div>" + 

                    "<div class='blueprint_contact_popup_content'>" + 
                        "24시간 이내에 입력하신 이메일이나 전화번호로"+"<br>"+"연락 드리겠습니다." + 
                    "</div>" + 

                    "<form id='blueprint_form_contact' action='{{ url('/question/sendmail') }}' method='post' data-toggle='validator' role='form'>" + 
                        "<div class='form-group'>" + 
                            "<label class='cr_label blueprint_form_popup_label'>크리에이터 이름 (혹은 개설자)</label>" + 
                            "<input id='contact-input-user-intro' name='user_introduction' class='form-control cr_input' placeholder='뮤지션 ‘000’, 먹방 BJ ‘000’, 게임 스트리머 ‘000’'>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label class='cr_label blueprint_form_popup_label'>문의 내용</label>" +
                            "<textarea id='contact-input-project-intro' class='form-control' style='height:100px' name='project_introduction'></textarea>" + 
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label class='cr_label blueprint_form_popup_label'>이메일 주소</label>" +
                            "<input id='contact-input-email' name='contact'  class='form-control cr_input'>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label class='cr_label blueprint_form_popup_label'>전화번호</label>" +
                            "<input id='contact-input-phone' type='tel' name='tel' class='form-control cr_input' placeholder='-없이 숫자만 입력'/>" +
                            "<p style='font-size: 12px; color: #acacac; margin-top: 8px;'>프로젝트 개설을 위한 연락 목적 외에는 절.대. 다른 용도로 사용되지 않습니다. 안심하세요</p>" +
                        "</div>" +

                        "<input type='hidden' name='type' value='sale'/>" +
                        "<input type='hidden' name='story' value='none'/>" +
                        "<input type='hidden' name='estimated_amount' value='none'/>" +
                        "<input type='hidden' name='_token' value='{{ csrf_token() }}'/>" + 
                        
                    "</form>" + 

                    "<div class='blueprint_start_button_wrapper'>" + 
                        "<button id='blueprint_contact_popup_button' type='button' class='blue_button'>문의하기</button>" + 
                    "</div>" +
                    
                "</div>" + 

                "<div class='popup_close_button_wrapper'>" +
                    "<button type='button' class='popup_close_button'>" + 
                        "<img src='{{ asset('/img/makeevent/svg/ic-exit.svg') }}'>" +
                    "</button>" +
                "</div>";

                swal({
                        //title: "로그인",
                        content: elementPopup,
                        allowOutsideClick: "true",
                        className: "blueprint_popup",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    });

                $(".swal-footer").hide();

                $('.popup_close_button').click(function(){
                    swal.close();
                });

                var blueprint_form_contact_option = {
                    'beforeSerialize': function($form, options) {
                    },
                    'success': function(result) {
                        loadingProcessStop($(".blueprint_start_button_wrapper"));

                        if(result.state === 'error')
                        {
                            alert(result.message);
                            return;
                        }
                        
                        swal("문의 성공!", "곧 크라우드티켓에서 연락 드리겠습니다.", "success");
                    },
                    'error': function(data) {
                        alert("문의 에러! 입력 확인 후 다시 한번 시도해주세요");
                    }
                    
                };

                $('#blueprint_form_contact').ajaxForm(blueprint_form_contact_option);

                $("#blueprint_contact_popup_button").click(function(){
                    if(!isCheckPhoneNumber($('#contact-input-phone').val()))
                    {
                        return;
                    }

                    loadingProcess($(".blueprint_start_button_wrapper"));

                    $('#blueprint_form_contact').submit();
                });
            };

            $("#blueprint_contact_button").click(function(){
                contactPopup();
            });

            var swiper_who_make_events = new Swiper('.blueprint_who_make_slide_mobile', {
                //loop: true,
                slidesPerView: 6,
                spaceBetween: 4,

                autoplay: {
                    delay: 2000,
                },
                
                breakpoints: {
                // when window width is <= 320px
                    640: {
                    slidesPerView: 5
                    },
                    520: {
                    slidesPerView: 4
                    },
                    370: {
                    slidesPerView: 3
                    }
                }
            });

            var blueprint_mobile_start_popup = function(){
                var elementPopup = document.createElement("div");
                elementPopup.innerHTML = 
                "<div class='blueprint_contact_popup_container'>" + 
                    "<div class='blueprint_contact_popup_title' style='margin-bottom: 38px;'>" + 
                            "프로젝트 개설신청" + 
                    "</div>" +

                    "<form id='blueprint_form_start_mobile' action='{{ url('/blueprints') }}' method='post' data-toggle='validator' role='form'>" +
                        "<div class='form-group'>" +
                            "<label class='cr_label'>크리에이터 이름</label>" +
                            "<input id='input-user-intro-mobile' name='user_introduction' class='form-control cr_input' placeholder='뮤지션 ‘000’, 먹방 BJ ‘000’, 게임 스트리머 ‘000’'>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label class='cr_label'>만들고 싶은 이벤트</label>" +
                            "<input id='input-project-intro-mobile' name='project_introduction' class='form-control cr_input' placeholder='팬미팅, 팬들과 함께하는 먹방 투어'>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label class='cr_label'>이메일 주소</label>" +
                            "<input id='input-email-mobile' name='contact'  class='form-control cr_input'>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label class='cr_label'>전화번호</label>" +
                            "<input id='input-phone-mobile' type='tel' name='tel' class='form-control cr_input' placeholder='-없이 숫자만 입력'/>" +
                            "<p style='font-size: 12px; color: #acacac; margin-top: 8px;'>프로젝트 개설을 위한 연락 목적 외에는 절.대. 다른 용도로 사용되지 않습니다. 안심하세요</p>" +
                        "</div>" +

                        "<input type='hidden' name='type' value='sale'/>" +
                        "<input type='hidden' name='story' value='none'/>" +
                        "<input type='hidden' name='estimated_amount' value='none'/>" +
                        "<input type='hidden' name='_token' value='{{ csrf_token() }}'/>" + 
                    "</form>" +

                    "<div class='blueprint_start_button_wrapper'>" +
                        "<button id='blueprint_start_button_mobile' type='button' class='blue_button'>시작하기</button>" +
                    "</div>" +
                "</div>" + 

                "<div class='popup_close_button_wrapper'>" +
                    "<button type='button' class='popup_close_button'>" + 
                        "<img src='{{ asset('/img/makeevent/svg/ic-exit.svg') }}'>" +
                    "</button>" +
                "</div>";

                swal({
                        //title: "로그인",
                        content: elementPopup,
                        allowOutsideClick: "true",
                        className: "blueprint_popup",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    });

                $(".swal-footer").hide();

                $('.popup_close_button').click(function(){
                    swal.close();
                });
                /*
                var blueprint_form_start_mobile_option = {
                    'beforeSerialize': function($form, options) {
                    },
                    'success': function(result) {
                        loadingProcessStop($(".blueprint_start_button_wrapper"));

                        if(result.state === 'error')
                        {
                            alert(result.message);
                            return;
                        }
                        
                        //swal("문의 성공!", "곧 크라우드티켓에서 연락 드리겠습니다.", "success");
                    },
                    'error': function(data) {
                        alert("개설 에러! 입력 확인 후 다시 한번 시도해주세요");
                    }
                    
                };
                */

                //$('#blueprint_form_start_mobile').ajaxForm(blueprint_form_start_mobile_option);

                var blueprint_start_mobile_button = function(){
                    if(!isLogin())
                    {
                        loginPopup(blueprint_start_mobile_button, null);
                        return;
                    }

                    if(!isCheckPhoneNumber($('#input-phone-mobile').val()))
                    {
                        return;
                    }

                    //loadingProcess($(".blueprint_start_button_wrapper"));
                    $('#blueprint_form_start_mobile').submit();

                    showLoadingPopup("프로젝트 개설중입니다..");
                };

                $("#blueprint_start_button_mobile").click(function(){
                    blueprint_start_mobile_button();
                });
            };

            $("#blueprint_welcome_start_mobile_button").click(function(){
                if(!isLogin())
                {
                    loginPopup(null, null);
                    return;
                }
                blueprint_mobile_start_popup();
            });

            $("#blueprint_start_bottom_mobile_button").click(function(){
                if(!isLogin())
                {
                    loginPopup(null, null);
                    return;
                }

                blueprint_mobile_start_popup();
            });

        });
    </script>
@endsection
