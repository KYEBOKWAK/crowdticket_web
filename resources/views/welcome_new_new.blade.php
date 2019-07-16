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
    
        body{
          font-weight: normal;
          font-style: normal;
          font-stretch: normal;
          line-height: normal;
          letter-spacing: normal;
        }
        
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

        /*메인 추천 슬라이드 css */
        .carousel-inner{
        }

        .thumbnail-wrappper{
          position: absolute;
          width: 100%;
          height: 100%;
          overflow: hidden;
        }

        .swiper-container{
          max-width: 100%;
          height: 100%;
          position: absolute;
          top: 0px;
          left: 0px;
          bottom: 0px;
          right: 0px;
          margin: auto;
        }

        .swiper-slide {
          text-align: center;
          font-size: 18px;
          background: #fff;
          height: auto;
          /* Center slide text vertically */
          display: -webkit-box;
          display: -ms-flexbox;
          display: -webkit-flex;
          display: flex;
          -webkit-box-pack: center;
          -ms-flex-pack: center;
          -webkit-justify-content: center;
          justify-content: center;
          -webkit-box-align: center;
          -ms-flex-align: center;
          -webkit-align-items: center;
          align-items: center;
        }

        .slider-item{
          background-color: white;
          width: 100%;
          height: 100%;
          margin: 0px 10px;
          border: 1px solid black;
        }

        .project_form_poster_origin_size_ratio{
          position: relative;
          width: 100%;
          padding-bottom: 35%;
        }

        .welcome_start_banner{
          position: relative;
          height: 320px;
          background: linear-gradient(to right, #3bd0ef, #9f83fa 24%, #c72ffd 59%, #e891b7 86%, #f7948f);
        }

        .welcome_start_bubble_container{
          position: absolute;
          width: 100%;
          height: 320px;
          overflow: hidden;
        }

        .welcome_thumb_content_disc{
          font-size: 12px;
          color: #808080;
          margin-top: 0px;
          margin-bottom: 8px;
          font-weight: normal;
        }

        .welcome_thumb_content_container{
          margin-top: 20px;
        }

        .welcome_thumb_content_title{
          margin-top: 0px;
          margin-bottom: 6px;
          font-size: 16px;
          font-weight: bold;
          color: black;
          line-height: 1.4;
        }

        .welcome_thumb_content_date_place{
          font-size: 12px;
          line-height: 1.42;
          color: #808080;
        }

        .welcome_thumb_content_type_wrapper{
          width: 65px;
          height: 28px;
          border-radius: 14px;
          border: solid 1px #b3b3b3;
          text-align: center;
        }

        .welcome_thumb_content_type{
          margin-top: 3px;
          margin-bottom: auto;
          color: #808080;
          font-size: 12px;
        }

        /*메인 추천 슬라이드 css  ---- end  */
        /*
        .welcome_content_container{
          width:1060px;
          margin-left: auto;
          margin-right: auto;
        }
        */

        .welcome_start_content_container{
          width:1060px;
          height: 100%;
          margin-left: auto;
          margin-right: auto;
        }

        .welcome_start_banner_content_container{
          /*width:1080px;
          margin-left: auto;
          margin-right: auto;*/
          position: relative;
          top: 82px;
          font-size: 32px;
          font-weight: 500;
          font-style: normal;
          font-stretch: normal;
          line-height: 1.38;
          letter-spacing: normal;
          color: #ffffff;
        }

        .welcome_start_button_container{
          /*width:1080px;
          margin-left: auto;
          margin-right: auto;*/
          position: relative;
          top: 124px;
        }

        .welcome_start_button{
          width: 161px;
          height: 52px;
          padding: 0px;
          border-radius: 10px;
          border: solid 1px #ffffff;
          font-size: 20px;
          font-weight: 500;
          color: #ffffff;
          background-color: rgba(0, 0, 0, 0);
        }
        /*
        .welcome_content_wrapper{
          margin-top: 64px;
        }
        */

        .welcome_content_title{
          width: 100%;
          font-size: 24px;
          margin-bottom: 32px;
        }

        .welcome_content_more_wrapper{
          width: 25%;
          font-size: 15px;
          text-align: right;
        }

        .welcome_content_more{
          margin-top: 10px;
          margin-bottom: 10px;
          color: #808080;
          font-size: 14px;
          width: 56px;
          margin-left: auto;
        }

        .welcome_thumb_container{
          width: 250px;
        }

        .welcome_banner_1{
          width: 520px;
          height: 128px;
          border-radius: 10px;
          background-color: #f5c935;
        }

        .welcome_banner_2{
          width: 520px;
          height: 128px;
          border-radius: 10px;
          background-color: #141611;
          margin-left: 20px;
        }

        .welcome_meetup_banner_wrapper{
          height: 580px;

          background-color: #f7f7f7;
        }

        .welcome_meetup_banner_title{
          /*height: 36px;*/
          margin-top: 64px;
          font-size: 20px;
          text-align: center;
        }

        .welcome_meetup_banner_subtitle{
          margin-top: 20px;
          /*margin-bottom: 30px;*/
          margin-bottom: 0px;
          font-size: 14px;
          color: #4d4d4d;
          text-align: center;
          line-height: 1.57;
        }

        .carousel_creator_container{
          height: 320px;
          margin-top: 20px;
        }

        .welcome_meetup_banner_img{
          width: 100%;
          /*width: 1920px;*/
          position: absolute;
          top: 50%;
          left: 50%;
          transform:translateX(-50%);
          /*bottom: 0px;*/
          bottom: 50%;
          right: 0px;
          margin: auto;
        }

        .welcome_meetup_banner_img_wrapper{
          width: 100%;
        }

        .welcome_meetup_banner_img_container{
          /*width: 320px;*/
          width: 100%;
          height: 350px;
          margin-left: auto;
          margin-right: auto;
          overflow: hidden;
        }

        .welcome_meetup_banner_img_container_wrapper{
          width: 100%;
          margin-bottom: 20px;
          margin-top: 36px;
          position: absolute;
          overflow: hidden;
        }

        .welcome_meetup_under_title{
          margin-top: 20px;
          font-size: 14px;
          color: #808080;
          text-align: center;
        }

        /*썸네일 CSS START*/
        .welcome_thumb_img_wrapper{
          width: 100%;
          /*width: 250px;*/
          /*height: 160px;*/
          /*position: relative;
          overflow: hidden;*/
        }

        .welcome_thumb_img_resize{
          position: relative;
          width: 100%;
          padding-top: 64%;
          overflow: hidden;
          border-radius: 10px;
        }

        .project-img {
            position:absolute;
            top:0;
            left:0;
            right:0;
            bottom:0;
            max-width:100%;
            margin: auto;
        }
        /*썸네일 CSS END*/

        .isMobileDisable{
          display: block;
        }

        .thumb_container_is_mobile{
          margin-right: 20px;
        }

        .thumb_container_right_is_mobile{
          margin-right: 20px;
        }

        .welcome_banner_container{
          width: 1060px;
          margin-left: auto;
          margin-right: auto;
        }

        .swiper-slide{
          background: none;
        }

        .thumb-black-mask{
          width:100%;
          height:100%;
          position:absolute;
          top:0;
          bottom:0;
          background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.3));
          border-radius: 20px;
        }

        .creator_slide_container{
          position:absolute; 
          width:90%;
          height:auto; 
        }

        .container{
          width: 1060px;
        }

        .footer_padding_left_remover{
          padding-left: 0px;
        }

        .creator_slide_name{
          position:absolute; 
          bottom:12px; 
          left: 12px; 
          font-size: 12px; 
          color: white;
        }

        .creator_slide_sub_counter{
          position:absolute; 
          bottom:12px; 
          right: 12px; 
          font-size: 12px; 
          color: white;
        }

        /*@media (max-width:320px) {*/
        @media (max-width:1060px) {
          /*
          .welcome_content_container{
            width: 600px;
          }
          */

          .welcome_start_content_container{
            margin-left: 13%;
            width: 70%;
          }

          .welcome_start_banner_content_container{
            font-size: 28px;
            font-weight: 500;
            line-height: 1.29;
          }

          .isMobileDisable{
            display: none;
          }

          .thumb_container_is_mobile{
            margin-right: 0px;
            margin-bottom: 24px;
          }
          
          .thumb_container_right_is_mobile{
            margin-right: 10px;
          }

          .welcome_thumb_container{
            width: 145px;
            flex: 1;
          }

          .welcome_content_title{
            font-size: 20px;
            margin-bottom: 20px;
          }

          .welcome_content_more{
            margin-top: 2px;
            font-size: 14px;
          }

          .welcome_thumb_content_title{
            font-size: 14px;
            line-height: 1.29;
            margin-bottom: 3px;
          }
          /*
          .welcome_content_wrapper{
            margin-top: 40px;
          }
          */

          .welcome_thumb_content_container{
            margin-top: 12px;
          }

          .welcome_thumb_content_disc{
            margin-bottom: 5px;
          }

          .welcome_banner_mobile{
            width: 100%;
            height: 78px;
            border-radius: 0px;
            margin-left: 0px;
            margin-right: 0px;
          }

          .welcome_banner_container{
            width: 100%;
          }

          .welcome_start_button{
            width: 107px;
            height: 51px;
            background-color: white;
            color: #b652fb;
            font-size: 18px;
          }

          .container{
            width: 600px;
          }
        }

        @media (max-width:768px) {
          .creator_slide_container{
            margin-top: 0px !important;
          }

          .welcome_meetup_banner_wrapper{
            height: 486px;
          }

          .carousel_creator_container{
            margin-top: -37px;
          }

          .welcome_meetup_banner_title{
            margin-top: 40px;            
          }

          .footer_padding_left_remover{
            padding-left: 15px;
          }

          .creator_slide_name{
          }

          .creator_slide_sub_counter{
            top: 12px;
          }
        }

        @media (max-width:650px) {
          /*
          .welcome_content_container{
            width: 93%;
          }
          */
          .container{
            width: 100%;
          }
        }

        @media (max-width:650px) {
          .welcome_meetup_under_title{
            margin-top: -40px;
          } 
        }

        @media (max-width:320px) {
          /*
          .welcome_content_container{
            width: 300px;
          }
          */

          .welcome_meetup_banner_wrapper{
            height: 545px;
          }

          .carousel_creator_container{
            margin-top: 0px;
          }

          .welcome_meetup_under_title{
            margin-top: 5px;
          }
        }
    </style>

    <link href="{{ asset('/css/bubble.css?version=1') }}" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('/css/swiper/swiper.min.css?version=1') }}"/>

@endsection

@section('content')
<?php
$maxItemCountInLine = 4;  //한줄에 표시될 아이템 개수
$mobileOneLineItemCount = 2;  //모바일일때 한 라인에 보여질 아이템 개수
?>
    <!-- first section 끝 -->
    <div class="welcome_start_banner_container">
      <div class="welcome_start_banner">
          <div class="welcome_start_bubble_container">
          </div>

          <div class="welcome_start_content_container">
            <div class="welcome_start_banner_content_container">
              <b>온라인으로만 보던 크리에이터를<br> 이제는 만나보세요!</b>
            </div>

            <div class="welcome_start_button_container">
              <a href="{{url('/blueprints/welcome')}}">
                <button type="button" class="welcome_start_button">시작하기</button>
              </a>
            </div>
          </div>
      </div>
    </div>

    <div class="welcome_content_container">
      <div class="welcome_content_wrapper">
        <div class="flex_layer">
          <div class="welcome_content_title">
            오픈된 이벤트
          </div>
          <div class="welcome_content_more_wrapper">
            <a href="{{url('/projects')}}">
              <div class="welcome_content_more">
                <div class="flex_layer">
                  <span style="height:21px;">더보기</span>
                  <img src="{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}" style="margin-left:8px; margin-top:1px;"/>
                </div>
              </div>
            </a>
          </div>
        </div>


        <!-- 썸네일 테스트 START -->
        <div class="welcome_thumb_projects_wrapper">
          <div class="flex_layer_thumb">
            <?php
            $projectIndex = 0;
            for($i = 0 ; $i < $mobileOneLineItemCount ; $i++)
            {
              $itemCount = 0;
              ?>
              @if($projectIndex === 0)
              <div class="flex_layer thumb_container_is_mobile">
              @else
              <div class="flex_layer">
              @endif
              <?php
                for($j = $i ; $j < count($projects) ; $j++)
                {
                  ?>
                  @include('template.thumb_project', ['project' => $projects[$projectIndex], 'index' => $projectIndex])
                  <?php
                  $projectIndex++;
                  $itemCount++;
                  if($itemCount >= $mobileOneLineItemCount)
                  {
                    break;
                  }
                }
              ?>
              </div>
              <?php
            }             
            ?>           
          </div>
        </div>
        <!-- 썸네일 테스트 END -->

        
      </div>
    </div>

    <div class="welcome_content_wrapper">
        <div class="welcome_meetup_banner_wrapper">
          <div style="height:1px">
          </div>
          <div class="welcome_meetup_banner_title">
            내가 좋아하는 사람을 화면 밖에서 만나는 인생경험
          </div>
          <div class="welcome_meetup_banner_subtitle">
          온라인으로만 소통할 수 있었던 크리에이터와 팬.<br>
          이제는 크라우드티켓을 통해 더욱 쉽고 즐겁게 오프라인에서 만나고 가까워지세요!
          </div>

          <div class="carousel_creator_container">
              @include('template.carousel_creator', ['project' => ''])
          </div>
          
          <p class="welcome_meetup_under_title">크라우드티켓과 함께한 크리에이터들</p>

        </div>
    </div>

    <div class="welcome_content_wrapper" style="display:none;">
      <div class="welcome_banner_container">
        <div class="flex_layer_thumb">
            <div class="welcome_banner_1 welcome_banner_mobile">
            </div>
          
            <div class="welcome_banner_2 welcome_banner_mobile">
            </div>
        </div>
      </div>
    </div>

    <div class="welcome_content_container">
      <div class="welcome_content_wrapper">
        <div class="flex_layer">
          <div class="welcome_content_title">
            크라우드티켓 매거진
          </div>
          <div class="welcome_content_more_wrapper">
            <a href="{{url('/magazine')}}">
              <div class="welcome_content_more">
                <div class="flex_layer">
                  <span style="height:21px;">더보기</span>
                  <img src="{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}" style="margin-left:8px; margin-top:1px;"/>
                </div>
              </div>
            </a>
          </div>
        </div>


        <!-- 썸네일 테스트 START -->
        <div class="welcome_thumb_projects_wrapper">
          <div class="flex_layer_thumb">
            <?php
            $projectIndex = 0;
            for($i = 0 ; $i < $mobileOneLineItemCount ; $i++)
            {
              $itemCount = 0;
              ?>
              @if($projectIndex === 0)
              <div class="flex_layer thumb_container_is_mobile">
              @else
              <div class="flex_layer">
              @endif
              <?php
                for($j = $i ; $j < count($magazines) ; $j++)
                {
                  ?>
                  @include('template.thumb_magazine', ['magazine' => $magazines[$projectIndex], 'index' => $projectIndex])
                  <?php
                  $projectIndex++;
                  $itemCount++;
                  if($itemCount >= $mobileOneLineItemCount)
                  {
                    break;
                  }
                }
              ?>
              </div>
              <?php
            }             
            ?>           
          </div>
        </div>
        <!-- 썸네일 테스트 END -->
      </div>
    </div>

    <!-- second section 시작 -->
    <!-- 크라우드 티켓 브랜딩 영역 시작 -->
    <!-- 크라우드 티켓 브랜딩 영역 끝 -->
 
@endsection

@section('js')

    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <script src="{{ asset('/js/jquery.counterup.min.js') }}"></script>

    <script src="{{ asset('/js/swiper/swiper.min.js?version=1') }}"></script>
    <script>

        $(document).ready(function () {
            $('.count-ani').counterUp({
                delay: 10,
                time: 1000
            });

            if($("#isNotYet").val() == "TRUE"){
              alert("준비중입니다.");
            }

            var swiper = new Swiper('.swiper-container', {
              //centerInsufficientSlides: true,
              loop: true,
              slidesPerView: 9,
              spaceBetween: 0,
              
              autoplay: {
                delay: 2000,
                //disableOnInteraction: true,
              },
              
              breakpoints: {
                // when window width is <= 320px
                1750: {
                  slidesPerView: 8,
                  spaceBetween: 0
                },
                // when window width is <= 480px
                1550: {
                  slidesPerView: 7,
                  spaceBetween: 0
                },

                1350: {
                  slidesPerView: 6,
                  spaceBetween: 0
                },

                1150: {
                  slidesPerView: 5,
                  spaceBetween: 0
                },

                950: {
                  slidesPerView: 4,
                  spaceBetween: 0
                },

                750: {
                  slidesPerView: 3,
                  spaceBetween: 0
                },

                550: {
                  slidesPerView: 2,
                  spaceBetween: 0
                },
                // when window width is <= 640px
                350: {
                  slidesPerView: 1,
                  spaceBetween: 0
                }
              }           
              
            });

            var makeBubble = function(){
              for(var i = 0 ; i < 20 ; i++)
              {
                var bubbleName = "Main_Bubble_img_" + (i + 1) + ".jpg";
                var iDiv = document.createElement('div');
                iDiv.className = 'bubble';
                iDiv.style.color = "white";


                var iImg = document.createElement('img');
                iImg.src = $("#asset_url").val() + 'img/main_bubble/'+bubbleName;
                iImg.style.width = "100%";
                iImg.style.height = "100%";
                iImg.style.borderRadius = "50%";
                iDiv.appendChild(iImg);

                $('.welcome_start_bubble_container')[0].appendChild(iDiv);
              }
            };

            makeBubble();
        });

        window.onbeforeunload = function(e) {
        }

/*
        var resizeTitleImg = function(){
          var parentData = $('.welcome_meetup_banner_img_container')[0];
          var imgData = $('.welcome_meetup_banner_img')[0];

          var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);

          if(targetWidth <= window.innerWidth)
          {
            $('.welcome_meetup_banner_img').css('width', '100%');
            $('.welcome_meetup_banner_img').css('height', 'auto');
          }
          else
          {
            $('.welcome_meetup_banner_img').css('width', targetWidth);
            //$('.welcome_meetup_banner_img').css('width', '1920px');
            $('.welcome_meetup_banner_img').css('height', parentData.clientHeight);
          }
        };

        //resizeTitleImg();

        $(window).resize(function() {
          //console.error("adf");
          //resizeTitleImg();
        });
        */
    </script>
    
@endsection