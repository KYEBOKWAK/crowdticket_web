<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="naver-site-verification" content="8bce253ce1271e2eaa22bd34b508b72cc60044a5"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    

    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}"/>
    <link href="{{ asset('/css/lib/toast.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/base.css?version=10') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/app.css?version=9') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/main.css?version=7') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/global.css?version=20') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/jquery.toast.min.css') }}" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/login/login.css?version=5') }}" rel="stylesheet"/>

    <link href="{{ asset('/css/flex.css?version=6') }}" rel="stylesheet"/>

    <style>
    /*리얼에 스타일이 적용되지 않아서 임시로 넣어둠 크리에이터 N*/
    .newNavIcon{
      font-size: 10px;
      font-style: normal;
      font-weight: bold;
      position: relative;
      top: -7px;
      left: 2px;
      color: #ea535a;
    }

    #isMobile{
      display: none;
    }

    .ct-info{
      margin-top: 40px;
      font-size: 10px;
      color: #acacac;
      text-align: center;
    }

    .register_popup_user_options_container{
      text-align: left;
    }

    .register_popup_user_options_container>p{
      font-size: 12px;
      color: #808080;
    }

    .register_radio_wrapper{
      position: relative;
    }

    .register_radio_img{
      display: none;
      position: absolute;
      top: 3px;
      left: 0px;
    }

    .register_radio_img_unselect{
      display: block;
    }

    .register_popup_user_gender_input[type="radio"]{
      width: 20px;
      margin-right: 0px;
      position: relative;
      opacity: 0;
      zoom: 1;
    }

    .register_popup_user_option_gender_text{
      font-size: 18px !important;
      margin-left: 12px;
    }

    .register_popup_user_age_container{
      width: 160px;
      height: 52px;
      border-radius: 5px;
      background-color: #f7f7f7;
      position: relative;
    }

    .register_popup_city_text_container{
      position: absolute;
      width: 100%;
      font-size: 16px;
      color: #4d4d4d;
      margin-top: 16px;
    }

    #register_popup_user_age_text{
      margin-left: 16px;
      margin-right: auto;
      font-size: 14px;
    }

    .register_age_user_select{
      width: 100%;
      height: 100%;
      opacity: 0;
    }

    @media (max-width:1030px){
      #isMobile{
        display: block;
      }
    }

    /*3.5 START*/
    .navbar{
      min-width: 0;
      width: 1060px;

      margin-left: auto;
      margin-right: auto;
    }

    .navbar-default{
      border-bottom: 0px;
    }

    .navbar-brand{
      padding: 0px;
      height: auto;
      margin-top: 26px;
      margin-bottom: 26px;
    }

    .navbar-brand img{
      /*width: 141px;
      height: 16px;
      padding: 0px;*/
      width: 100%;
      height: 28px;
      padding: 0px;
    }

    #ctNavBar{
      padding: 0px;
    }

    .navbar-nav>li>a{
      padding: 0px;
      margin-left: 30px;
      margin-top: 30px;
      margin-bottom: 30px;

      font-weight: normal !important;
      font-style: normal !important;
      font-stretch: normal !important;
      line-height: normal !important;
      letter-spacing: normal !important;
    }

    .navbar-right{
      margin-right: 0px;
    }

    .container{
      padding-bottom: 0px;
    }

    .kakao_chat_icon_wrapper{
      left: auto;
      height:95px;
      margin-right: 19px;
      margin-bottom: 5px;
    }

    .kakao_chat_round{
      width: 80px;
      height: 80px;
      box-shadow: 8px 8px 14px 0 rgba(0, 0, 0, 0.1);
      background-color: #fae100;
      border-radius: 100%;
    }

    .kakao_chat_ask{
      position: relative;
      top: 18px;
      right: 1px;
      font-size: 16px;
      text-align: center;
      color: #3c1e1e;
      font-weight: bold;
      line-height: 1.4;
    }

    .kakao_chat_icon_img{
      margin-left:18px;
      margin-top:20px;
    }

    @media (max-width:1060px){
      .navbar{
        min-width: 0;
        width: 93%;

        margin-left: auto;
        margin-right: auto;
      }
    }

    @media (max-width:1030px){
      .kakao_chat_icon_wrapper{
        margin-bottom: 66px;
      }
    }

    .ct-res-text h2{
      font-size: 14px;
      font-weight: normal;
    }

    .ct-res-text h4{
      font-size: 12px;
      font-weight: normal;
      line-height: 1.5;
    }

    @media (max-width:767px){
      .navbar-toggle{
        margin-top: 27px;
        margin-right: 0px;
      }

      .navbar-nav>li>a{
        margin-top: 2px;
        margin-bottom: 10px;
        margin-left: 17px;
      }

      .kakao_chat_round{
        width: 50px;
        height: 50px;
      }

      .kakao_chat_icon_img{
        width: 40px;
        margin-left:10px;
        margin-top:11px;
      }

      .kakao_chat_icon_wrapper{
        height:auto;
        /* margin-bottom: 16px; */
        margin-bottom: 80px;
        margin-right: 18px;
      }

      .kakao_chat_ask{
        top: 11px;
        right: 0px;
        font-size: 12px;
        line-height: 1.2;
      }
    }
    /*3.5 END*/
    </style>
    
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'/>    

    <style>
        .container h2 {
            margin-top: 60px;
            margin-bottom: 25px;
        }

        .ps-detail-category {
            margin-bottom: 30px;
        }

        .ps-detail-category span {
            font-size: 1.2em;
        }

        .project-video,
        .project-thumbnail {
            width: 100%;
            height: 450px;
        }

        .ps-detail-description p,
        .ps-detail-share-facebook span {
            width: 100%;
            height: 50px;
        }

        .ps-detail-description {
            padding-right: 0;
        }

        .ps-detail-description p {
            padding-left: 24px;
            background-color: #aaa;
            color: white;
            font-weight: bold;
            font-size: 18px;
            line-height: 50px;
        }

        .ps-detail-share-facebook {
            padding-left: 0;
            display: none;
        }

        .ps-detail-share-facebook span {
            border: none;
            border-radius: 0;
            color: white;
            font-size: 12px;
            background-color: #3a5795;
            padding-top: 15px;
        }

        .ps-detail-share-facebook span:hover {
            color: #eee;
        }

        .ps-detail-tabs {
            margin-top: 40px;
        }

        .ps-detail-tabs .nav-tabs {
            font-size: 14px;
            color: #8a8273;
        }

        .ps-detail-tabs .active {
            font-weight: bold;
        }

        .ps-detail-right-section {
            padding: 0px 10px 0px 10px;
        }

        .tab-pane {
          /*
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            border-left: 1px #ddd solid;
            border-right: 1px #ddd solid;
            border-bottom: 1px #ddd solid;
            background-color: white;
            padding: 27px 27px 40px 27px;
            */
        }


        #news-container {
            margin-bottom: 20px;
        }

        .ps-detail-comment-wrapper {
            margin-bottom: 20px;
        }

        .ps-detail-comment-wrapper button {
            margin-top: 10px;
        }

        #comments-container {
            padding: 0;
            /*word-break: keep-all;*/
        }

        #ticket_list {
            margin-top: 30px;
			      margin-right: 0px;
			      margin-left: 0px;
        }

        .ticket {
            padding: 0px;
        }

        .creator-wrapper {
            margin-top: 30px;
        }

        .newIcon{
          font-size: 10px;
          font-style: normal;
          font-weight: bold;
          position: relative;
          top: -6px;
          color: #7EC52A
        }

        footer{
          display: none;
        }

        .datepicker-title{
          background-color: #43c9f0 !important;
        }

        .tab-content{
          margin-left: auto;
          margin-right: auto;
        }
        
    </style>

    <link href="{{ asset('/css/detail.css?version=17') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/goods.css?version=6') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/project/form_body_ticket.css?version=3') }}"/>

    <link href="{{ asset('/css/calendar.css?version=10') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-lite.css?version=1') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-crowdticket.css?version=3') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/swiper/swiper.min.css?version=1') }}">

    <style>
    .tab-pane{
      padding: 0 !important;          
    }
    </style>
</head>
<body>

<div class="detail_content_calendar_container_grid">
  <div class="tab-content">
    <div id="tab-story" role="tabpanel" class="tab-pane active detail_remove_bottom_border">
      <div class="detail_story_wrapper">
        {!! html_entity_decode($magazine->story) !!}
      </div>
    </div>
  </div>
</div>

</body>
</html>
