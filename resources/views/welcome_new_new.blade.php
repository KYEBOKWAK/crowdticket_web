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
    <link href="{{ asset('/css/mannayo.css?version=1') }}" rel="stylesheet"/>
    <style>
      p{
        margin-bottom: 10px;
      }
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
@if (Auth::guest())
  <input id='user_nickname' type='hidden' value=''/>
  <input id='user_age' type='hidden' value=''/>
  <input id='user_gender' type='hidden' value=''/>
@else
  <input id='user_nickname' type='hidden' value='{{\Auth::user()->getUserNickName()}}'/>
  <input id='user_age' type='hidden' value='{{\Auth::user()->getUserAge()}}'/>
  <input id='user_gender' type='hidden' value='{{\Auth::user()->getUserGender()}}'/>
@endif

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
              <a href="{{url('/mannayo')}}">
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

    <div class="welcome_content_container">
      <div class="welcome_content_wrapper">
        <div class="flex_layer">
          <div class="welcome_content_title">
            인기있는 만나요
          </div>
          <div class="welcome_content_more_wrapper">
            <a href="{{url('/mannayo')}}">
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
              $isEnd = false;
              ?>
              @if($projectIndex === 0)
              <div class="flex_layer thumb_container_is_mobile">
              @else
              <div class="flex_layer">
              @endif
              <?php
                for($j = $i ; $j < count($meetups) ; $j++)
                {
                  $meetup = $meetups[$projectIndex];

                  //만나요
                  ?>
                  <div class='mannayo_thumb_object_container_in_main'>
                    @if($itemCount === 0)
                    <div class='mannayo_thumb_container' style='margin-right: 20px'>
                    @else
                    <div class='mannayo_thumb_container'>
                    @endif
                      <div class='mannayo_thumb_img_wrapper'>
                        <div class='mannayo_thumb_img_resize'>
                          <img class='mannayo_thumb_img project-img' src="{{$meetup->thumbnail_url}}">
                          <div class='thumb-black-mask'>
                          </div>
                          <div class='mannayo_thumb_meet_count'>
                            <img src='{{ asset("/img/icons/svg/ic-meet-join-member-wh.svg") }}' style='margin-right: 4px; margin-bottom: 3px;'/> {{$meetup->meet_count}} 명 요청중
                          </div>

                          <div class='mannayo_thumb_meet_users_container'>
                            <?php
                            $zIndex = count($meetup->meetup_users);
                            ?>
                            @foreach($meetup->meetup_users as $meetup_user)
                            <img src="{{$meetup_user->user_profile_url}}" class='meetup_users_profile_img' style='z-index:{{$zIndex}}'/>
                            <?php
                              $zIndex--;
                            ?>
                            @endforeach

                            @if($meetup->meet_count >= 4)
                              <img src="{{ asset('/img/icons/ic-profile-more-512.png') }}" class='meetup_users_profile_img' style='z-index:{{$zIndex}}'/>
                            @endif
                          <!--meetupUsersElement-->
                          </div>
                        </div>
                      </div>

                      <div class='mannayo_thumb_title_wrapper'>
                        {{$meetup->title}}
                      </div>
                      <div class='mannayo_thumb_content_container'>
                        {{$meetup->where}} 에서 · {{$meetup->what}}
                      </div>
                      <div class='mannayo_thumb_button_wrapper'>
                        @if($meetup->is_meetup)
                          <button class='mannayo_thumb_meetup_cancel_button_fake' data_meetup_id="{{$meetup->id}}" data_meetup_title="{{$meetup->title}}" data_meetup_where="{{$meetup->where}}" data_meetup_what="{{$meetups[$projectIndex]->what}}" data_meetup_img_url="{{$meetup->thumbnail_url}}" data_meetup_count="{{$meetup->meet_count}}">
                            만나요 요청됨
                          </button>
                        @else
                          <button class='mannayo_thumb_meetup_button_fake' data_meetup_id="{{$meetup->id}}" data_meetup_title="{{$meetup->title}}" data_meetup_where="{{$meetup->where}}" data_meetup_what="{{$meetup->what}}" data_meetup_img_url="{{$meetup->thumbnail_url}}" data_meetup_count="{{$meetup->meet_count}}">
                            만나요
                          </button>
                        @endif
                      </div>
                      @if($meetup->is_meetup)
                        <button class='mannayo_thumb_meetup_cancel_button' data_meetup_id="{{$meetup->id}}" data_meetup_title="{{$meetup->title}}" data_meetup_where="{{$meetup->where}}" data_meetup_what="{{$meetup->what}}" data_meetup_img_url="{{$meetup->thumbnail_url}}" data_meetup_count="{{$meetup->meet_count}}">
                        </button>
                      @else
                        <button class='mannayo_thumb_meetup_button' data_meetup_id="{{$meetup->id}}" data_meetup_title="{{$meetup->title}}" data_meetup_where="{{$meetup->where}}" data_meetup_what="{{$meetup->what}}" data_meetup_img_url="{{$meetup->thumbnail_url}}" data_meetup_count="{{$meetup->meet_count}}">
                        </button>
                      @endif
                    </div>
                  </div>
                  <?php
                  $projectIndex++;
                  $itemCount++;
                  
                  if(count($meetups) < $projectIndex + 1)
                  {
                    $isEnd = true;
                    break;
                  }

                  if($itemCount >= $mobileOneLineItemCount)
                  {
                    break;
                  }

                  
                }
              ?>
              </div>
              <?php
              if($isEnd)
              {
                break;
              }
            }             
            ?>           
          </div>
        </div>
        <!-- 썸네일 테스트 END -->
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
        const AGE_NONE_TYPE_OPTION = 9999;//선택되지 않은 년생 option 값
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

            //만나요//
            var completeMeetUpPopup = function(creator_title){
              var elementPopup = document.createElement("div");
              elementPopup.innerHTML = 
              "<button class='meetup_popup_complete_button'>" + 
                "<div class='meetup_popup_complete_img'>" +
                  "<img src='{{ asset('/img/icons/svg/ic-meet-popup-highfive.svg') }}' style=''/>" +
                "</div>" +
                "<p>" +
                  "<span style='font-weight: bold; color: #43c9f0;'>" + creator_title + "</span>" +
                  " 과의 만나요 요청이 완료되었습니다." +
                "</p>" +
              "</button>";

              swal({
                      content: elementPopup,
                      allowOutsideClick: "true",
                      className: "meetup_popup_complete",
                      closeOnClickOutside: true,
                      closeOnEsc: true,
                      timer: 1300,
                  }).then(function(value){
                    showLoadingPopup('');
                    window.location.reload();
                  });

              $(".swal-footer").hide();

              $('.meetup_popup_complete_button').click(function(){
                  swal.close();
              });
            };

            var callUserInfo = function(){
              var url="/mannayo/user/info";
              var method = 'get';
              var data =
              {
                
              }
              var success = function(request) {
                if(request.state === 'success'){
                  $('#user_nickname').val(request.user_nickname);
                  $('#user_age').val(request.user_age);
                  $('#user_gender').val(request.user_gender);
                }
              };
              
              var error = function(request) {
                
              };
              
              $.ajax({
              'url': url,
              'method': method,
              'data' : data,
              'success': success,
              'error': error
              });
            };

            var closeLoginPopup = function(){
              callUserInfo();

              swal('로그인 완료!', '', 'success').then(function(value){
                window.location.reload();
              });
            };

            var checkMeetup = function(meetup_id){
              if(!meetup_id || meetup_id === '0')
              {
                alert("만나요 ID 값 에러");
                return false;
              };

              if(!$('input:radio[name=gender]:checked').val()){
                alert("성별을 선택해주세요.");
                return false;
              };

              if(Number($(".age_user_select").val()) === AGE_NONE_TYPE_OPTION){
                alert("생년을 선택해주세요.");
                return false;
              };

              return true;
            };

            var createCallYouPopup = function(contactNumber, email, creator_title){          
              var elementPopup = document.createElement("div");
              elementPopup.innerHTML = 
              "<div class='meetup_callyou_popup_container'>" + 
                "<div class='meetup_callyou_popup_title'>" + 
                  "아래 연락처로 알림을 드릴게요" +
                "</div>" +
                "<input id='meetup_callyou_popup_option_contact_input' class='meetup_callyou_popup_input' type='tel' name='tel' placeholder='연락처가 없습니다. (-없이 숫자만 입력)' value='"+contactNumber+"'/>" + 
                "<input id='meetup_callyou_popup_option_email_input' class='meetup_callyou_popup_input' type='email' placeholder='이메일 주소' value='"+email+"' disabled='disabled'/>" + 

                "<button id='meetup_callyou_popup_ok_button'>" +
                  "확인" +
                "</button>" +
                "<p class='meetup_callyou_help_block'>" + 
                  "정보가 없을 경우 알림을 드릴 수 없어요!" +
                "</p>" +
              "</div>" +

              "<div class='popup_close_button_wrapper'>" +
                  "<button type='button' class='popup_close_button'>" + 
                      "<img src='{{ asset('/img/makeevent/svg/ic-exit.svg') }}'>" +
                  "</button>" +
              "</div>";

              swal({
                      content: elementPopup,
                      allowOutsideClick: "true",
                      className: "popup_call_meetup",
                      closeOnClickOutside: false,
                      closeOnEsc: false
                  });

              $(".swal-footer").hide();

              $('.popup_close_button').click(function(){
                  swal.close();
                  completeMeetUpPopup(creator_title);
              });

              var requestSetUserInfo = function(){
                //값이 변경됐을때만 요청한다.
                var inputContactValue = $('#meetup_callyou_popup_option_contact_input').val();
                if(contactNumber === inputContactValue)
                {
                  console.error('same number');
                  return;
                }

                var url="/mannayo/user/info/set";
                var method = 'post';
                var data =
                {
                  "contact" : inputContactValue
                }
                var success = function(request) {
                  
                };
                
                var error = function(request) {
                  console.error("error!!?");
                };
                
                $.ajax({
                'url': url,
                'method': method,
                'data' : data,
                'success': success,
                'error': error
                });
              };

              $("#meetup_callyou_popup_ok_button").click(function(){
                if($('#meetup_callyou_popup_option_contact_input').val() && !isCheckPhoneNumber($('#meetup_callyou_popup_option_contact_input').val())){
                  return false;
                }
                requestSetUserInfo();
                swal.close();
                completeMeetUpPopup(creator_title);
              });

              if(email.indexOf("facebook.com") > 0){
                $('#meetup_callyou_popup_option_email_input').hide();
              }

              $('.swal-content').css('margin-top', '32px;');
              $('.swal-content').css('margin-bottom', '32px;');
            };

            var requestMeetUp = function(meetup_id){
              if(!checkMeetup(meetup_id))
              {
                return;
              }

              loadingProcess($("#meetup_up_button"));
              $(".popup_close_button_wrapper").hide();

              var url="/mannayo/meetup";
              var method = 'post';
              var data =
              {
                "meetup_id" : meetup_id,
                "nick_name" : $("#meetup_popup_user_nickname_input").val(),
                "anonymity" : Number($("#meetup_popup_user_anonymous_inputbox").is(":checked")),
                "gender" : $('input:radio[name=gender]:checked').val(),
                "age" : $(".age_user_select").val()
              }
              var success = function(request) {
                loadingProcessStop($("#meetup_up_button"));
                $(".popup_close_button_wrapper").show();

                if(request.state === 'success')
                {
                  createCallYouPopup(request.data.contact, request.data.email, request.data.creator_title);
                }
                else
                {
                  alert(request.message);
                }
              };
              
              var error = function(request) {
                loadingProcessStop($("#meetup_up_button"));
                $(".popup_close_button_wrapper").show();
                alert('만나요 실패. 다시 시도해주세요.');
              };
              
              $.ajax({
              'url': url,
              'method': method,
              'data' : data,
              'success': success,
              'error': error
              });
              
            };

            //만나요 요청 팝업 START
            var openMeetPopup = function(meetup_id, meetup_title, meetup_where, meetup_what, meetup_img_url, meetup_count){
              var ageOptions = '';

              var nowYear = Number(new Date().getFullYear());
              for(var i = 1900 ; i <= nowYear ; i++ )
              {
                ageOptions += "<option value='"+ i +"'>" + i + "</option>";
              }

              //마지막 옵션은 나이 선택란.
              ageOptions += "<option value='"+ AGE_NONE_TYPE_OPTION +"' selected>" + "년도 선택" + "</option>";

              var nickName = $('#user_nickname').val();
              
              var elementPopup = document.createElement("div");
              elementPopup.innerHTML = 
              
              "<div class='meetup_popup_container'>" + 
                "<div class='meetup_popup_title_container'>" +
                  "<h2>만나요</h2>" +
                "</div>" +

                "<div class='meetup_popup_thumb_container'>" + 
                  "<img src='"+meetup_img_url+"' style='width: 80px; height: 80px; border-radius: 100%;'>" +
                "</div>" +

                "<div class='meetup_popup_content_container'>" + 
                  "<p><span class='meetup_popup_content_point_color'>"+meetup_title+"</span> 과/와 <span class='meetup_popup_content_point_color'>"+meetup_where+"</span> 에서 <br>" + 
                  "<span class='meetup_popup_content_point_color'>" + meetup_what +"</span>" + " 를 하고 싶어요!" +
                  "</p>" +
                "</div>" +

                "<div class='meetup_popup_meet_count_container'>" +
                  "<div class='meetup_count_loading_container'>" +
                    //"<p class='searching'>🔥 <span class='searching_span'>.</span><span class='searching_span'>.</span><span class='searching_span'>.</span> 명이 만나고 싶어해요</p>" +
                    "<p>🔥 "+meetup_count+" 명이 만나고 싶어해요</p>" +
                  "</div>" +
                  "<p>함께 할수록 이벤트가 성사될 가능성이 높아요!</p>" +
                "</div>" +

                

                "<div class='meetup_popup_line'>" + 
                "</div>" +

                "<div class='meetup_popup_user_container'>" +
                  "<div class='meetup_popup_user_wrapper flex_layer'>" +
                    "<div class='meetup_popup_user_label'>" +
                      "닉네임" +
                    "</div>" +
                    "<div class='meetup_popup_user_options_container'>" + 
                      "<input id='meetup_popup_user_nickname_input' type='text' class='meetup_popup_user_nickname_input' value='"+nickName+"'/>" +
                      "<div class='flex_layer'>" +
                        "<div class='meetup_checkbox_wrapper'>" +
                          "<input id='meetup_popup_user_anonymous_inputbox' type='checkbox' class='meetup_popup_user_anonymous_inputbox' value=''/>" +
                          "<img class='meetup_checkbox_img meetup_checkbox_img_select' src='{{ asset('/img/icons/svg/ic-checkbox-btn-s.svg') }}'/>" +
                          "<img class='meetup_checkbox_img meetup_checkbox_img_unselect' src='{{ asset('/img/icons/svg/ic-checkbox-btn-n.svg') }}'/>" +
                        "</div>" +
                        "<p class='meetup_popup_user_anonymous_text'>익명</p>" +
                      "</div>" +
                      "<p class='help-block'>닉네임을 지우시면 회원 이름이 공개됩니다.</p>" +
                    "</div>" +
                  "</div>" +

                  "<div class='meetup_popup_user_wrapper flex_layer'>" +
                    "<div class='meetup_popup_user_label'>" +
                      "성별" +
                    "</div>" +
                    "<div class='meetup_popup_user_options_container flex_layer'>" + 
                      "<div class='meetup_radio_wrapper'>" +
                        "<img class='meetup_radio_img meetup_radio_img_select meetup_radio_type_m_select' src='{{ asset('/img/icons/svg/radio-btn-s.svg') }}'/>" +
                        "<img class='meetup_radio_img meetup_radio_img_unselect meetup_radio_type_m_unselect' src='{{ asset('/img/icons/svg/radio-btn-n.svg') }}'/>" +
                        "<input class='meetup_popup_user_gender_input' type='radio' name='gender' value='m'/>" +
                      "</div>" +
                      "<p class='meetup_popup_user_option_gender_text' style='margin-right: 40px;'>남</p>" + 
                      "<div class='meetup_radio_wrapper'>" +
                        "<img class='meetup_radio_img meetup_radio_img_select meetup_radio_type_f_select' src='{{ asset('/img/icons/svg/radio-btn-s.svg') }}'/>" +
                        "<img class='meetup_radio_img meetup_radio_img_unselect meetup_radio_type_f_unselect' src='{{ asset('/img/icons/svg/radio-btn-n.svg') }}'/>" +
                        "<input class='meetup_popup_user_gender_input' type='radio' name='gender' value='f'/>" +
                      "</div>" +
                      "<p class='meetup_popup_user_option_gender_text'>여</p>" + 
                    "</div>" +
                  "</div>" +

                  "<div class='meetup_popup_user_wrapper flex_layer'>" +
                    "<div class='meetup_popup_user_label' style='margin-top: 16px;'>" +
                      "년생" +
                    "</div>" +
                    "<div class='meetup_popup_user_age_container'>" + 
                      "<div class='meetup_popup_city_text_container flex_layer'>" +
                        "<p id='meetup_popup_user_age_text'>년도 선택</p>" +
                        "<img src='{{ asset('/img/icons/svg/icon-box.svg') }}' style='margin-right: 16px;'>" +
                      "</div>" +
                      "<select class='age_user_select' name='age_user'>" +
                          ageOptions +
                      "</select>" +
                    "</div>" +
                  "</div>" +

                "</div>" +

                "<div class='meetup_new_button_wrapper'>" +
                  "<button id='meetup_up_button' data_meetup_id='"+meetup_id+"'>" +
                    "만나요 요청" +
                  "</button>" +
                "</div>" +
                "<p class='meetup_popup_bottom_label'>이벤트가 성사되면 가장먼저 초대해 드리겠습니다</p>" +
              "</div>" +

              "<div class='popup_close_button_wrapper'>" +
                  "<button type='button' class='popup_close_button'>" + 
                      "<img src='{{ asset('/img/makeevent/svg/ic-exit.svg') }}'>" +
                  "</button>" +
              "</div>";


              swal({
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

              $(".age_user_select").change(function(){
                if(Number($(this).val()) === AGE_NONE_TYPE_OPTION)
                {
                  $("#meetup_popup_user_age_text").text("년도 선택");
                }
                else
                {
                  $("#meetup_popup_user_age_text").text($(this).val());
                }
                
              });

              var checkboxImgToggle = function(isChecked){
                if(isChecked){
                  $(".meetup_checkbox_img_select").show();
                  $(".meetup_checkbox_img_unselect").hide();
                }
                else{
                  $(".meetup_checkbox_img_select").hide();
                  $(".meetup_checkbox_img_unselect").show();
                }
              }

              $("#meetup_popup_user_anonymous_inputbox").change(function(){
                if($(this).is(":checked")){
                  //익명 체크하면
                  $("#meetup_popup_user_nickname_input").attr("disabled",true);
                  $("#meetup_popup_user_nickname_input").css('background-color', '#f7f7f7');
                  $("#meetup_popup_user_nickname_input").val('익명');
                  checkboxImgToggle(true);
                }
                else{
                  $("#meetup_popup_user_nickname_input").attr("disabled",false);
                  $("#meetup_popup_user_nickname_input").css('background-color', 'white');
                  $("#meetup_popup_user_nickname_input").val(nickName);
                  checkboxImgToggle(false);
                }
                
              });

              var setRadioInputImg = function(){
                if($('input:radio[name=gender]:checked').val() === 'm'){
                  $('.meetup_radio_type_m_select').show();
                  $('.meetup_radio_type_m_unselect').hide();

                  $('.meetup_radio_type_f_select').hide();
                  $('.meetup_radio_type_f_unselect').show();
                }
                else{
                  $('.meetup_radio_type_m_select').hide();
                  $('.meetup_radio_type_m_unselect').show();

                  $('.meetup_radio_type_f_select').show();
                  $('.meetup_radio_type_f_unselect').hide();
                }
              }

              if($("#user_gender").val())
              {
                $('input:radio[name=gender]:input[value=' + $("#user_gender").val() + ']').attr("checked", true); 
                setRadioInputImg();
              }

              $('.meetup_popup_user_gender_input').click(function(){
                setRadioInputImg();
              });

              if($("#user_age").val())
              {
                $(".age_user_select").val($("#user_age").val());
                $("#meetup_popup_user_age_text").text($("#user_age").val());
              }

              $("#meetup_up_button").click(function(){
                requestMeetUp($(this).attr('data_meetup_id'));
              });

              var setMeetupCounter = function(counter){
                $(".meetup_count_loading_container").children().remove();

                var element = document.createElement("div");
                element.innerHTML = 
                "<p>🔥 "+Number(counter)+" 명이 만나고 싶어해요</p>";

                $(".meetup_count_loading_container").append(element);
              };

              var requestMeetupCounter = function(){
                var url="/mannayo/get/meetup/count";
                var method = 'get';
                var data =
                {
                    "meetup_id" : meetup_id
                }
                var success = function(request) {
                  setMeetupCounter(request.counter);
                };
                
                var error = function(request) {
                  setMeetupCounter("???");
                };

                $.ajax({
                'url': url,
                'method': method,
                'data' : data,
                'success': success,
                'error': error
                });
              };
            };
            //만나요 요청 팝업 END

            var setMannayoListMeetupButton = function(){
              $(".mannayo_thumb_meetup_button").click(function(){
                if(!isLogin())
                {
                  loginPopup(closeLoginPopup, null);
                  return;
                }

                var element = $(this);
                openMeetPopup(element.attr("data_meetup_id"), element.attr("data_meetup_title"), element.attr("data_meetup_where"), element.attr("data_meetup_what"), element.attr("data_meetup_img_url"), element.attr("data_meetup_count"));
              });
            };

            var requestCancelMeetUp = function(meetup_id){
              loadingProcess($("#meetup_cancel_button"));
              $(".popup_close_button_wrapper").hide();

              var url="/mannayo/meetup/cancel";
              var method = 'post';
              var data =
              {
                "meetup_id" : meetup_id
              }
              var success = function(request) {
                loadingProcessStop($("#meetup_cancel_button"));
                $(".popup_close_button_wrapper").show();

                if(request.state === 'success')
                {
                  var elementPopup = document.createElement("div");
                  elementPopup.innerHTML = 
                  
                  "<div class='meetup_popup_container'>" + 
                    "<div class='meetup_popup_title_container'>" +
                      "<h3>만나요 취소 완료</h3>" +
                    "</div>" +

                    "<div class='meetup_popup_cancel_callback'>" + 
                      "<p>" +
                        "만나요 요청이 취소되었습니다." +
                      "</p>" +
                    "</div>" +

                    "<div class='meetup_new_button_wrapper' style='margin-top: 40px;'>" +
                      "<button class='meetup_popup_cancel_callback_ok'>" +
                        "확인" +
                      "</button>" +
                    "</div>" +
                  "</div>"

                  swal({
                          content: elementPopup,
                          allowOutsideClick: "true",
                          className: "mannayo_alert_popup",
                          closeOnClickOutside: true,
                          closeOnEsc: true
                      }).then(function(value){
                        showLoadingPopup('');
                        window.location.reload();
                      });

                  $(".swal-footer").hide();

                  $('.meetup_popup_cancel_callback_ok').click(function(){
                    swal.close();
                  });
                }
                else
                {
                  alert(request.message);
                }
              };
              
              var error = function(request) {
                loadingProcessStop($("#meetup_cancel_button"));
                $(".popup_close_button_wrapper").show();
                alert('만나요 취소 실패. 다시 시도해주세요.');
              };
              
              $.ajax({
              'url': url,
              'method': method,
              'data' : data,
              'success': success,
              'error': error
              });
              
            };

            //만나요 취소 팝업 START
            var openCancelPopup = function(meetup_id, meetup_title, meetup_where, meetup_what, meetup_img_url, meetup_count){        
              var elementPopup = document.createElement("div");
              elementPopup.innerHTML = 
              
              "<div class='meetup_popup_container'>" + 
                "<div class='meetup_popup_title_container'>" +
                  "<h2>만나요</h2>" +
                "</div>" +

                "<div class='meetup_popup_thumb_container'>" + 
                  "<img src='"+meetup_img_url+"' style='width: 80px; height: 80px; border-radius: 100%;'>" +
                "</div>" +

                "<div class='meetup_popup_content_container'>" + 
                  "<p><span class='meetup_popup_content_point_color'>"+meetup_title+"</span> 과/와 <span class='meetup_popup_content_point_color'>"+meetup_where+"</span> 에서 <br>" + 
                  "<span class='meetup_popup_content_point_color'>" + meetup_what +"</span>" + " 를 하고 싶어요!" +
                  "</p>" +
                "</div>" +

                "<div class='meetup_popup_meet_count_container'>" +
                  "<div class='meetup_count_loading_container'>" +
                    //"<p class='searching'>🔥 <span class='searching_span'>.</span><span class='searching_span'>.</span><span class='searching_span'>.</span> 명이 만나고 싶어해요</p>" +
                    "<p>🔥 "+meetup_count+" 명이 만나고 싶어해요</p>" +
                  "</div>" +
                  "<p>함께 할수록 이벤트가 성사될 가능성이 높아요!</p>" +
                "</div>" +

                "<div class='meetup_new_button_wrapper'>" +
                  "<button id='meetup_cancel_button' data_meetup_id='"+meetup_id+"'>" +
                    "만나요 요청 취소" +
                  "</button>" +
                "</div>" +
                "<p class='meetup_popup_bottom_label'>이벤트가 성사되면 가장먼저 초대해 드리겠습니다</p>" +
              "</div>" +

              "<div class='popup_close_button_wrapper'>" +
                  "<button type='button' class='popup_close_button'>" + 
                      "<img src='{{ asset('/img/makeevent/svg/ic-exit.svg') }}'>" +
                  "</button>" +
              "</div>";


              swal({
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

              $("#meetup_cancel_button").click(function(){
                //requestMeetUp($(this).attr('data_meetup_id'));
                requestCancelMeetUp($(this).attr('data_meetup_id'));
              });

              var setMeetupCounter = function(counter){
                $(".meetup_count_loading_container").children().remove();

                var element = document.createElement("div");
                element.innerHTML = 
                "<p>🔥 "+Number(counter)+" 명이 만나고 싶어해요</p>";

                $(".meetup_count_loading_container").append(element);
              };

              var requestMeetupCounter = function(){
                var url="/mannayo/get/meetup/count";
                var method = 'get';
                var data =
                {
                    "meetup_id" : meetup_id
                }
                var success = function(request) {
                  setMeetupCounter(request.counter);
                };
                
                var error = function(request) {
                  setMeetupCounter("???");
                };

                $.ajax({
                'url': url,
                'method': method,
                'data' : data,
                'success': success,
                'error': error
                });
              };
            };
            //만나요 취소 팝업 END

            var setMannayoCancelButton = function(){
              $(".mannayo_thumb_meetup_cancel_button").click(function(){
                if(!isLogin())
                {
                  loginPopup(closeLoginPopup, null);
                  return;
                }

                var element = $(this);
                openCancelPopup(element.attr("data_meetup_id"), element.attr("data_meetup_title"), element.attr("data_meetup_where"), element.attr("data_meetup_what"), element.attr("data_meetup_img_url"), element.attr("data_meetup_count"));
              });
            };

            setMannayoListMeetupButton();
            setMannayoCancelButton();

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