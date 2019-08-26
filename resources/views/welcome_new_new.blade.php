@extends('app')
@section('meta')
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="크티 : 크라우드티켓"/>
    <meta property="og:description" content="팬중심 크리에이터 밋업 플랫폼"/>
    <meta property="og:image" content="{{ asset('/img/app/og_image_2.png') }}"/>
    <meta property="og:url" content="https://crowdticket.kr/"/>
@endsection
@section('css')
    <link href="{{ asset('/css/simple-scrollbar.css?version=1') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/mannayo.css?version=11') }}" rel="stylesheet"/>
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
        }

        .welcome_banner_2{
          width: 520px;
          height: 128px;
          border-radius: 10px;
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

        .welcome_banner_img{
          width: 100%;
          border-radius: 10px;
        }

        .welcome_meetup_banner_title_pc{
            display: block;
          }

          .welcome_meetup_banner_title_mobile{
            display: none;
          }

        /*@media (max-width:320px) {*/
        @media (max-width:1060px) {
          .welcome_meetup_banner_title_pc{
            display: none;
          }

          .welcome_meetup_banner_title_mobile{
            display: block;
          }

          .welcome_content_container_banner{
            width: 100%;
          }

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

          .welcome_thumb_content_container{
            margin-top: 12px;
          }

          .welcome_thumb_content_disc{
            margin-bottom: 5px;
          }

          .welcome_banner_mobile{
            width: 100%;
            /*height: 78px;*/
            height: 100%;
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

          .welcome_banner_img{
            border-radius: 0px;
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
    @if(count($thumbEventProjects) > 0)
      <div class="welcome_content_container">
        <div class="welcome_content_wrapper">
          <div class="flex_layer">
            <div class="welcome_content_title">
              샌드박스 추석 이벤트
            </div>
            <div class="welcome_content_more_wrapper">
              <a href="{{url('/mcn/sandbox')}}">
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
                  for($j = $i ; $j < count($thumbEventProjects) ; $j++)
                  {
                    ?>
                    @include('template.thumb_project', ['project' => $thumbEventProjects[$projectIndex], 'index' => $projectIndex])
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
    @endif

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

          <div class="welcome_meetup_banner_title welcome_meetup_banner_title_pc">
            내가 좋아하는 사람을 화면 밖에서 만나는 인생경험
          </div>

          <div class="welcome_meetup_banner_title welcome_meetup_banner_title_mobile">
            내가 좋아하는 사람을<br> 화면 밖에서 만나는 인생경험
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
                            <img src='{{ asset("/img/icons/svg/ic-meet-join-member-wh.svg") }}' style='margin-right: 4px; margin-bottom: 3px;'/> {{$meetup->meet_count}}명 요청중
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
                            <button class='mannayo_thumb_user_list_thumb_button' data_meetup_id="{{$meetup->id}}">
                            </button>
                          </div>
                        </div>

                        <div class='mannayo_thumb_user_name_container mannayo_thumb_user_name_container_{{$meetup->id}}'>
                          <div class='mannayo_thumb_user_container_arrow'>
                          </div>
                          <div class='mannayo_thumb_user_name_ul_container'>
                            <ul>
                              @foreach($meetup->meetup_users as $meetup_user)
                                <li class='text-ellipsize'>{{$meetup_user->user_name}}</li>
                              @endforeach
                              @if($meetup->meet_count >= 4)
                                <li>외 {{(int)$meetup->meet_count - count($meetup->meetup_users)}}명</li>
                              @endif
                            </ul>
                          </div>
                        </div>
                      </div>

                      <div class='mannayo_thumb_title_wrapper'>
                        {{$meetup->title}}
                      </div>
                      <div class='text-ellipsize-2 mannayo_thumb_content_container'>
                        {{$meetup->where}} 에서 · {{$meetup->what}}
                      </div>
                      <div class='mannayo_thumb_button_wrapper'>
                        @if($meetup->is_meetup)
                          <button class='mannayo_thumb_meetup_cancel_button_fake'>
                            만나요 요청됨
                          </button>
                        @else
                          <button class='mannayo_thumb_meetup_button_fake'>
                            만나요
                          </button>
                        @endif
                      </div>
                      @if($meetup->is_meetup)
                        <button class='mannayo_thumb_meetup_cancel_button' data_meetup_channel_id="{{$meetup->channel_id}}" data_meetup_id="{{$meetup->id}}" data_meetup_title="{{$meetup->title}}" data_meetup_where="{{$meetup->where}}" data_meetup_what="{{$meetup->what}}" data_meetup_img_url="{{$meetup->thumbnail_url}}" data_meetup_count="{{$meetup->meet_count}}" data_comments_count="{{$meetup->comments_count}}">
                        </button>
                      @else
                        <button class='mannayo_thumb_meetup_button' data_meetup_channel_id="{{$meetup->channel_id}}" data_meetup_id="{{$meetup->id}}" data_meetup_title="{{$meetup->title}}" data_meetup_where="{{$meetup->where}}" data_meetup_what="{{$meetup->what}}" data_meetup_img_url="{{$meetup->thumbnail_url}}" data_meetup_count="{{$meetup->meet_count}}" data_comments_count="{{$meetup->comments_count}}">
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
    
    <div class="welcome_content_container welcome_content_container_banner">
      <div class="welcome_content_wrapper">
        <div class="welcome_banner_container">
          <div class="flex_layer_thumb">
              <div class="welcome_banner_1 welcome_banner_mobile">
                <a href='{{url("/magazine/12")}}'>
                  <img class='welcome_banner_img' src='https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/190718_banner_1.png'>
                </a>
              </div>
            
              <div class="welcome_banner_2 welcome_banner_mobile">
                <a href='{{url("/magazine/13")}}'>
                  <img class='welcome_banner_img' src='https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/190718_1357_banner_2.png'>
                </a>
              </div>
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
    <script src="{{ asset('/js/simple-scrollbar.js?version=1') }}"></script>
    <script src="{{ asset('/js/lib/clipboard.min.js') }}"></script>
    <script>
        const AGE_NONE_TYPE_OPTION = 9999;//선택되지 않은 년생 option 값

        const CALL_MANNAYO_POPUP_ONCE_USERS_MAX_COUNT = 12; //팝업시 유저 정보 요청수
        const CALL_MANNAYO_POPUP_ONCE_USERS_COMMENT_MAX_COUNT = 12; //팝업시 유저 정보 요청수
        
        const TYPE_TAB_MEETUP_POPUP_MEET = 0;
        const TYPE_TAB_MEETUP_POPUP_UESRS = 1;
        const TYPE_TAB_MEETUP_POPUP_COMMENT = 2;

        const POPUP_HEIGHT = 805;
        const POPUP_CANCEL_HEIGHT = 805;

        var g_nowOpenPopup_meetup_id = 0;

        $(document).ready(function () {
            $('.count-ani').counterUp({
                delay: 10,
                time: 1000
            });

            if($("#isNotYet").val() == "TRUE"){
              alert("준비중입니다.");
            }

            var setScrollUI = function(selector){
              var el = document.querySelector(selector);
              SimpleScrollbar.initEl(el);
            };

            var setCommentCounterText = function(string){
              $('.mannayo_popup_tab_comment_counter_text').text(string);
            };

            var resetScrollContentHeight = function(){
              var popupMarginBottom = parseInt($('.blueprint_popup').css("margin-bottom"));
              var popupTotalHeight = $('.blueprint_popup').position().top + $('.blueprint_popup').outerHeight(true) - popupMarginBottom - 5;
              var commentContainerHeight = $('.mannayo_meetup_popup_comments_ul_wrapper').position().top + $('.mannayo_meetup_popup_comments_ul_wrapper').outerHeight(true);

              if(commentContainerHeight > popupTotalHeight)
              {
                //코멘트 사이즈가 팝업의 토탈 사이즈를 넘어가면 재조정 해준다.
                var gap = commentContainerHeight - popupTotalHeight;
                var commentHeight = $('.mannayo_meetup_popup_comments_ul_wrapper').outerHeight(true) - gap;
                
                $('.mannayo_meetup_popup_comments_ul_wrapper').css('height', commentHeight + 'px');
              }
            };

            var resetPopupContentHeight = function(){
              var heightPx = $('.swal-content').outerHeight(true);
              $('.blueprint_popup').css('height', heightPx+'px');
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

              $(".popup_call_meetup").css('height', 'auto');

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
              $(".mannayo_popup_close_button_wrapper").hide();

              resetPopupContentHeight();

              var url="/mannayo/meetup";
              var method = 'post';
              var data =
              {
                "meetup_id" : meetup_id,
                "nick_name" : $("#meetup_popup_user_nickname_input").val(),
                "anonymity" : Number($("#meetup_popup_user_anonymous_inputbox").is(":checked")),
                "gender" : $('input:radio[name=gender]:checked').val(),
                "age" : $(".age_user_select").val(),
                "comment" : $('#meetup_popup_option_comment_input').val()
              }
              var success = function(request) {
                loadingProcessStop($("#meetup_up_button"));
                $(".mannayo_popup_close_button_wrapper").show();

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
                $(".mannayo_popup_close_button_wrapper").show();
                resetPopupContentHeight();
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
            var openMeetPopup = function(meetup_channel_id, meetup_id, meetup_title, meetup_where, meetup_what, meetup_img_url, meetup_count, comments_count){
              g_nowOpenPopup_meetup_id = meetup_id;
              g_nowOpenPopup_meetup_channel = meetup_channel_id;

              var youtubeLink = 'https://www.youtube.com/channel/'+g_nowOpenPopup_meetup_channel;

              var sharedLink = $('#base_url').val() + '/mannayo/share/meetup/'+meetup_id;
              var makeTabTitleInPopup = function(meetup_count){
                return "<div class='flex_layer'>" +
                  "<div data_tab_index='0' class='mannayo_popup_tab_button mannayo_popup_tab_button_active' type='button'>만나요</div>" +
                  "<div data_tab_index='1' class='mannayo_popup_tab_button' type='button'>" +
                    "<div class='flex_layer'>" +
                      "참여한 유저<p class='mannayo_popup_tab_counter_text'>"+meetup_count+"</p>" +
                    "</div>" +
                  "</div>" +
                  "<div data_tab_index='2' class='mannayo_popup_tab_button' type='button'>" +
                    "<div class='flex_layer'>" +
                        "댓글<p class='mannayo_popup_tab_counter_text mannayo_popup_tab_comment_counter_text'>"+"</p>" +
                    "</div>" +
                  "</div>" +

                  "<div class='mannayo_popup_tab_title_right_wrapper'>" +
                    "<div class='flex_layer'>" +
                      "<div class='mannayo_popup_close_button_wrapper' style='margin-right: 12px;'>" +
                        "<button type='button' class='popup_share_button popup_close_button_meetup_popup' data-clipboard-text='"+sharedLink+"'>" + 
                          "<img src='{{ asset('/img/icons/svg/ic-share.svg') }}'>" +
                        "</button>" +
                      "</div>" +
                      "<div class='mannayo_popup_close_button_wrapper'>" +
                        "<button type='button' class='popup_close_button popup_close_button_meetup_popup'>" + 
                          "<img src='{{ asset('/img/icons/svg/ic-exit.svg') }}'>" +
                        "</button>" +
                      "</div>" +
                    "</div>" +
                  "</div>" +
                  
                "</div>";
              };

              var makeMeetupContent = function(meetup_img_url, meetup_title, meetup_where, meetup_what, meetup_count, nickName, ageOptions, meetup_id){
                return "<div class='meetup_popup_container'>" + 
                  "<div class='meetup_popup_thumb_container'>" + 
                    "<a href='"+youtubeLink+"' target='_blank'><img src='"+meetup_img_url+"' style='width: 80px; height: 80px; border-radius: 100%;'></a>" +
                  "</div>" +

                  "<div class='meetup_popup_content_container'>" + 
                    "<p><span class='meetup_popup_content_point_color'><u><a href='"+youtubeLink+"' target='_blank'>"+meetup_title+"</a></u></span> 과/와 <span class='meetup_popup_content_point_color'>"+meetup_where+"</span> 에서 <br>" + 
                    "<span class='meetup_popup_content_point_color' style='word-break: break-all'>" + meetup_what +"</span>" + " 를 하고 싶어요!" +
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

                    "<div class='meetup_popup_option_wrapper'>" +
                      "<div class='meetup_popup_option_creator meetup_popup_option_comment_input_wrapper'>" +
                        "<input id='meetup_popup_option_comment_input' placeholder='크리에이터에게 한마디 (선택)'/>" + 
                      "</div>" +
                    "</div>" +
                  "</div>" +

                  "<div class='meetup_new_button_wrapper'>" +
                    "<button id='meetup_up_button' data_meetup_id='"+meetup_id+"'>" +
                      "만나요 요청" +
                    "</button>" +
                  "</div>" +
                  "<p class='meetup_popup_bottom_label'>이벤트가 성사되면 가장먼저 초대해 드리겠습니다</p>" +
                "</div>";
              };

              var makeMeetupUsers = function(){
                return  "<div class='mannayo_meetup_popup_users_container'>" + 
                          "<div class='mannayo_meetup_popup_users_ul_wrapper'>" +
                            "<ul class='mannayo_meetup_popup_users_ul'>" +
                            "</ul>" +
                          "</div>" +
                          "<div class='mannayo_meetup_popup_scroll_bottom_fake_offset'>" +
                          "</div>" +
                        "</div>";
              };

              var makeMeetupComments = function(){
                return  "<div class='mannayo_meetup_popup_comments_container'>" + 

                          "<form id='mannayo_comments_form' action='{{ url('/mannayo') }}/"+meetup_id+"/comments' method='post' data-toggle='validator' role='form' class='ps-detail-comment-wrapper'>" +
                              "<textarea id='input_mannayo_comments' maxlength='255' name='contents' class='form-control' rows='3' placeholder='만나요 댓글을 자유롭게 남겨주세요!'></textarea>" +
                              "<p class='comments_length_text'>0/255</p>" +
                              "<button type='button' class='btn btn-success pull-right mannayo_comments_button'>댓글달기</button>" +
                              "<div class='clear'></div>" +
                              "<input type='hidden' name='_token' value='{{ csrf_token() }}'/>" + 
                          "</form>" +


                          "<div class='mannayo_meetup_popup_comments_ul_wrapper'>" +
                            "<ul class='mannayo_meetup_popup_comments_ul'>" +
                            "</ul>" +
                          "</div>" +
                          "<div class='mannayo_meetup_popup_scroll_bottom_comments_fake_offset'>" +
                          "</div>" +
                        "</div>";
              };
              
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
              elementPopup.className = 'meetup_popup_container_wrapper'
              elementPopup.innerHTML = 
              makeTabTitleInPopup(meetup_count) + 
              makeMeetupContent(meetup_img_url, meetup_title, meetup_where, meetup_what, meetup_count, nickName, ageOptions, meetup_id) + 
              makeMeetupUsers() + 
              makeMeetupComments();

              stopDocumentScroll();
              swal({
                      content: elementPopup,
                      allowOutsideClick: "true",
                      className: "blueprint_popup",
                      closeOnClickOutside: false,
                      closeOnEsc: false
                  }).then(function(){
                    reStartDocumentScroll();
                  });

              $(".swal-footer").hide();

              $('.popup_close_button').click(function(){
                  swal.close();
              });

              isWordLengthCheck($('#input_mannayo_comments'), $('.comments_length_text'));

              var setSharedClipboard = function(){
                new ClipboardJS('.popup_share_button');
                $('.popup_share_button').click(function(){
                  toastr.options = {
                              positionClass: 'toast-bottom-center',
                              onclick: null
                          };
                  toastr.options.showMethod = 'slideDown';

                  toastr.success("주소가 복사 되었습니다.");
                });
              };

              setSharedClipboard();

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

              var setTabTitleInPopup = function(type_tab){
                //console.error($('.blueprint_popup').height);
                switch(type_tab){
                  case TYPE_TAB_MEETUP_POPUP_MEET:{
                    $('.meetup_popup_container').show();
                    $('.mannayo_meetup_popup_users_container').hide();
                    $('.mannayo_meetup_popup_comments_container').hide();
                  }
                  break;

                  case TYPE_TAB_MEETUP_POPUP_UESRS:{
                    $('.meetup_popup_container').hide();
                    $('.mannayo_meetup_popup_users_container').show();
                    $('.mannayo_meetup_popup_comments_container').hide();
                  }
                  break;

                  case TYPE_TAB_MEETUP_POPUP_COMMENT:{
                    $('.meetup_popup_container').hide();
                    $('.mannayo_meetup_popup_users_container').hide();
                    $('.mannayo_meetup_popup_comments_container').show();

                    resetScrollContentHeight();
                  }
                  break;
                }
              };

              var setClickTabInPopup = function(){
                $('.mannayo_popup_tab_button').click(function(){
                  var tabTouchIndex = Number($(this).attr('data_tab_index'));

                  $('.mannayo_popup_tab_button').each(function(index, element){
                    //console.error($(element).attr('data_tab_index'));
                    var tabIndex = Number($(this).attr('data_tab_index'));
                    $(element).removeClass("mannayo_popup_tab_button_active");

                    if(tabIndex === tabTouchIndex)
                    {
                      $(element).addClass("mannayo_popup_tab_button_active");
                    }
                  });

                  
                  setTabTitleInPopup(tabTouchIndex);
                });
              };

              var switchSearchingMeetupUsersMark = function(isSearching){
                if(isSearching){
                  $('.mannayo_meetup_popup_users_searching_wrapper').show();
                }
                else{
                  $('.mannayo_meetup_popup_users_searching_wrapper').hide();
                }
              };

              var g_popupNowMannayoCount = 0;
              var g_popupNowMannayoCommentCount = 0;

              var addMeetupUserObject = function(user){
                var element = document.createElement("li");
                element.className = 'li_meetup_object_'+user.index_object;
                element.innerHTML =
                "<div class='result_creator_wrapper result_creator_wrapper_user_object' data_index='"+user.index_object+"'>" +
                
                  "<div class='flex_layer' style='margin-left: 0px;'>" + 
                    "<div class='result_creator_thumbnail_img_wrapper result_creator_thumbnail_img_wrapper_user_object'>"+
                      "<img class='result_creator_thumbnail_img result_creator_thumbnail_img_user_object' src='"+user.profile_photo_url+"'>" +
                    "</div>" +
                    "<div class='result_creator_name result_creator_name_user_object text-ellipsize'>"+user.nick_name+"</div>" +                
                  "</div>" +
                  "<div class='result_user_thumbnail_line'>"+
                  "</div>" +
                "</div>";

                $('.mannayo_meetup_popup_users_ul').append(element);
              };

              

              var addMeetupUserMoreObject = function(user){
                var element = document.createElement("li");
                element.className = 'mannayo_meetup_popup_users_searching_wrapper_ul';
                element.innerHTML =
                  "<div class='mannayo_meetup_popup_users_searching_wrapper'>" +
                    "<p class='searching'><span>.</span><span>.</span><span>.</span><span>.</span></p>" +
                  "</div>";

                $('.mannayo_meetup_popup_users_ul').append(element);
              };

              var initMeetupUsersScroll = function(){
                
              };

              var isRequestUsers = false;
              var isEndUsers = false;
              var requestMeetupUsersInPopup = function(){
                if(!meetup_id)
                {
                  alert('만나요 id값 오류!');
                  return;
                }
                //친구 리스트 불러오기 작업 해야함.
                var url="/mannayo/users/list";
                var method = 'get';
                var data =
                {
                  "meetup_id" : meetup_id,
                  "call_once_max_counter" : CALL_MANNAYO_POPUP_ONCE_USERS_MAX_COUNT,
                  "call_skip_counter" : g_popupNowMannayoCount,
                }
                var success = function(request) {
                  if($(".mannayo_meetup_popup_users_ul_wrapper").length === 0)
                  {
                    console.error("팝업 없음!!");
                    return;
                  }

                  if(Number(request.meetup_id) !== Number(g_nowOpenPopup_meetup_id))
                  {
                    console.error("다른 밋업 id임");
                    return;
                  }

                  var popupNowMannayoCountNumber = Number(g_popupNowMannayoCount);
                  var isInit = false;

                  if(popupNowMannayoCountNumber === 0)
                  {
                    $('.mannayo_meetup_popup_users_searching_wrapper').remove();
                    isInit = true;
                  }
                  else
                  {
                    $('.mannayo_meetup_popup_users_searching_wrapper_ul').remove();
                  }
                  
                  if(request.state === 'success')
                  {
                    for(var i = 0 ; i < request.meetup_users.length ; i++)
                    {
                      var meetup_user = request.meetup_users[i];
                      var objectIndex = ((i+1) + popupNowMannayoCountNumber);

                      meetup_user.user.index_object = objectIndex;

                      addMeetupUserObject(meetup_user.user);

                      //console.error('index : ' + );
                    }

                    popupNowMannayoCountNumber += request.meetup_users.length;

                    g_popupNowMannayoCount = popupNowMannayoCountNumber;
                  }

                  isRequestUsers = false;

                  if(request.meetup_users.length < CALL_MANNAYO_POPUP_ONCE_USERS_MAX_COUNT)
                  {
                    isEndUsers = true;
                  }

                  if(isInit){
                    setScrollUI('.mannayo_meetup_popup_users_ul_wrapper');
                    var popupHeight = $('.blueprint_popup')[0].clientHeight;
                    $('.mannayo_meetup_popup_users_ul_wrapper').css('height', popupHeight - 100);

                    
                    $('.ss-content').bind('scroll', function(){
                      var lastObjectName = '.li_meetup_object_' + g_popupNowMannayoCount;
                      //console.error(lastObjectName);
                      var lastObjectTop = $(lastObjectName).offset().top;
                      var targetObjectTop = $('.mannayo_meetup_popup_scroll_bottom_fake_offset').offset().top;

                      if(isEndUsers){
                        //console.error('isLostUSERS!!');
                        return;
                      }

                      if(lastObjectTop < targetObjectTop)
                      {
                        if(!isRequestUsers)
                        {
                          addMeetupUserMoreObject();
                          requestMeetupUsersInPopup();
                          isRequestUsers = true;
                          //console.error("call Request USERS!!!");
                        }
                      }
                    });
                    
                  }
                };
                
                var error = function(request) {
                  //alert('만나요 유저 정보 리스트 ');
                };
                
                $.ajax({
                'url': url,
                'method': method,
                'data' : data,
                'success': success,
                'error': error
                });
              };

              //팝업 set 하는곳 start

              setClickTabInPopup();
              setTabTitleInPopup(TYPE_TAB_MEETUP_POPUP_MEET);

              addMeetupUserMoreObject();

              requestMeetupUsersInPopup();

              //팝업 set 하는곳 end

              //comment start

              var addMeetupCommentMoreObject = function(){
                var element = document.createElement("li");
                element.className = 'mannayo_meetup_popup_comments_searching_wrapper_ul';
                element.innerHTML =
                  "<div class='mannayo_meetup_popup_users_searching_wrapper'>" +
                    "<p class='searching'><span>.</span><span>.</span><span>.</span><span>.</span></p>" +
                  "</div>";

                $('.mannayo_meetup_popup_comments_ul').append(element);
              }

              var addMannayoCommentsCommentObject = function(reply, parentElement, isAdd){
                var thumbImgElement = '';
                if(reply.user.profile_photo_url){
                  thumbImgElement = "<img class='user-photo-comment' src='"+reply.user.profile_photo_url+"'>";
                }
                else
                {
                  var defultURL = $('#asset_url').val()+'img/app/default-user-image.png';
                  thumbImgElement = "<img class='user-photo-comment' src='"+defultURL+"'>";
                }

                var userName = '';
                if(reply.user.nick_name){
                  userName = reply.user.nick_name;
                }
                else{
                  userName = reply.user.name;
                }

                var replyLiClassName = 'comment_li_delete_id_'+reply.id;
                var deleteElement = '';
                if(isMyOrMasterComment(reply.user.id)){
                  deleteElement = "<span class='delete-comment-wrapper-"+reply.id+"'>" +
                                  "<span class='delete-comment delete-comment-fake delete-comment-fake-"+reply.id+"' data-comment-id='"+reply.id+"'>삭제하기</span>" +
                                  "<span class='delete-comment delete-comment-real delete-comment-"+reply.id+"' data-comment-id='"+reply.id+"'>삭제</span>" +
                                  "<span class='delete-comment delete-comment-real delete-comment-cancel-"+reply.id+"' data-comment-id='"+reply.id+"'>취소</span>" +
                                  "</span>";
                }

                var element = document.createElement("li");
                element.className = replyLiClassName;
                element.innerHTML =   "<a href='{{ url('/users') }}/"+reply.user.id+"' target='_blank'>" +
                                        "<div class='user-photo-reply bg-base pull-left'>" +
                                          thumbImgElement +
                                        "</div>" +                                     
                                      "</a>" +

                                      "<div class='comment-section-right'>" +
                                        "<a href='{{ url('/users') }}/"+reply.user.id+"' target='_blank'>" +
                                          "<span class='comment-username'>" +
                                            "<strong>" +
                                              userName +
                                            "</strong>" +
                                          "</span>" +
                                        "</a>" +
                                        "<span class='comment-created-at'>"+
                                          reply.created_at+
                                        "</span>" +
                                        deleteElement +
                                        "<p class='comment-content'>"+reply.contents.split("\n").join("<br />")+"</p>" +
                                      "</div>" +
                                      "<div class='clear'></div>";

                if(isAdd){
                  $('.'+parentElement).append(element);
                }
                else{
                  $('.'+parentElement).append(element);
                }

                var deleteComment = function(commentId) {
                  if(!commentId)
                  {
                    alert("코멘트 삭제 에러");
                    return;
                  }

                  loadingProcessWithSize($('.delete-comment-wrapper-'+commentId));

                  var url = '/comments/delete';
                  var method = 'delete';
                  var data =
                  {
                    'comment_id' : commentId,
                    'meetup_id' : meetup_id
                  };

                  var success = function(result) {
                    $('.comment_li_delete_id_'+result.comment_id).remove();
                    setCommentCounterText(result.comments_count);
                    alert('댓글 삭제 성공!');
                  };
                  var error = function(request) {
                    alert('댓글 삭제에 실패하였습니다.');
                    //loadingProcessStopWithSize()
                  };

                  $.ajax({
                    'url': url,
                    'method': method,
                    'data' : data,
                    'success': success,
                    'error': error
                  });
                };


                $(".delete-comment-fake-"+reply.id).click(function(){

                  $(".delete-comment-fake-"+reply.id).hide();
                  $(".delete-comment-"+reply.id).show();
                  $(".delete-comment-cancel-"+reply.id).show();
                });

                $(".delete-comment-"+reply.id).click(function(){
                  deleteComment(reply.id);
                });

                $(".delete-comment-cancel-"+reply.id).click(function(){
                  $(".delete-comment-fake-"+reply.id).show();
                  $(".delete-comment-"+reply.id).hide();
                  $(".delete-comment-cancel-"+reply.id).hide();
                });
              }

              var addMannayoCommentObject = function(comment, isAdd){
                var user = comment.user;

                var deleteElement = '';
                if(isMyOrMasterComment(user.id)){
                  //deleteElement = "<span class='delete-comment' data-comment-id='"+comment.id+"'>삭제하기</span>";
                  deleteElement = "<span class='delete-comment-wrapper-"+comment.id+"'>" +
                                  "<span class='delete-comment delete-comment-fake delete-comment-fake-"+comment.id+"' data-comment-id='"+comment.id+"'>삭제하기</span>" +
                                  "<span class='delete-comment delete-comment-real delete-comment-"+comment.id+"' data-comment-id='"+comment.id+"'>삭제</span>" +
                                  "<span class='delete-comment delete-comment-real delete-comment-cancel-"+comment.id+"' data-comment-id='"+comment.id+"'>취소</span>" +
                                  "</span>";
                }

                var contentElement = comment.contents.split("\n").join("<br />");

                var userName = '';
                if(user.nick_name){
                  userName = user.nick_name;
                }
                else{
                  userName = user.name;
                }

                var commentscommentElement = '';
                var commentsCommentFormId = 'mannayo_comments_comment_form_'+comment.id;
                if(isLogin()){
                  commentscommentElement = "<form id='"+commentsCommentFormId+"' action='{{ url('/mannayocommentscomment') }}/"+comment.id+"/comments' method='post' data-toggle='validator' role='form' class='form-horizontal'>" +
                                            "<div class='form-group'>" +
                                              "<div class='col-md-2'>" +
                                              "</div>" +
                                              "<div class='col-md-7 reply-textarea'>" +
                                                "<textarea id='comments_comment_textarea_id_"+comment.id+"' maxlength='255' name='contents' class='form-control' rows='3' placeholder='답글을 입력하세요'></textarea>" +
                                                "<p class='comments_comment_length_text comments_comment_length_text_id_"+comment.id+"'>0/255</p>" +
                                              "</div>" +
                                              "<div class='col-md-2 reply-button'>" +
                                                "<button id='button-comments-comment-"+comment.id+"' type='button' class='btn btn-success pull-right button-comments-comment' data-comment-form-id='"+commentsCommentFormId+"'>답글달기</button>" +
                                              "</div>" +
                                            "</div>" +
                                            "<input type='hidden' name='meetup_id' value='"+meetup_id+"'>" +
                                            "<input type='hidden' name='commentscomment_parent' value='mannayo_popup_comments_comment_ul_"+comment.id+"'>" +
                                            "<input type='hidden' name='commentscomment_button_id' value='button-comments-comment-"+comment.id+"'>" +
                                            "<input type='hidden' name='_token' value='{{ csrf_token() }}'/>" + 
                                          "</form>";
                }

                var profile_photo_url = '';
                if(user.profile_photo_url)
                {
                  profile_photo_url = user.profile_photo_url;
                }
                else
                {
                  profile_photo_url = $('#asset_url').val()+'img/app/default-user-image.png';
                }

                var commentLiClassName = 'comment_li_delete_id_'+comment.id;

                var element = document.createElement("li");
                element.className = 'comment-list li_meetup_comment_object_'+user.index_object + " "+commentLiClassName;
                element.innerHTML = 
                "<div class='user-photo-comment bg-base pull-left'>" +
                  "<img class='user-photo-comment' src='"+profile_photo_url+"'>" +
                "</div>" +

                "<div class='comment-section-right'>" +
                  "<a href='{{ url('/users') }}' target='_blank'>" +
                    "<span class='comment-username'>" +
                      "<strong>" +
                        userName +
                      "</strong>" +
                    "</span>" +
                  "</a>" +
                  "<span class='comment-created-at'>" +
                    comment.created_at +
                  "</span>" + 
                  "<span id='toggle-reply-"+comment.id+"' class='toggle-reply'>답글달기</span>" +
                    deleteElement +
                    "<p class='comment-content'>" + 
                      contentElement +
                    "</p>" +
                  "</div>" +
                "<div class='clear'>" +
                "</div>" + 

                "<div class='reply-wrapper'>" +
                  commentscommentElement +
                  "<ul class='mannayo_popup_comments_comment_ul_"+comment.id+"'>" +
                    //commentsComment +
                  "</ul>" +
                "</div>";
                
                if(isAdd){
                  $('.mannayo_meetup_popup_comments_ul').prepend(element);
                }
                else{
                  $('.mannayo_meetup_popup_comments_ul').append(element);
                }

                $('.li_meetup_comment_object_'+user.index_object).attr('data-comment-id', comment.id);

                isWordLengthCheck($('#comments_comment_textarea_id_'+comment.id), $('.comments_comment_length_text_id_'+comment.id));

                var replyElementId = "#toggle-reply-"+comment.id+"";
                $(replyElementId).click(function(){
                  if(isLogin() == false)
                  {
                    alert("로그인을 해야 댓글을 달 수 있습니다.");
                    return;
                  }

                  console.error("toggle reply");

                  var list = $(this).closest('.comment-list');
                  list.find("form").toggle();
                });

                var setCommentsComment = function(){
                  var commentCommentParent = 'mannayo_popup_comments_comment_ul_'+comment.id;
                  if (comment.comments && comment.comments.length > 0) {
                    for (var i = comment.comments.length - 1, l = 0; i >= l; i--) {
                      var reply = comment.comments[i];
                      addMannayoCommentsCommentObject(reply, commentCommentParent, false);
                    }
                  }
                };

                var mannayoCommentsCommentAjaxOption = {
                  'beforeSerialize': function($form, options) {
                    //console.error('comment beforeSerialize');

                  },
                  'success': function(request) {
                    //console.error('만나요 코맨트의 코멘트 성공!!' + request.commentscomment_parent);

                    var parentUlClass = request.commentscomment_parent;
                    var buttonID = "#"+request.commentscomment_button_id;
                    //addMannayoCommentObject(request.meetup_comment, true);
                    addMannayoCommentsCommentObject(request.meetup_comment, parentUlClass, true);
                    setCommentCounterText(request.comments_count);
                    loadingProcessStopWithSize($(buttonID));

                    alert('댓글이 성공적으로 달렸습니다.');


                  },
                  'error': function(data) {
                    console.error('만나요 코맨트 실패!');
                  }
                };

                $("#"+commentsCommentFormId).ajaxForm(mannayoCommentsCommentAjaxOption);

                $("#button-comments-comment-"+comment.id).click(function(){
                  var commentsFormId = $(this).attr('data-comment-form-id');

                  loadingProcessWithSize($(this));
                  $('#'+commentsFormId).submit();
                  console.error();
                });

                var deleteComment = function(commentId) {
                  if(!commentId)
                  {
                    alert("코멘트 삭제 에러");
                    return;
                  }

                  loadingProcessWithSize($('.delete-comment-wrapper-'+commentId));

                  var url = '/comments/delete';
                  var method = 'delete';
                  var data =
                  {
                    'comment_id' : commentId,
                    'meetup_id' : meetup_id
                  };

                  var success = function(result) {
                    $('.comment_li_delete_id_'+result.comment_id).remove();
                    setCommentCounterText(result.comments_count);
                    alert('댓글 삭제 성공!');
                  };
                  var error = function(request) {
                    alert('댓글 삭제에 실패하였습니다.');
                    //loadingProcessStopWithSize()
                  };

                  $.ajax({
                    'url': url,
                    'method': method,
                    'data' : data,
                    'success': success,
                    'error': error
                  });
                };

                $(".delete-comment-fake-"+comment.id).click(function(){

                  $(".delete-comment-fake-"+comment.id).hide();
                  $(".delete-comment-"+comment.id).show();
                  $(".delete-comment-cancel-"+comment.id).show();
                });

                $(".delete-comment-"+comment.id).click(function(){
                  deleteComment(comment.id);
                });

                $(".delete-comment-cancel-"+comment.id).click(function(){
                  $(".delete-comment-fake-"+comment.id).show();
                  $(".delete-comment-"+comment.id).hide();
                  $(".delete-comment-cancel-"+comment.id).hide();
                });

                setCommentsComment();
              };

              var mannayoCommentsAjaxOption = {
                'beforeSerialize': function($form, options) {
                  console.error('comment beforeSerialize');

                },
                'success': function(request) {
                  //console.error('만나요 코맨트 성공!!' + request);

                  addMannayoCommentObject(request.meetup_comment, true);
                  setCommentCounterText(request.comments_count);
                  loadingProcessStop($('.mannayo_comments_button'));

                  alert('댓글이 성공적으로 달렸습니다.');
                },
                'error': function(data) {
                  console.error('만나요 코맨트 실패!');
                }
              };

              var lastCommentId = 0;
              var isCommentRequestUsers = false;
              var isCommentEndUsers = false;

              var requestMannayoUserList = function(){
                if(!meetup_id)
                {
                  alert('만나요 id값 오류!');
                  return;
                }

                var url="/mannayo/comments/list";
                var method = 'get';
                var data =
                {
                  "meetup_id" : meetup_id,
                  'last_comment_id': lastCommentId,
                  "call_once_max_counter" : CALL_MANNAYO_POPUP_ONCE_USERS_COMMENT_MAX_COUNT,
                  "call_skip_counter" : 0,
                }
                var success = function(request) {
                  if($(".mannayo_meetup_popup_comments_ul_wrapper").length === 0)
                  {
                    console.error("팝업 없음!!");
                    return;
                  }

                  if(Number(request.meetup_id) !== Number(g_nowOpenPopup_meetup_id))
                  {
                    console.error("다른 밋업 id임");
                    return;
                  }

                  var popupNowMannayoCommentCountNumber = Number(g_popupNowMannayoCommentCount);

                  var isInit = false;
                  if(lastCommentId === 0)
                  {
                  // $('.mannayo_meetup_popup_comments_searching_wrapper').remove();
                    isInit = true;
                  }
                  //else
                  //{
                  //}

                  if(request.state === 'success'){
                    for(var i = 0 ; i < request.meetup_comments.length ; i++)
                    {
                      var meetup_comment = request.meetup_comments[i];
                      var objectIndex = ((i+1) + popupNowMannayoCommentCountNumber);

                      meetup_comment.user.index_object = objectIndex;

                      addMannayoCommentObject(meetup_comment, false);

                      //console.error('index : ' + );
                    }

                    popupNowMannayoCommentCountNumber += request.meetup_comments.length;

                    g_popupNowMannayoCommentCount = popupNowMannayoCommentCountNumber;
                  }

                  isRequestUsers = false;

                  if(request.meetup_comments.length < CALL_MANNAYO_POPUP_ONCE_USERS_COMMENT_MAX_COUNT)
                  {
                    isCommentEndUsers = true;
                  }

                  if(isInit){
                    setCommentCounterText(request.comments_count);

                    setScrollUI('.mannayo_meetup_popup_comments_ul_wrapper');

                    $('.ss-content').bind('scroll', function(){
                      var lastObjectName = '.li_meetup_comment_object_' + g_popupNowMannayoCommentCount;
                      
                      var lastObjectTop = $(lastObjectName).offset().top;
                      var targetObjectTop = $('.mannayo_meetup_popup_scroll_bottom_comments_fake_offset').offset().top;

                      if(isCommentEndUsers){
                        console.error('isLastUSERS!!');
                        return;
                      }

                      if(lastObjectTop < targetObjectTop)
                      {
                        if(!isRequestUsers)
                        {
                          lastCommentId = Number($(lastObjectName).attr('data-comment-id'));
                          addMeetupCommentMoreObject();
                          requestMannayoUserList();
                          isRequestUsers = true;
                          console.error("call Request USERS!!!");
                        }
                      }
                    });
                  }


                  $('.mannayo_meetup_popup_comments_searching_wrapper_ul').remove();
                };
                
                var error = function(request) {
                  alert('댓글 정보 가져오기 실패!');
                };
                
                $.ajax({
                'url': url,
                'method': method,
                'data' : data,
                'success': success,
                'error': error
                });
              };

              $('#mannayo_comments_form').ajaxForm(mannayoCommentsAjaxOption);

              addMeetupCommentMoreObject();
              requestMannayoUserList();

              $('.mannayo_comments_button').click(function(){
                if(isLogin() == false)
                {
                  alert("로그인을 해야 댓글을 달 수 있습니다.");
                  return;
                }

                if(!$('#input_mannayo_comments').val())
                {
                  alert("댓글을 입력해주세요!");
                  return;
                }

                loadingProcess($('.mannayo_comments_button'));

                $('#mannayo_comments_form').submit();
              });

              //addMannayoCommentObject();
              //comment end

              resetPopupContentHeight();
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
                openMeetPopup(element.attr("data_meetup_channel_id"), element.attr("data_meetup_id"), element.attr("data_meetup_title"), element.attr("data_meetup_where"), element.attr("data_meetup_what"), element.attr("data_meetup_img_url"), element.attr("data_meetup_count"), element.attr("data_comments_count"));
              });
            };

            var requestCancelMeetUp = function(meetup_id){
              loadingProcess($("#meetup_cancel_button"));
              $(".mannayo_popup_close_button_wrapper").hide();
              resetPopupContentHeight();

              var url="/mannayo/meetup/cancel";
              var method = 'post';
              var data =
              {
                "meetup_id" : meetup_id
              }
              var success = function(request) {
                loadingProcessStop($("#meetup_cancel_button"));
                $(".mannayo_popup_close_button_wrapper").show();

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

                  $('.mannayo_alert_popup').css('height', 'auto');

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
                $(".mannayo_popup_close_button_wrapper").show();
                resetPopupContentHeight();
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
            var openCancelPopup = function(meetup_channel_id, meetup_id, meetup_title, meetup_where, meetup_what, meetup_img_url, meetup_count, comments_count){        
              g_nowOpenPopup_meetup_id = meetup_id;
              g_nowOpenPopup_meetup_channel = meetup_channel_id;

              var youtubeLink = 'https://www.youtube.com/channel/'+g_nowOpenPopup_meetup_channel;
              var sharedLink = $('#base_url').val() + '/mannayo/share/meetup/'+meetup_id;

              var makeTabTitleInPopup = function(meetup_count){
                return "<div class='flex_layer'>" +
                  "<div data_tab_index='0' class='mannayo_popup_tab_button mannayo_popup_tab_button_active' type='button'>만나요</div>" +
                  "<div data_tab_index='1' class='mannayo_popup_tab_button' type='button'>" +
                    "<div class='flex_layer'>" +
                      "참여한 유저<p class='mannayo_popup_tab_counter_text'>"+meetup_count+"</p>" +
                    "</div>" +
                  "</div>" +
                  "<div data_tab_index='2' class='mannayo_popup_tab_button' type='button'>" +
                    "<div class='flex_layer'>" +
                        "댓글<p class='mannayo_popup_tab_counter_text mannayo_popup_tab_comment_counter_text'>"+"</p>" +
                    "</div>" +
                  "</div>" +

                  "<div class='mannayo_popup_tab_title_right_wrapper'>" +
                    "<div class='flex_layer'>" +
                      "<div class='mannayo_popup_close_button_wrapper' style='margin-right: 12px;'>" +
                        "<button type='button' class='popup_share_button popup_close_button_meetup_popup' data-clipboard-text='"+sharedLink+"'>" + 
                          "<img src='{{ asset('/img/icons/svg/ic-share.svg') }}'>" +
                        "</button>" +
                      "</div>" +
                      "<div class='mannayo_popup_close_button_wrapper'>" +
                        "<button type='button' class='popup_close_button popup_close_button_meetup_popup'>" + 
                          "<img src='{{ asset('/img/icons/svg/ic-exit.svg') }}'>" +
                        "</button>" +
                      "</div>" +
                    "</div>" +
                  "</div>" +
                  
                "</div>";
              };

              var makeMeetupContent = function(meetup_img_url, meetup_title, meetup_where, meetup_what, meetup_count, meetup_id){
                return "<div class='meetup_popup_container'>" + 
                        "<div class='meetup_popup_thumb_container meetup_popup_thumb_container_cancel'>" + 
                          "<a href='"+youtubeLink+"' target='_blank'><img src='"+meetup_img_url+"' style='width: 80px; height: 80px; border-radius: 100%;'></a>" +
                        "</div>" +

                        "<div class='meetup_popup_content_container meetup_popup_content_container_cancel'>" + 
                          "<p><span class='meetup_popup_content_point_color'><u><a href='"+youtubeLink+"' target='_blank'>"+meetup_title+"</a></u></span> 과/와 <span class='meetup_popup_content_point_color'>"+meetup_where+"</span> 에서 <br>" + 
                          "<span class='meetup_popup_content_point_color' style='word-break: break-all'>" + meetup_what +"</span>" + " 를 하고 싶어요!" +
                          "</p>" +
                        "</div>" +

                        "<div class='meetup_popup_meet_count_container meetup_popup_meet_count_container_cancel'>" +
                          "<div class='meetup_count_loading_container'>" +
                            "<p>🔥 "+meetup_count+" 명이 만나고 싶어해요</p>" +
                          "</div>" +
                          "<p>함께 할수록 이벤트가 성사될 가능성이 높아요!</p>" +
                        "</div>" +

                        "<div class='meetup_new_button_wrapper meetup_new_button_wrapper_cancel'>" +
                          "<button id='meetup_cancel_button' class='meetup_cancel_button' data_meetup_id='"+meetup_id+"'>" +
                            "만나요 요청 취소" +
                          "</button>" +
                        "</div>" +
                        "<p class='meetup_popup_bottom_label'>이벤트가 성사되면 가장먼저 초대해 드리겠습니다</p>" +
                      "</div>";
              };

              var makeMeetupUsers = function(){
                return  "<div class='mannayo_meetup_popup_users_container'>" + 
                          "<div class='mannayo_meetup_popup_users_ul_wrapper'>" +
                            "<ul class='mannayo_meetup_popup_users_ul'>" +
                            "</ul>" +
                          "</div>" +
                          "<div class='mannayo_meetup_popup_scroll_bottom_fake_offset'>" +
                          "</div>" +
                        "</div>";
              };

              var makeMeetupComments = function(){
                return  "<div class='mannayo_meetup_popup_comments_container'>" + 

                          "<form id='mannayo_comments_form' action='{{ url('/mannayo') }}/"+meetup_id+"/comments' method='post' data-toggle='validator' role='form' class='ps-detail-comment-wrapper'>" +
                              "<textarea id='input_mannayo_comments' maxlength='255' name='contents' class='form-control' rows='3' placeholder='만나요 댓글을 자유롭게 남겨주세요!'></textarea>" +
                              "<p class='comments_length_text'>0/255</p>" +
                              "<button type='button' class='btn btn-success pull-right mannayo_comments_button'>댓글달기</button>" +
                              "<div class='clear'></div>" +
                              "<input type='hidden' name='_token' value='{{ csrf_token() }}'/>" + 
                          "</form>" +


                          "<div class='mannayo_meetup_popup_comments_ul_wrapper'>" +
                            "<ul class='mannayo_meetup_popup_comments_ul'>" +
                            "</ul>" +
                          "</div>" +
                          "<div class='mannayo_meetup_popup_scroll_bottom_comments_fake_offset'>" +
                          "</div>" +
                        "</div>";
              };
              
              //var nickName = $('#user_nickname').val();

              var elementPopup = document.createElement("div");
              elementPopup.className = 'meetup_popup_container_wrapper';
              elementPopup.innerHTML = 
              makeTabTitleInPopup(meetup_count) + 
              makeMeetupContent(meetup_img_url, meetup_title, meetup_where, meetup_what, meetup_count, meetup_id) + 
              makeMeetupUsers() + 
              makeMeetupComments();

              stopDocumentScroll();
              swal({
                      content: elementPopup,
                      allowOutsideClick: "true",
                      className: "blueprint_popup",
                      closeOnClickOutside: false,
                      closeOnEsc: false
                  }).then(function(){
                    reStartDocumentScroll();
                  });

              $(".swal-footer").hide();

              $('.popup_close_button').click(function(){
                  swal.close();
              });

              isWordLengthCheck($('#input_mannayo_comments'), $('.comments_length_text'));

              var setSharedClipboard = function(){
                new ClipboardJS('.popup_share_button');
                $('.popup_share_button').click(function(){
                  toastr.options = {
                              positionClass: 'toast-bottom-center',
                              onclick: null
                          };
                  toastr.options.showMethod = 'slideDown';

                  toastr.success("주소가 복사 되었습니다.");
                });
              };

              setSharedClipboard();

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

              /////////////////////tab cancel start////
              var setTabTitleInPopup = function(type_tab){
                //console.error($('.blueprint_popup').height);
                switch(type_tab){
                  case TYPE_TAB_MEETUP_POPUP_MEET:{
                    $('.meetup_popup_container').show();
                    $('.mannayo_meetup_popup_users_container').hide();
                    $('.mannayo_meetup_popup_comments_container').hide();
                  }
                  break;

                  case TYPE_TAB_MEETUP_POPUP_UESRS:{
                    $('.meetup_popup_container').hide();
                    $('.mannayo_meetup_popup_users_container').show();
                    $('.mannayo_meetup_popup_comments_container').hide();
                  }
                  break;

                  case TYPE_TAB_MEETUP_POPUP_COMMENT:{
                    $('.meetup_popup_container').hide();
                    $('.mannayo_meetup_popup_users_container').hide();
                    $('.mannayo_meetup_popup_comments_container').show();

                    resetScrollContentHeight();
                  }
                  break;
                }
              };

              var setClickTabInPopup = function(){
                $('.mannayo_popup_tab_button').click(function(){
                  var tabTouchIndex = Number($(this).attr('data_tab_index'));

                  $('.mannayo_popup_tab_button').each(function(index, element){
                    //console.error($(element).attr('data_tab_index'));
                    var tabIndex = Number($(this).attr('data_tab_index'));
                    $(element).removeClass("mannayo_popup_tab_button_active");

                    if(tabIndex === tabTouchIndex)
                    {
                      $(element).addClass("mannayo_popup_tab_button_active");
                    }
                  });

                  
                  setTabTitleInPopup(tabTouchIndex);
                });
              };

              var switchSearchingMeetupUsersMark = function(isSearching){
                if(isSearching){
                  $('.mannayo_meetup_popup_users_searching_wrapper').show();
                }
                else{
                  $('.mannayo_meetup_popup_users_searching_wrapper').hide();
                }
              };

              var g_popupNowMannayoCount = 0;
              var g_popupNowMannayoCommentCount = 0;

              var addMeetupUserObject = function(user){
                var profile_photo_url = '';
                if(user.profile_photo_url){
                  profile_photo_url = user.profile_photo_url;
                }
                else{
                  profile_photo_url = $('#asset_url').val()+'img/app/default-user-image.png';
                }


                var element = document.createElement("li");
                element.className = 'li_meetup_object_'+user.index_object;
                element.innerHTML =
                "<div class='result_creator_wrapper result_creator_wrapper_user_object' data_index='"+user.index_object+"'>" +
                
                  "<div class='flex_layer' style='margin-left: 0px;'>" + 
                    "<div class='result_creator_thumbnail_img_wrapper result_creator_thumbnail_img_wrapper_user_object'>"+
                      "<img class='result_creator_thumbnail_img result_creator_thumbnail_img_user_object' src='"+profile_photo_url+"'>" +
                    "</div>" +
                    "<div class='result_creator_name result_creator_name_user_object text-ellipsize'>"+user.nick_name+"</div>" +                
                  "</div>" +
                  "<div class='result_user_thumbnail_line'>"+
                  "</div>" +
                "</div>";

                $('.mannayo_meetup_popup_users_ul').append(element);
              };

              

              var addMeetupUserMoreObject = function(user){
                var element = document.createElement("li");
                element.className = 'mannayo_meetup_popup_users_searching_wrapper_ul';
                element.innerHTML =
                  "<div class='mannayo_meetup_popup_users_searching_wrapper'>" +
                    "<p class='searching'><span>.</span><span>.</span><span>.</span><span>.</span></p>" +
                  "</div>";

                $('.mannayo_meetup_popup_users_ul').append(element);
              };

              var initMeetupUsersScroll = function(){
                
              };

              var isRequestUsers = false;
              var isEndUsers = false;
              var requestMeetupUsersInPopup = function(){
                if(!meetup_id)
                {
                  alert('만나요 id값 오류!');
                  return;
                }
                //친구 리스트 불러오기 작업 해야함.
                var url="/mannayo/users/list";
                var method = 'get';
                var data =
                {
                  "meetup_id" : meetup_id,
                  "call_once_max_counter" : CALL_MANNAYO_POPUP_ONCE_USERS_MAX_COUNT,
                  "call_skip_counter" : g_popupNowMannayoCount,
                }
                var success = function(request) {
                  if($(".mannayo_meetup_popup_users_ul_wrapper").length === 0)
                  {
                    console.error("팝업 없음!!");
                    return;
                  }

                  if(Number(request.meetup_id) !== Number(g_nowOpenPopup_meetup_id))
                  {
                    console.error("다른 밋업 id임");
                    return;
                  }

                  var popupNowMannayoCountNumber = Number(g_popupNowMannayoCount);
                  var isInit = false;

                  if(popupNowMannayoCountNumber === 0)
                  {
                    $('.mannayo_meetup_popup_users_searching_wrapper').remove();
                    isInit = true;
                  }
                  else
                  {
                    $('.mannayo_meetup_popup_users_searching_wrapper_ul').remove();
                  }
                  
                  if(request.state === 'success')
                  {
                    for(var i = 0 ; i < request.meetup_users.length ; i++)
                    {
                      var meetup_user = request.meetup_users[i];
                      var objectIndex = ((i+1) + popupNowMannayoCountNumber);

                      meetup_user.user.index_object = objectIndex;

                      addMeetupUserObject(meetup_user.user);

                      //console.error('index : ' + );
                    }

                    popupNowMannayoCountNumber += request.meetup_users.length;

                    g_popupNowMannayoCount = popupNowMannayoCountNumber;
                  }

                  isRequestUsers = false;

                  if(request.meetup_users.length < CALL_MANNAYO_POPUP_ONCE_USERS_MAX_COUNT)
                  {
                    isEndUsers = true;
                  }

                  if(isInit){
                    setScrollUI('.mannayo_meetup_popup_users_ul_wrapper');
                    var popupHeight = $('.blueprint_popup')[0].clientHeight;
                    $('.mannayo_meetup_popup_users_ul_wrapper').css('height', popupHeight - 100);

                    
                    $('.ss-content').bind('scroll', function(){
                      console.error("asdf");
                      var lastObjectName = '.li_meetup_object_' + g_popupNowMannayoCount;
                      //console.error(lastObjectName);
                      var lastObjectTop = $(lastObjectName).offset().top;
                      var targetObjectTop = $('.mannayo_meetup_popup_scroll_bottom_fake_offset').offset().top;

                      if(isEndUsers){
                        //console.error('isLostUSERS!!');
                        return;
                      }

                      if(lastObjectTop < targetObjectTop)
                      {
                        if(!isRequestUsers)
                        {
                          addMeetupUserMoreObject();
                          requestMeetupUsersInPopup();
                          isRequestUsers = true;
                          //console.error("call Request USERS!!!");
                        }
                      }
                    });
                    
                  }
                };
                
                var error = function(request) {
                  //alert('만나요 유저 정보 리스트 ');
                };
                
                $.ajax({
                'url': url,
                'method': method,
                'data' : data,
                'success': success,
                'error': error
                });
              };

              //팝업 set 하는곳 start

              setClickTabInPopup();
              setTabTitleInPopup(TYPE_TAB_MEETUP_POPUP_MEET);

              addMeetupUserMoreObject();

              requestMeetupUsersInPopup();

              //팝업 set 하는곳 end

              //comment start

              var addMeetupCommentMoreObject = function(){
                var element = document.createElement("li");
                element.className = 'mannayo_meetup_popup_comments_searching_wrapper_ul';
                element.innerHTML =
                  "<div class='mannayo_meetup_popup_users_searching_wrapper'>" +
                    "<p class='searching'><span>.</span><span>.</span><span>.</span><span>.</span></p>" +
                  "</div>";

                $('.mannayo_meetup_popup_comments_ul').append(element);
              }

              var addMannayoCommentsCommentObject = function(reply, parentElement, isAdd){
                var thumbImgElement = '';
                if(reply.user.profile_photo_url){
                  thumbImgElement = "<img class='user-photo-comment' src='"+reply.user.profile_photo_url+"'>";
                }
                else
                {
                  var defultURL = $('#asset_url').val()+'img/app/default-user-image.png';
                  thumbImgElement = "<img class='user-photo-comment' src='"+defultURL+"'>";
                }

                var userName = '';
                if(reply.user.nick_name){
                  userName = reply.user.nick_name;
                }
                else{
                  userName = reply.user.name;
                }

                var replyLiClassName = 'comment_li_delete_id_'+reply.id;
                var deleteElement = '';
                if(isMyOrMasterComment(reply.user.id)){
                  deleteElement = "<span class='delete-comment-wrapper-"+reply.id+"'>" +
                                  "<span class='delete-comment delete-comment-fake delete-comment-fake-"+reply.id+"' data-comment-id='"+reply.id+"'>삭제하기</span>" +
                                  "<span class='delete-comment delete-comment-real delete-comment-"+reply.id+"' data-comment-id='"+reply.id+"'>삭제</span>" +
                                  "<span class='delete-comment delete-comment-real delete-comment-cancel-"+reply.id+"' data-comment-id='"+reply.id+"'>취소</span>" +
                                  "</span>";
                }

                var element = document.createElement("li");
                element.className = replyLiClassName;
                element.innerHTML =   "<a href='{{ url('/users') }}/"+reply.user.id+"' target='_blank'>" +
                                        "<div class='user-photo-reply bg-base pull-left'>" +
                                          thumbImgElement +
                                        "</div>" +                                     
                                      "</a>" +

                                      "<div class='comment-section-right'>" +
                                        "<a href='{{ url('/users') }}/"+reply.user.id+"' target='_blank'>" +
                                          "<span class='comment-username'>" +
                                            "<strong>" +
                                              userName +
                                            "</strong>" +
                                          "</span>" +
                                        "</a>" +
                                        "<span class='comment-created-at'>"+
                                          reply.created_at+
                                        "</span>" +
                                        deleteElement +
                                        "<p class='comment-content'>"+reply.contents.split("\n").join("<br />")+"</p>" +
                                      "</div>" +
                                      "<div class='clear'></div>";

                if(isAdd){
                  $('.'+parentElement).append(element);
                }
                else{
                  $('.'+parentElement).append(element);
                }

                var deleteComment = function(commentId) {
                  if(!commentId)
                  {
                    alert("코멘트 삭제 에러");
                    return;
                  }

                  loadingProcessWithSize($('.delete-comment-wrapper-'+commentId));

                  var url = '/comments/delete';
                  var method = 'delete';
                  var data =
                  {
                    'comment_id' : commentId,
                    'meetup_id' : meetup_id
                  };

                  var success = function(result) {
                    $('.comment_li_delete_id_'+result.comment_id).remove();
                    setCommentCounterText(result.comments_count);
                    alert('댓글 삭제 성공!');
                  };
                  var error = function(request) {
                    alert('댓글 삭제에 실패하였습니다.');
                    //loadingProcessStopWithSize()
                  };

                  $.ajax({
                    'url': url,
                    'method': method,
                    'data' : data,
                    'success': success,
                    'error': error
                  });
                };


                $(".delete-comment-fake-"+reply.id).click(function(){

                  $(".delete-comment-fake-"+reply.id).hide();
                  $(".delete-comment-"+reply.id).show();
                  $(".delete-comment-cancel-"+reply.id).show();
                });

                $(".delete-comment-"+reply.id).click(function(){
                  deleteComment(reply.id);
                });

                $(".delete-comment-cancel-"+reply.id).click(function(){
                  $(".delete-comment-fake-"+reply.id).show();
                  $(".delete-comment-"+reply.id).hide();
                  $(".delete-comment-cancel-"+reply.id).hide();
                });
              }

              var addMannayoCommentObject = function(comment, isAdd){
                var user = comment.user;

                var deleteElement = '';
                if(isMyOrMasterComment(user.id)){
                  //deleteElement = "<span class='delete-comment' data-comment-id='"+comment.id+"'>삭제하기</span>";
                  deleteElement = "<span class='delete-comment-wrapper-"+comment.id+"'>" +
                                  "<span class='delete-comment delete-comment-fake delete-comment-fake-"+comment.id+"' data-comment-id='"+comment.id+"'>삭제하기</span>" +
                                  "<span class='delete-comment delete-comment-real delete-comment-"+comment.id+"' data-comment-id='"+comment.id+"'>삭제</span>" +
                                  "<span class='delete-comment delete-comment-real delete-comment-cancel-"+comment.id+"' data-comment-id='"+comment.id+"'>취소</span>" +
                                  "</span>";
                }

                var contentElement = comment.contents.split("\n").join("<br />");

                var userName = '';
                if(user.nick_name){
                  userName = user.nick_name;
                }
                else{
                  userName = user.name;
                }

                var commentscommentElement = '';
                var commentsCommentFormId = 'mannayo_comments_comment_form_'+comment.id;
                if(isLogin()){
                  commentscommentElement = "<form id='"+commentsCommentFormId+"' action='{{ url('/mannayocommentscomment') }}/"+comment.id+"/comments' method='post' data-toggle='validator' role='form' class='form-horizontal'>" +
                                            "<div class='form-group'>" +
                                              "<div class='col-md-2'>" +
                                              "</div>" +
                                              "<div class='col-md-7 reply-textarea'>" +
                                                "<textarea id='comments_comment_textarea_id_"+comment.id+"' maxlength='255' name='contents' class='form-control' rows='3' placeholder='답글을 입력하세요'></textarea>" +
                                                "<p class='comments_comment_length_text comments_comment_length_text_id_"+comment.id+"'>0/255</p>" +
                                              "</div>" +
                                              "<div class='col-md-2 reply-button'>" +
                                                "<button id='button-comments-comment-"+comment.id+"' type='button' class='btn btn-success pull-right button-comments-comment' data-comment-form-id='"+commentsCommentFormId+"'>답글달기</button>" +
                                              "</div>" +
                                            "</div>" +
                                            "<input type='hidden' name='meetup_id' value='"+meetup_id+"'>" +
                                            "<input type='hidden' name='commentscomment_parent' value='mannayo_popup_comments_comment_ul_"+comment.id+"'>" +
                                            "<input type='hidden' name='commentscomment_button_id' value='button-comments-comment-"+comment.id+"'>" +
                                            "<input type='hidden' name='_token' value='{{ csrf_token() }}'/>" + 
                                          "</form>";
                }

                var profile_photo_url = '';
                if(user.profile_photo_url)
                {
                  profile_photo_url = user.profile_photo_url;
                }
                else
                {
                  profile_photo_url = $('#asset_url').val()+'img/app/default-user-image.png';
                }

                var commentLiClassName = 'comment_li_delete_id_'+comment.id;

                var element = document.createElement("li");
                element.className = 'comment-list li_meetup_comment_object_'+user.index_object + " "+commentLiClassName;
                element.innerHTML = 
                "<div class='user-photo-comment bg-base pull-left'>" +
                  "<img class='user-photo-comment' src='"+profile_photo_url+"'>" +
                "</div>" +

                "<div class='comment-section-right'>" +
                  "<a href='{{ url('/users') }}' target='_blank'>" +
                    "<span class='comment-username'>" +
                      "<strong>" +
                        userName +
                      "</strong>" +
                    "</span>" +
                  "</a>" +
                  "<span class='comment-created-at'>" +
                    comment.created_at +
                  "</span>" + 
                  "<span id='toggle-reply-"+comment.id+"' class='toggle-reply'>답글달기</span>" +
                    deleteElement +
                    "<p class='comment-content'>" + 
                      contentElement +
                    "</p>" +
                  "</div>" +
                "<div class='clear'>" +
                "</div>" + 

                "<div class='reply-wrapper'>" +
                  commentscommentElement +
                  "<ul class='mannayo_popup_comments_comment_ul_"+comment.id+"'>" +
                    //commentsComment +
                  "</ul>" +
                "</div>";
                
                if(isAdd){
                  $('.mannayo_meetup_popup_comments_ul').prepend(element);
                }
                else{
                  $('.mannayo_meetup_popup_comments_ul').append(element);
                }

                $('.li_meetup_comment_object_'+user.index_object).attr('data-comment-id', comment.id);

                isWordLengthCheck($('#comments_comment_textarea_id_'+comment.id), $('.comments_comment_length_text_id_'+comment.id));

                var replyElementId = "#toggle-reply-"+comment.id+"";
                $(replyElementId).click(function(){
                  if(isLogin() == false)
                  {
                    alert("로그인을 해야 댓글을 달 수 있습니다.");
                    return;
                  }

                  console.error("toggle reply");

                  var list = $(this).closest('.comment-list');
                  list.find("form").toggle();
                });

                var setCommentsComment = function(){
                  var commentCommentParent = 'mannayo_popup_comments_comment_ul_'+comment.id;
                  if (comment.comments && comment.comments.length > 0) {
                    for (var i = comment.comments.length - 1, l = 0; i >= l; i--) {
                      var reply = comment.comments[i];
                      addMannayoCommentsCommentObject(reply, commentCommentParent, false);
                    }
                  }
                };

                var mannayoCommentsCommentAjaxOption = {
                  'beforeSerialize': function($form, options) {
                    //console.error('comment beforeSerialize');

                  },
                  'success': function(request) {
                    //console.error('만나요 코맨트의 코멘트 성공!!' + request.commentscomment_parent);

                    var parentUlClass = request.commentscomment_parent;
                    var buttonID = "#"+request.commentscomment_button_id;
                    //addMannayoCommentObject(request.meetup_comment, true);
                    addMannayoCommentsCommentObject(request.meetup_comment, parentUlClass, true);
                    setCommentCounterText(request.comments_count);
                    loadingProcessStopWithSize($(buttonID));

                    alert('댓글이 성공적으로 달렸습니다.');


                  },
                  'error': function(data) {
                    console.error('만나요 코맨트 실패!');
                  }
                };

                $("#"+commentsCommentFormId).ajaxForm(mannayoCommentsCommentAjaxOption);

                $("#button-comments-comment-"+comment.id).click(function(){
                  var commentsFormId = $(this).attr('data-comment-form-id');

                  loadingProcessWithSize($(this));
                  $('#'+commentsFormId).submit();
                  console.error();
                });

                var deleteComment = function(commentId) {
                  if(!commentId)
                  {
                    alert("코멘트 삭제 에러");
                    return;
                  }

                  loadingProcessWithSize($('.delete-comment-wrapper-'+commentId));

                  var url = '/comments/delete';
                  var method = 'delete';
                  var data =
                  {
                    'comment_id' : commentId,
                    'meetup_id' : meetup_id
                  };

                  var success = function(result) {
                    $('.comment_li_delete_id_'+result.comment_id).remove();
                    setCommentCounterText(result.comments_count);
                    alert('댓글 삭제 성공!');
                  };
                  var error = function(request) {
                    alert('댓글 삭제에 실패하였습니다.');
                    //loadingProcessStopWithSize()
                  };

                  $.ajax({
                    'url': url,
                    'method': method,
                    'data' : data,
                    'success': success,
                    'error': error
                  });
                };

                $(".delete-comment-fake-"+comment.id).click(function(){

                  $(".delete-comment-fake-"+comment.id).hide();
                  $(".delete-comment-"+comment.id).show();
                  $(".delete-comment-cancel-"+comment.id).show();
                });

                $(".delete-comment-"+comment.id).click(function(){
                  deleteComment(comment.id);
                });

                $(".delete-comment-cancel-"+comment.id).click(function(){
                  $(".delete-comment-fake-"+comment.id).show();
                  $(".delete-comment-"+comment.id).hide();
                  $(".delete-comment-cancel-"+comment.id).hide();
                });

                setCommentsComment();
              };

              var mannayoCommentsAjaxOption = {
                'beforeSerialize': function($form, options) {
                  console.error('comment beforeSerialize');

                },
                'success': function(request) {
                  //console.error('만나요 코맨트 성공!!' + request);

                  addMannayoCommentObject(request.meetup_comment, true);
                  loadingProcessStop($('.mannayo_comments_button'));

                  alert('댓글이 성공적으로 달렸습니다.');
                },
                'error': function(data) {
                  console.error('만나요 코맨트 실패!');
                }
              };

              var lastCommentId = 0;
              var isCommentRequestUsers = false;
              var isCommentEndUsers = false;

              var requestMannayoUserList = function(){
                if(!meetup_id)
                {
                  alert('만나요 id값 오류!');
                  return;
                }

                var url="/mannayo/comments/list";
                var method = 'get';
                var data =
                {
                  "meetup_id" : meetup_id,
                  'last_comment_id': lastCommentId,
                  "call_once_max_counter" : CALL_MANNAYO_POPUP_ONCE_USERS_COMMENT_MAX_COUNT,
                  "call_skip_counter" : 0,
                }
                var success = function(request) {
                  if($(".mannayo_meetup_popup_comments_ul_wrapper").length === 0)
                  {
                    console.error("팝업 없음!!");
                    return;
                  }

                  if(Number(request.meetup_id) !== Number(g_nowOpenPopup_meetup_id))
                  {
                    console.error("다른 밋업 id임");
                    return;
                  }

                  var popupNowMannayoCommentCountNumber = Number(g_popupNowMannayoCommentCount);

                  var isInit = false;
                  if(lastCommentId === 0)
                  {
                  // $('.mannayo_meetup_popup_comments_searching_wrapper').remove();
                    isInit = true;
                  }

                  if(request.state === 'success'){
                    for(var i = 0 ; i < request.meetup_comments.length ; i++)
                    {
                      var meetup_comment = request.meetup_comments[i];
                      var objectIndex = ((i+1) + popupNowMannayoCommentCountNumber);

                      meetup_comment.user.index_object = objectIndex;

                      addMannayoCommentObject(meetup_comment, false);

                      //console.error('index : ' + );
                    }

                    popupNowMannayoCommentCountNumber += request.meetup_comments.length;

                    g_popupNowMannayoCommentCount = popupNowMannayoCommentCountNumber;
                  }

                  isRequestUsers = false;

                  if(request.meetup_comments.length < CALL_MANNAYO_POPUP_ONCE_USERS_COMMENT_MAX_COUNT)
                  {
                    isCommentEndUsers = true;
                  }

                  if(isInit){
                    setCommentCounterText(request.comments_count);

                    setScrollUI('.mannayo_meetup_popup_comments_ul_wrapper');
                    //var popupHeight = $('.blueprint_popup')[0].clientHeight;
                    //$('.mannayo_meetup_popup_comments_ul_wrapper').css('height', popupHeight - 100);

                    $('.ss-content').bind('scroll', function(){
                      var lastObjectName = '.li_meetup_comment_object_' + g_popupNowMannayoCommentCount;
                      
                      var lastObjectTop = $(lastObjectName).offset().top;
                      var targetObjectTop = $('.mannayo_meetup_popup_scroll_bottom_comments_fake_offset').offset().top;

                      if(isCommentEndUsers){
                        console.error('isLastUSERS!!');
                        return;
                      }

                      if(lastObjectTop < targetObjectTop)
                      {
                        if(!isRequestUsers)
                        {
                          lastCommentId = Number($(lastObjectName).attr('data-comment-id'));
                          addMeetupCommentMoreObject();
                          requestMannayoUserList();
                          isRequestUsers = true;
                          console.error("call Request USERS!!!");
                        }
                      }
                    });
                  }


                  $('.mannayo_meetup_popup_comments_searching_wrapper_ul').remove();
                };
                
                var error = function(request) {
                  alert('댓글 정보 가져오기 실패!');
                };
                
                $.ajax({
                'url': url,
                'method': method,
                'data' : data,
                'success': success,
                'error': error
                });
              };

              $('#mannayo_comments_form').ajaxForm(mannayoCommentsAjaxOption);

              addMeetupCommentMoreObject();
              requestMannayoUserList();

              $('.mannayo_comments_button').click(function(){
                if(isLogin() == false)
                {
                  alert("로그인을 해야 댓글을 달 수 있습니다.");
                  return;
                }

                if(!$('#input_mannayo_comments').val())
                {
                  alert("댓글을 입력해주세요!");
                  return;
                }

                loadingProcess($('.mannayo_comments_button'));

                $('#mannayo_comments_form').submit();
              });

              //comment end
              //////////////////////tab cancel end/////

              resetPopupContentHeight();
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
                openCancelPopup(element.attr("data_meetup_channel_id"), element.attr("data_meetup_id"), element.attr("data_meetup_title"), element.attr("data_meetup_where"), element.attr("data_meetup_what"), element.attr("data_meetup_img_url"), element.attr("data_meetup_count"), element.attr("data_comments_count"));
              });
            };

            var isTouchUserInfoButton = false;
            var resetUserInfoList = function(){
              $('.mannayo_thumb_user_name_container').hide();
            };

            var setMannayoUserInfoButton = function(){
              $('.mannayo_thumb_user_list_thumb_button').click(function(event){
                isTouchUserInfoButton = true;
                resetUserInfoList();
                var meetupId = $(this).attr('data_meetup_id');
                var getElementUserName = '.mannayo_thumb_user_name_container_'+meetupId;
                $(getElementUserName).show();
              });

              $('.mannayo_thumb_user_list_thumb_button').hover(function(event){
                resetUserInfoList();
                var meetupId = $(this).attr('data_meetup_id');
                var getElementUserName = '.mannayo_thumb_user_name_container_'+meetupId;
                $(getElementUserName).show();
              });

              $(document).click(function(e){
                if(isTouchUserInfoButton){
                  isTouchUserInfoButton = false;
                  return;
                }

                resetUserInfoList();
              });

              $(window).resize(function() {
                resetUserInfoList();
              });
            };

            setMannayoListMeetupButton();
            setMannayoCancelButton();
            setMannayoUserInfoButton();

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