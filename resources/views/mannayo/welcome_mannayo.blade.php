@extends('app')
@section('meta')
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="크라우드티켓"/>
    <meta property="og:description" content="(테스트)크리에이터에게 좋아요를 요청해보세요!"/>
    <meta property="og:image" content="{{ asset('/img/app/og_image_1.png') }}"/>
    <!-- <meta property="og:url" content="https://crowdticket.kr/"/> -->
@endsection
@section('css')
    <style>
        p{
          margin-bottom: 0px;
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

        #main {
            padding-bottom:0px;
        }

        .welcome_start_content_container{
          width:1060px;
          height: 100%;
          margin-left: auto;
          margin-right: auto;
        }

        .mannayo_title_background{
          height: 348px;
          text-align: center;
          background-image: linear-gradient(to right, #3bd0ef, #9f83fa 24%, #c72ffd 59%, #e891b7 86%, #f7948f);
        }

        .mannayo_title_background p{
          margin: 0;
          padding-top: 80px;
          line-height: 1.38;
          color: white;
          font-size: 32px;
          font-weight: 500;
        }

        .mannayo_search_container{
          /*
          position: absolute;
          width: 520px;
          left: 50%;
          top: 288px;
          transform:translate(-50%, 0);
          */
        }

        .mannayo_search_container_target{
          position: absolute;
          width: 520px;
          left: 50%;
          top: 288px;
          transform:translate(-50%, 0);
        }

        .input_mannayo_search_img{
          width: 60px;
          height: 60px;
          border-radius: 10px;
          border-right: 0px;
          background-color: rgba(255, 255, 255, 0.3);
          text-align: center;

          border-top-right-radius: 0px;
          border-bottom-right-radius: 0px;
        }

        #input_mannayo_search{
          /*width: 520px;*/
          width: 100%;
          height: 60px;
          /*opacity: 1.2;*/
          border: 0px;
          border-radius: 10px;
          background-color: rgba(255, 255, 255, 0.3);
          padding-left: 0px;
          border-left: 0px;
          font-size: 22px;

          border-top-left-radius: 0px;
          border-bottom-left-radius: 0px;

          color: white;
        }

        #mannayo_search_result_container{
          display: none;
          width: 100%;
          background-color: white;
          border-radius: 10px;
          
          /*height: 200px;*//*테스트*/
        }



        @keyframes blink {
            /**
            * At the start of the animation the dot
            * has an opacity of .2
            */
            0% {
              opacity: .2;
            }
            /**
            * At 20% the dot is fully visible and
            * then fades out slowly
            */
            20% {
              opacity: 1;
            }
            /**
            * Until it reaches an opacity of .2 and
            * the animation can start again
            */
            100% {
              opacity: .2;
            }
        }
        

        .searching span {
            animation-name: blink;
            animation-duration: 1.4s;
            animation-iteration-count: infinite;
            animation-fill-mode: both;
        }

        .searching span:nth-child(2) {
            animation-delay: .2s;
        }

        .searching span:nth-child(3) {
            animation-delay: .4s;
        }
        .searching span:nth-child(4) {
            animation-delay: .6s;
        }

        .mannayo_searching_loading_container{
          display: none;
          /*width: 520px;*/
          width: 100%;
          height: 100px;
          border-radius: 10px;
          background-color: white;
          box-shadow: 4px 4px 30px 0 rgba(0, 0, 0, 0.1);
          text-align: center;
        }

        .mannayo_searching_loading_container span{
          font-size: 50px;
        }

        .mannayo_search_result_ul_wrapper{
          max-height: 258px;
          background-color: white;

          border-radius: 10px;
          border-bottom-left-radius: 0px;
          border-bottom-right-radius: 0px;
        }

        #mannayo_search_result_ul{
          /*height: 100px;*/
          margin-bottom: 0px;
        }

        .result_creator_thumbnail_img_wrapper{
          margin: 12px 24px;
        }

        .result_creator_meet_more_search_title{
          font-size: 17px;
          color: #4d4d4d;
          margin-top: 25px;
          margin-left: 20px;
        }

        .result_creator_thumbnail_img{
          width: 52px;
          height: 52px;
          border-radius: 100%;
        }

        .result_creator_name{
          font-size: 20px;
          color: #4d4d4d;
          margin-top: 24px;
        }

        li { list-style: none }
        ul { 
          padding: 0;
          margin-bottom: 0px;
        }

        .result_creator_wrapper{
          height: 76px;
          /*padding-top: 5px;*/
        }

        .result_creator_meet_container{
          margin-top: 13px;
          margin-right: 12px;
          margin-left: auto;
          height: 50px;
          border: 0;
          background-color: rgba(255, 255, 255, 0);
        }

        .result_creator_meet_word{
          font-size: 16px;
          color: #acacac;
          margin-right: 12px;
          margin-top: 10px;
        }

        .result_creator_meet_plus{
          width: 36px;
          height: 36px;
          background-color: #43c9f0;
          border-radius: 100%;
          font-size: 25px;
          color: white;
          margin-top: 3px;
        }

        .mannayo_result_ul_gradation{
          width: 100%;
          height: 80px;
          position: absolute;
          bottom: 0px;
          pointer-events: none;
          z-index: 10000;
          background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.8));
        }

        .mannayo_search_result_find_container{
          width: 100%;
          /*height: 100px;*/
          background-color: #f7f7f7;
          border-radius: 10px;

          border-top-left-radius: 0px;
          border-top-right-radius: 0px;
        }

        .mannayo_search_result_ul_container{
          border-bottom-left-radius: 0px;
          border-bottom-right-radius: 0px;
          position: relative;
        }

        .mannayo_search_result_find_button{
          width: 125px;
          height: 65px;
          color: #808080;
          font-size: 14px;
          padding: 0px;
          text-align: right;
          border: 0px;
          background-color: rgba(255, 255, 255, 0);
        }

        .mannayo_search_result_find_button_wrapper{
          width: 143px;
          text-align: right;
          padding-top: 18px;
        }

        .mannayo_search_result_ready_ul_wrapper{
          max-height: 258px;
          background-color: white;

          
          border-bottom-left-radius: 0px;
          border-bottom-right-radius: 0px;
        }
        
        .mannayo_search_result_ready_label{
          margin-bottom: 0px;
          font-size: 12px;
          color: #808080;
          width: 476px;
          margin: 0px auto;
        }

        .mannayo_search_result_ready_ul_container{
          position: relative;
        }

        .mannayo_search_result_line{
          width: 476px;
          height: 1px;
          opacity: 0.2;
          background-color: #acacac;
          margin: 16px auto;
          margin-top: 0px;
        }

        .result_meetup_meet_button{
          width: 85px;
          height: 40px;
          font-size: 16px;
          border-radius: 21px;
          border: 0.8px solid #acacac;
          color: #acacac;
        }

        .result_meetup_content_container{
          width: 320px;
          padding-top: 14px;
        }

        .result_meetup_name{
          font-size: 18px;
          color: #4d4d4d;
        }

        .result_meetup_content{
          width: 280px;
          font-size: 14px;
          line-height: 1.57;
          color: #acacac;
        }

        .result_meetup_meet_button_container{
          width: 100%;
          text-align: right;
          padding-right: 12px;
          padding-top: 18px;
        }

        .mannayo_channel_input_label{
          font-size: 14px;
          margin-bottom: 8px;
        }

        .mannayo_channel_input{
          width: 100%;
          height: 40px;
        }

        .mannayo_search_result_find_label{
          font-size: 17px;
          color: #4d4d4d;
          margin-bottom: 0px;
          margin-left: 20px;
          margin-top: 38px;
        }

        .mannayo_channel_search_container{
          padding: 20px;
        }

        .mannayo_channel_input_help_block{
          font-size: 12px;
          color: #acacac;
          margin-top: 8px;
        }

        .result_creator_find_success_title{
          padding-top: 24px;
          font-size: 17px;
          margin-left: 20px;
        }

        .meetup_popup_container{
          width: 380px;
          margin-left: auto;
          margin-right: auto;
        }

        .meetup_popup_option_creator{
          width: 327px;
          height: 56px;
          border-radius: 5px;
          background-color: #f7f7f7;
          margin-right: 12px;
          position: relative;
        }

        .meetup_popup_option_label{
          font-size: 18px;
          color: #4d4d4d;
          margin-top: 15px;
        }

        .swal-content{
          margin-top: 40px;
          margin-bottom: 40px;
        }

        .meetup_popup_option_img{
          width: 36px;
          height: 36px;
          margin-left: auto;
          margin-right: 12px;
          border-radius: 100%;
          margin-top: 10px;
        }

        .meetup_popup_option_creator_title{
          margin-right: auto;
          font-size: 16px;
          margin-top: 16px;
        }

        .blueprint_popup{
          width: 560px;
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

        .meetup_popup_title_container>h2{
          margin: 0px;
          font-size: 32px;
          font-weight: 500;
          color: #1a1a1a;
        }

        .meetup_popup_title_container>p{
          margin-top: 20px;
          margin-bottom: 40px;
        }

        select{
            width: 100%;
            height: 100%;
        }

        .city_meetup_select{
          opacity: 0;
        }

        .age_user_select{
          opacity: 0;
        }

        .meetup_popup_city_text_container{
          position: absolute;
          width: 100%;
          font-size: 16px;
          color: #4d4d4d;
          margin-top: 16px;
        }

        #meetup_popup_city_text{
          margin-left: auto;
          margin-right: 95px;
        }

        .meetup_popup_option_wrapper{
          margin-top: 12px; 
        }

        #meetup_popup_option_what_input{
          width: 100%;
          height: 100%;
          border-radius: 5px;
          /*color: #e6e6e6;*/
          border: 1px solid #e6e6e6;
        }

        .meetup_popup_line{
          width: 100%;
          height: 1px;
          opacity: 0.2;
          background-color: #acacac;
          margin: 40px 0px;
        }

        #meetup_popup_option_what_input::-ms-input-placeholder { 
          color: #e6e6e6;
          text-align: center;
        }
        #meetup_popup_option_what_input::-webkit-input-placeholder { 
          color: #e6e6e6;
          text-align: center;
        } 
        #meetup_popup_option_what_input::-moz-placeholder { 
          color: #e6e6e6;
          text-align: center;
        }

        .meetup_popup_user_nickname_input{
          width: 100%;
          border-radius: 5px;
          /*color: #e6e6e6;*/
          border: 1px solid #e6e6e6;
          font-size: 18px;
          padding: 5px;
          margin-bottom: 10px;
        }

        .meetup_popup_user_label{
          font-size: 18px;
          width: 50px;
          margin-right: 60px;
          text-align: left;
        }

        .meetup_popup_user_options_container{
          text-align: left;
        }

        .meetup_popup_user_anonymous_inputbox[type="checkbox"]{
          /*display: none;*/
          width: 16px;
          margin-right: 8px;
          margin-top: 2px;
        }

        .meetup_popup_user_gender_input[type="radio"]{
          width: 20px;
          margin-right: 12px;
        }

        .meetup_popup_user_wrapper{
          margin-bottom: 28px;
        }

        input[type="radio"], input[type=checkbox]{
          zoom: 1;
        }

        .meetup_popup_user_age_container{
          width: 160px;
          height: 52px;
          border-radius: 5px;
          background-color: #f7f7f7;
          position: relative;
        }

        #meetup_popup_user_age_text{
          margin-left: 16px;
          margin-right: auto;
          font-size: 14px;
        }

        #meetup_new_button{
          width: 100%;
          height: 56px;
          color: white;
          border-radius: 5px;
          background-color: #43c9f0;
          font-size: 20px;
          font-weight: 500;
          border: 0;
        }

        #meetup_up_button{
          width: 100%;
          height: 56px;
          color: white;
          border-radius: 5px;
          background-color: #43c9f0;
          font-size: 20px;
          font-weight: 500;
          border: 0;
        }

        .meetup_popup_bottom_label{
          font-size: 12px;
          color: #808080;
          margin-top: 12px;
        }

        .meetup_callyou_popup_title{
          font-size: 16px;
          color: #4d4d4d;
          margin-bottom: 28px;
        }

        #meetup_callyou_popup_option_contact_input{
        }

        #meetup_callyou_popup_option_email_input{
        }

        .meetup_callyou_popup_input{
          width: 100%;
          height: 56px;
          border-radius: 5px;
          border: 1px solid #e6e6e6;
          background-color: white;
          margin-bottom: 8px;
          text-align: center;
        }

        #meetup_callyou_popup_ok_button{
          width: 100%;
          height: 56px;
          border-radius: 5px;
          background-color: #43c9f0;
          margin-top: 4px;
          margin-bottom: 12px;
          color: white;
          font-size: 20px;
          font-weight: 500;
        }

        .meetup_callyou_help_block{
          font-size: 12px;
          color: #808080;
        }

        .meetup_popup_complete{
          width: 200px;
          height: 190px;
          border-radius: 21px;
          box-shadow: 2px 2px 12px 0 rgba(0, 0, 0, 0.1);
        }

        .meetup_popup_complete>.swal-content{
          margin-top: 20px;
          margin-bottom: 20px;
          padding: 0px;
        }

        .meetup_popup_complete_button{
          height: 150px;
          border: 0;
          background-color: white;
        }

        .meetup_popup_complete_button>p{
          font-size: 12px;
          color: #4d4d4d;
        }

        .meetup_popup_complete_img{
          height: 60px;
          margin-bottom: 30px;
        }

        .meetup_popup_thumb_container{
          margin-top: 32px;
        }

        .meetup_popup_content_container{
          margin-top: 16px;
          font-size: 24px;
          color: #4d4d4d;
        }

        .meetup_popup_content_point_color{
          font-weight: 500;
          color: black;
        }

        .meetup_popup_meet_count_container{
          margin-top: 15px;
        }

        .meetup_popup_meet_count_container>p{
          font-size: 12px;
          color: #808080;
          margin-top: 8px;
        }

        .searching_span{
          font-size: 30px;
        }

        .mannayo_list_container{
          margin-top: 130px;
        }
/*
        .mannayo_thumb_img{
          max-width: 250px;
          max-height: 250px;
        }
        */

        .mannayo_thumb_img_wrapper{
          max-width: 250px;
          position: relative;
        }

        .mannayo_thumb_img_resize{
          position: relative;
          width: 100%;
          padding-top: 100%;
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

        .mannayo_thumb_meet_count{
          position: absolute;
          bottom: 12px;
          left: 12px;
          color: #fafafa;
          font-size: 12px;
        }

        .mannayo_thumb_meet_users_container{
          position: absolute;
          bottom: 12px;
          right: 12px;
          color: #fafafa;
          font-size: 12px;
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

        .meetup_users_profile_img{
          width: 16px; 
          height: 16px; 
          border-radius: 100%; 
          margin-left: -10px;
          position: relative;
        }

        .mannayo_thumb_content_container{
          font-size: 12px;
          color: #808080;
        }

        .mannayo_thumb_container{
          width: 250px;
        }

        .mannayo_list_loading_container{
          text-align: center;
          font-size: 40px;
        }

        @media (max-width:1060px) {
          .welcome_start_content_container{
            margin-left: 13%;
            width: 70%;
          }
        }

        @media (max-width:768px) {
          
        }

        @media (max-width:720px) {
          .popup_close_button_wrapper{
            top: 20px;
            right: 20px;
          }
        }

        @media (max-width:650px) {
          
        }

        @media (max-width:650px) {
          
        }

        @media (max-width:320px) {
          

          
        }
    </style>

<link href="{{ asset('/css/simple-scrollbar.css?version=1') }}" rel="stylesheet">
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

    <div class="mannayo_title_container">
        <div class="mannayo_title_background">  
          <p>만나고 싶은 크리에이터를 등록하세요.<br>
          가장 먼저 이벤트에 초대해 드릴게요.</p>
        </div>
    </div>

    <div class="mannayo_search_container_target">
      <div class="mannayo_search_container">
          <div class="mannayo_search_input_container">
            <div class="flex_layer">
              <div class="input_mannayo_search_img"><img src="{{ asset('/img/icons/svg/ic-search-wh.svg') }}" style="width: 24px; height: 24px; margin-top: 19px;"/></div>
              <input type="text" id="input_mannayo_search" placeholder="크리에이터 검색"/>
            </div>
          </div>

          <div class="mannayo_searching_loading_container">
            <p class="searching"><span>.</span><span>.</span><span>.</span><span>.</span></p>
          </div>

          <div id="mannayo_search_result_container">
            <!-- 검색 안에 내용 start -->
            <!-- 크리에이터 검색 결과 START -->
            <div class="mannayo_search_result_ul_container">
              <div class="mannayo_search_result_ul_wrapper">
                <ul id="mannayo_search_result_ul">
                </ul>
              </div>
              
              <div class="mannayo_result_ul_gradation">
              </div>
            </div>
            <!-- 크리에이터 검색 결과 END -->

            <!-- 이미 만나요 검색 결과 START -->
            <div class="mannayo_search_result_line">
            </div>
            <p class="mannayo_search_result_ready_label">이미 있는 만나요</p>
            <div class="mannayo_search_result_ready_ul_container">
              <div class="mannayo_search_result_ready_ul_wrapper">
                <ul id="mannayo_search_result_ready_ul">
                </ul>
              </div>
              
              <div class="mannayo_result_ul_gradation">
              </div>
            </div>
            <!-- 이미 만나요 검색 결과 END -->
            <div class="mannayo_search_result_find_container">
            </div>
            <!-- 검색 안에 내용 end -->
          </div>
      </div>
    </div>

    <div class="welcome_content_container">
        
        <div class='mannayo_list_container' style='display:none;'>
          @foreach($meetups as $meetup)
            <div class='mannayo_thumb_container'>
              <div class='mannayo_thumb_img_wrapper'>
                <div class='mannayo_thumb_img_resize'>
                  <img class='mannayo_thumb_img project-img' src='{{$meetup->thumbnail_url}}'>
                  <div class="thumb-black-mask">
                  </div>
                  <div class='mannayo_thumb_meet_count'>
                    <img src="{{ asset('/img/icons/svg/ic-meet-join-member-wh.svg') }}" style="margin-right: 4px; margin-bottom: 3px;"/>{{$meetup->meet_count}} 명 요청중
                  </div>

                  <div class='mannayo_thumb_meet_users_container'>
                  <?php
                    $zIndex = count($meetup->meetup_users);
                  ?>
                  @foreach($meetup->meetup_users as $meetup_user)
                    <img src='{{$meetup_user->user_profile_url}}' class='meetup_users_profile_img' style='z-index:{{$zIndex}}'/>
                    <?php
                      $zIndex--;
                    ?>
                  @endforeach
                  </div>
                </div>
              </div>

              <div class='mannayo_thumb_title_wrapper'>
                {{$meetup->title}}
              </div>
              <div class='mannayo_thumb_content_container'>
                {{$meetup->where}}에서 · {{$meetup->what}}
              </div>
              <div class='mannayo_thumb_button_wrapper'>
                @if($meetup->is_meetup)
                  <button class='mannayo_thumb_meetup_cancel_button'>
                    만나요 요청됨
                  </button>
                @else
                  <button class='mannayo_thumb_meetup_button'>
                    만나요
                  </button>
                @endif
              </div>
            </div>
          @endforeach
        </div>

        <div class="mannayo_list_loading_container">
          <p class="searching"><span>.</span><span>.</span><span>.</span><span>.</span></p>
        </div>
    </div>
 
@endsection

@section('js')
<script src="{{ asset('/js/simple-scrollbar.js?version=1') }}"></script>

    <script>
      const FIND_TYPE_IN_API = 1;
      const FIND_TYPE_IN_CHANNEL = 2;

      const TYPE_LIST_FIRST_CREATOR = 1;
      const TYPE_LIST_FIRST_FIND_SUCCESS = 2;
      const TYPE_LIST_FIRST_FIND_NO = 3;
      const TYPE_LIST_FIRST_FIND_API_NO = 4;

      const TYPE_LIST_SECOND_MEETUP = 1;
      const TYPE_LIST_SECOND_FIND_API = 2;
      const TYPE_LIST_SECOND_FIND_NO = 3;

      const SEARCH_OBJECT_HEIGHT = 76;

      const AGE_NONE_TYPE_OPTION = 9999;//선택되지 않은 년생 option 값

      const SORT_TYPE_NEW = 0;
      const SORT_TYPE_POPULAR = 1;
      const SORT_TYPE_MY_MEETUP = 2;

      var citys = ['장소 선택', '서울', '부산', '대전', '대구', '광주', '울산', '인천', '경기도', '강원도', '충청도', '경상도', '전라도', '제주'];

      $(document).ready(function () {
        var g_creatorsSearchList = $("#mannayo_search_result_ul");
        var g_meetupSearchList = $("#mannayo_search_result_ready_ul");
        var g_footerContainer = $(".mannayo_search_result_find_container");

        var setScrollUI = function(selector){
          var el = document.querySelector(selector);
          SimpleScrollbar.initEl(el);
        };

        setScrollUI(".mannayo_search_result_ul_wrapper");
        setScrollUI(".mannayo_search_result_ready_ul_wrapper");

        var searchingOnOff = function(on){
          if(on === true)
          {
            if(!$(".mannayo_searching_loading_container").is(':visible'))
            {
              $("#mannayo_search_result_container").hide();
              $(".mannayo_searching_loading_container").show();
              //$("#input_mannayo_search").attr("disabled", "disabled");

              removeAllList();
            }
          }
          else
          {
            $(".mannayo_searching_loading_container").hide();
            $("#mannayo_search_result_container").show();
          }
        }

        var setCreatorScrollOption = function(){
          //$(".mannayo_search_result_ul_container").show();
          if(g_creatorsSearchList.children().size() < 4){
            $(".mannayo_search_result_ul_container").find(".mannayo_result_ul_gradation").hide();

            var ssContent = $(".mannayo_search_result_ul_wrapper").find(".ss-content");
            if(ssContent)
            {
              ssContent[0].style.width = '100%';
            }

            var resultULHeight = Number(g_creatorsSearchList.children().size()) * SEARCH_OBJECT_HEIGHT;
            $(".mannayo_search_result_ul_wrapper")[0].style.height=resultULHeight+"px";
          }
          else{
            //$(".mannayo_result_ul_gradation").show();
            $(".mannayo_search_result_ul_container").find(".mannayo_result_ul_gradation").show();

            var ssContent = $(".mannayo_search_result_ul_wrapper").find(".ss-content");
            if(ssContent)
            {
              ssContent[0].style.width = 'calc(100% + 18px)';
            }

            $(".mannayo_search_result_ul_wrapper")[0].style.height = "258px";
          }
        }

        var setMeetupScrollOption = function(list_second_type){
          if(list_second_type === TYPE_LIST_SECOND_FIND_NO){
            $('.mannayo_search_result_ready_ul_container').hide();
            $('.mannayo_search_result_line').hide();
            $('.mannayo_search_result_ready_label').hide();
          }
          else{
            if(list_second_type === TYPE_LIST_SECOND_FIND_API){
              $('.mannayo_search_result_ready_label').hide();
            }
            else
            {
              $('.mannayo_search_result_ready_label').show();
            }

            if(g_meetupSearchList.children().size() < 4){
              $('.mannayo_search_result_ready_ul_container').show();
              $('.mannayo_search_result_line').show();
              //$('.mannayo_search_result_ready_label').show();

              $(".mannayo_search_result_ready_ul_container").find(".mannayo_result_ul_gradation").hide();

              var ssContent = $(".mannayo_search_result_ready_ul_wrapper").find(".ss-content");
              if(ssContent)
              {
                ssContent[0].style.width = '100%';
              }

              //var resultULHeight = $("#mannayo_search_result_ready_ul")[0].clientHeight;
              var resultULHeight = Number(g_meetupSearchList.children().size()) * SEARCH_OBJECT_HEIGHT;
              $(".mannayo_search_result_ready_ul_wrapper")[0].style.height=resultULHeight+"px";
            }
            else{
              $('.mannayo_search_result_ready_ul_container').show();
              $('.mannayo_search_result_line').show();
              //$('.mannayo_search_result_ready_label').show();

              $(".mannayo_search_result_ready_ul_container").find(".mannayo_result_ul_gradation").show();

              var ssContent = $(".mannayo_search_result_ready_ul_wrapper").find(".ss-content");
              if(ssContent)
              {
                ssContent[0].style.width = 'calc(100% + 18px)';
              }

              $(".mannayo_search_result_ready_ul_wrapper")[0].style.height = "258px";
            }
          }
        };

        var removeCreatorList = function(){
          g_creatorsSearchList.children().remove();
        };

        var removeMeetupList = function(){
          g_meetupSearchList.children().remove();
        }

        var removeCreatorLastObject = function(){
          
        }

        var completeMeetUpPopup = function(creator_title){
          var elementPopup = document.createElement("div");
          elementPopup.innerHTML = 
          "<button class='meetup_popup_complete_button'>" + 
            "<div class='meetup_popup_complete_img'>" +
              "짝!" +
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
                  closeOnEsc: true
              }).then(function(value){
                showLoadingPopup('');
                window.location.reload();
              });

          $(".swal-footer").hide();

          $('.meetup_popup_complete_button').click(function(){
              swal.close();
          });
        };

        var requestResetUserData = function(){

        };

        var createCallYouPopup = function(contactNumber, email, creator_title){
          var elementPopup = document.createElement("div");
          elementPopup.innerHTML = 
          "<div class='meetup_popup_container'>" + 
            "<div class='meetup_callyou_popup_title'>" + 
              "아래 연락처로 알림을 드릴게요" +
            "</div>" +
            "<input id='meetup_callyou_popup_option_contact_input' class='meetup_callyou_popup_input' type='tel' name='tel' placeholder='연락처가 없습니다. (-없이 숫자만 입력)' value='"+contactNumber+"'>" + 
            "<input id='meetup_callyou_popup_option_email_input' class='meetup_callyou_popup_input' type='email' placeholder='이메일 주소' value='"+email+"'>" + 

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
                  className: "blueprint_popup",
                  closeOnClickOutside: false,
                  closeOnEsc: false
              });

          $(".swal-footer").hide();

          $('.popup_close_button').click(function(){
              swal.close();
              completeMeetUpPopup(creator_title);
          });

          $("#meetup_callyou_popup_ok_button").click(function(){
            swal.close();
            completeMeetUpPopup(creator_title);
          });
        };

        var checkCreateMeetup = function(creator_channel_id){
          if(!creator_channel_id || creator_channel_id === '0')
          {
            alert("크리에이터 채널 id 값 에러");
            return false;
          };

          if($(".city_meetup_select").val() === '0'){
            alert("장소를 선택해주세요.");
            return false;
          };

          if(Check_nonTag(document.getElementById('meetup_popup_option_what_input').value) == false){
            Check_nonTagReturn('meetup_popup_option_what_input');
            return false;
          };

          if(!$("#meetup_popup_option_what_input").val()){
            alert("무엇을 할지 정해주세요!");
            return false;
          };

          if(isCheckOnlyEmptyValue($("#meetup_popup_option_what_input").val())){
            alert("'하고 싶어요!' 가 공백입니다. 무엇을 할지 정해주세요!");
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

        var requestCreateMeetUp = function(creator_id, creator_channel_id, creator_title, creator_img_url){
          if(!checkCreateMeetup(creator_channel_id))
          {
            return;
          }
          loadingProcess($("#meetup_new_button"));
          $(".popup_close_button_wrapper").hide();

          //console.error($("#meetup_popup_user_anonymous_inputbox").is(":checked"));
          var url="/mannayo/create";
          var method = 'post';
          var data =
          {
            "creator_id" : creator_id,
            "creator_channel_id" : creator_channel_id,
            "creator_title" : creator_title,
            "creator_img_url" : creator_img_url,
            "where" : $(".city_meetup_select").val(),
            "what" : $("#meetup_popup_option_what_input").val(),
            "nick_name" : $("#meetup_popup_user_nickname_input").val(),
            "anonymity" : Number($("#meetup_popup_user_anonymous_inputbox").is(":checked")),
            "gender" : $('input:radio[name=gender]:checked').val(),
            "age" : $(".age_user_select").val()
          }
          var success = function(request) {
            loadingProcessStop($("#meetup_new_button"));
            $(".popup_close_button_wrapper").show();
            //console.error(request);
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
            loadingProcessStop($("#meetup_new_button"));
            $(".popup_close_button_wrapper").show();
            alert('만나요 생성 실패. 다시 시도해주세요.');
            //swal("에러", '만나요 생성 실패. 다시 시도해주세요.', 'error');
            //console.error(request);
          };
          
          $.ajax({
          'url': url,
          'method': method,
          'data' : data,
          'success': success,
          'error': error
          });
          
        };

        var openNewMeetPopup = function(creator_id, creator_title, creator_thumbnail_url, creator_channel_id){
          var cityOptions = '';
          var ageOptions = '';
          for(var i = 0 ; i < citys.length ; i++)
          {
            var value = citys[i];
            //cityOptions += "<option value='"+ value +"'>" + value + "</option>";

            if(i === 0)
            {
              cityOptions += "<option value='"+ i +"' selected>" + value + "</option>";
            }
            else
            {
              cityOptions += "<option value='"+ value +"'>" + value + "</option>";
            }
          }

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
              "<h2>새 만나요 만들기</h2>" +
              "<p>언제까지 좋아요만 누를 순 없다! <br>크리에이터와 만나요 요청하고 진짜 만나요</p>" +
            "</div>" +
            
            "<div class='meetup_popup_option_container'>" + 
              "<div class='meetup_popup_option_wrapper flex_layer'>" +
                "<div class='meetup_popup_option_creator'>" +
                  "<div class='flex_layer'>" +
                    "<img class='meetup_popup_option_img' src='"+creator_thumbnail_url+"'>" +
                    "<p class='meetup_popup_option_creator_title'>" + 
                      creator_title +
                    "</p>" +
                  "</div>" +
                "</div>" +
                "<p class='meetup_popup_option_label'>과/와" + 
                "</p>" +
              "</div>" +

              "<div class='meetup_popup_option_wrapper flex_layer'>" +
                "<div class='meetup_popup_option_creator'>" +
                  "<div class='meetup_popup_city_text_container flex_layer'>" +
                    "<p id='meetup_popup_city_text'>장소 선택</p>" +
                    "<img src='{{ asset('/img/icons/svg/icon-box.svg') }}' style='margin-right: 24px;'>" +
                  "</div>" +
                  "<select class='city_meetup_select' name='city_meetup'>" +
                      //"<option value='장소 선택'>장소 선택</option>" +
                      cityOptions +
                  "</select>" +
                "</div>" +
                "<p class='meetup_popup_option_label'>에서" + 
                "</p>" +
              "</div>" +

              "<div class='meetup_popup_option_wrapper flex_layer'>" +
                "<div class='meetup_popup_option_creator' style='width: 254px;'>" +
                  "<input id='meetup_popup_option_what_input' placeholder='무엇을 하고 싶나요?'>" + 
                "</div>" +
                "<p class='meetup_popup_option_label'>를 하고 싶어요!" + 
                "</p>" +
              "</div>" +

            "</div>" +

            "<div class='meetup_popup_line'>" + 
            "</div>" +

            "<div class='meetup_popup_user_container'>" +
              "<div class='meetup_popup_user_wrapper flex_layer'>" +
                "<div class='meetup_popup_user_label'>" +
                  "닉네임" +
                "</div>" +
                "<div class='meetup_popup_user_options_container'>" + 
                  "<input id='meetup_popup_user_nickname_input' type='text' class='meetup_popup_user_nickname_input' value='"+nickName+"'>" +
                  "<div class='flex_layer'>" +
                    "<input id='meetup_popup_user_anonymous_inputbox' type='checkbox' class='meetup_popup_user_anonymous_inputbox' value=''>" +
                    "<p style='font-size: 14px;'>익명</p>" +
                  "</div>" +
                  "<p class='help-block'>닉네임을 지우시면 회원 이름이 공개됩니다.</p>" +
                "</div>" +
              "</div>" +

              "<div class='meetup_popup_user_wrapper flex_layer'>" +
                "<div class='meetup_popup_user_label'>" +
                  "성별" +
                "</div>" +
                "<div class='meetup_popup_user_options_container flex_layer'>" + 
                  "<input class='meetup_popup_user_gender_input' type='radio' name='gender' value='m'/>" +
                  "<p style='font-size: 18px; margin-right: 40px;'>남</p>" + 
                  "<input class='meetup_popup_user_gender_input' type='radio' name='gender' value='f'/>" +
                  "<p style='font-size: 18px;'>여</p>" + 
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
              "<button id='meetup_new_button' data_creator_id='"+creator_id+"' data_creator_channel_id='"+creator_channel_id+"' data_creator_title='"+creator_title+"' data_creator_img_url='"+creator_thumbnail_url+"'>" +
                "새 만나요 만들기" +
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

          $(".city_meetup_select").change(function(){
            //console.error($(".city_meetup_select option").index($(".city_meetup_select option:selected")));
            if($(this).val() === '0')
            {
              $("#meetup_popup_city_text").text(citys[0]);
            }
            else
            {
              $("#meetup_popup_city_text").text($(this).val());
            }
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

          $("#meetup_popup_user_anonymous_inputbox").change(function(){
            //console.error($(this).is(":checked"));
            if($(this).is(":checked")){
              //익명 체크하면
              $("#meetup_popup_user_nickname_input").attr("disabled",true);
              $("#meetup_popup_user_nickname_input").css('background-color', '#f7f7f7');
            }
            else{
              $("#meetup_popup_user_nickname_input").attr("disabled",false);
              $("#meetup_popup_user_nickname_input").css('background-color', 'white');
            }
            
          });

          if($("#user_gender").val())
          {
            $('input:radio[name=gender]:input[value=' + $("#user_gender").val() + ']').attr("checked", true); 
          }

          if($("#user_age").val())
          {
            $(".age_user_select").val($("#user_age").val());
            $("#meetup_popup_user_age_text").text($("#user_age").val());
          }

          $("#meetup_new_button").click(function(){
            requestCreateMeetUp($(this).attr('data_creator_id'), $(this).attr('data_creator_channel_id'), $(this).attr('data_creator_title'), $(this).attr('data_creator_img_url'));
          });

          //addSearchBar(".meetup_popup_option_searchbar");
        };

        var closeLoginPopup = function(){
          swal.close();
        };

        var setOpenNewMeetPopup = function(){
          $(".result_new_meet_button").click(function(){
            if(!isLogin())
            {
              loginPopup(closeLoginPopup, null);
              return;
            }
            var element = $(this);
            openNewMeetPopup(element.attr("data_creator_id"), element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"));
          });
        };

        var requestMeetUp = function(meetup_id){
          if(!checkMeetup(meetup_id))
          {
            return;
          }

          loadingProcess($("#meetup_up_button"));
          $(".popup_close_button_wrapper").hide();

          //console.error($("#meetup_popup_user_anonymous_inputbox").is(":checked"));
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
            //console.error(request);

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
            //swal("에러", '만나요 생성 실패. 다시 시도해주세요.', 'error');
            //console.error(request);
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
                  "<input id='meetup_popup_user_nickname_input' type='text' class='meetup_popup_user_nickname_input' value='"+nickName+"'>" +
                  "<div class='flex_layer'>" +
                    "<input id='meetup_popup_user_anonymous_inputbox' type='checkbox' class='meetup_popup_user_anonymous_inputbox' value=''>" +
                    "<p style='font-size: 14px;'>익명</p>" +
                  "</div>" +
                  "<p class='help-block'>닉네임을 지우시면 회원 이름이 공개됩니다.</p>" +
                "</div>" +
              "</div>" +

              "<div class='meetup_popup_user_wrapper flex_layer'>" +
                "<div class='meetup_popup_user_label'>" +
                  "성별" +
                "</div>" +
                "<div class='meetup_popup_user_options_container flex_layer'>" + 
                  "<input class='meetup_popup_user_gender_input' type='radio' name='gender' value='m'/>" +
                  "<p style='font-size: 18px; margin-right: 40px;'>남</p>" + 
                  "<input class='meetup_popup_user_gender_input' type='radio' name='gender' value='f'/>" +
                  "<p style='font-size: 18px;'>여</p>" + 
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

          $("#meetup_popup_user_anonymous_inputbox").change(function(){
            //console.error($(this).is(":checked"));
            if($(this).is(":checked")){
              //익명 체크하면
              $("#meetup_popup_user_nickname_input").attr("disabled",true);
              $("#meetup_popup_user_nickname_input").css('background-color', '#f7f7f7');
            }
            else{
              $("#meetup_popup_user_nickname_input").attr("disabled",false);
              $("#meetup_popup_user_nickname_input").css('background-color', 'white');
            }
            
          });

          if($("#user_gender").val())
          {
            $('input:radio[name=gender]:input[value=' + $("#user_gender").val() + ']').attr("checked", true); 
          }

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
              //console.error(request);
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

          //requestMeetupCounter();
        };
        //만나요 요청 팝업 END

        //api 를 통해 새로운 크리에이터 팝업
        var setOpenNewCreatorApiMeetupPopup = function(){
          $(".result_add_new_creator_button").click(function(){
            if(!isLogin())
            {
              loginPopup(closeLoginPopup, null);
              return;
            }

            var element = $(this);
            openNewMeetPopup(null, element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"));
          });
        };

        var setOpenMeetupPopup = function(){
          $(".result_meetup_meet_button").click(function(){
            if(!isLogin())
            {
              loginPopup(closeLoginPopup, null);
              return;
            }

            var element = $(this);
            openMeetPopup(element.attr("data_meetup_id"), element.attr("data_meetup_title"), element.attr("data_meetup_where"), element.attr("data_meetup_what"), element.attr("data_meetup_img_url"), element.attr("data_meetup_count"));
          });
        };

        var addSearchFindSuccessObject = function(){
          var element = document.createElement("li");
          element.innerHTML =
          "<div class='result_creator_wrapper'>" +
            "<div class='result_creator_find_success_title'>"+"찾았어요! 👇"+"</div>" +
          "</div>";
          
          g_creatorsSearchList.append(element);
        };

        var addSearchNoCreatorObject = function(){
          var element = document.createElement("li");
          element.innerHTML =
          "<div class='result_creator_wrapper'>" +
          
            "<div class='flex_layer' style='margin-left: 0px;'>" + 
              "<div class='result_creator_meet_more_search_title'>"+"검색값이 없네요 :( 크티가 더 찾아볼까요?"+"</div>" +
              "<button id='mannayo_search_result_find_button' class='result_creator_meet_container'>" + 
                "<span>찾아보기</span>" + 
                "<img src='{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}' style='margin-left:8px; margin-top:1px; margin-right: 24px;'/>" +
              "</button>" + 
            "</div>" +
          "</div>";
          
          g_creatorsSearchList.append(element);

          $("#mannayo_search_result_find_button").click(function(){
            youtubeGetSearchInfo();
          });
        };

        var addCreatorObject = function(creator){
          var img = "<img class='result_creator_thumbnail_img' src='"+creator.thumbnail_url+"'>";

          var element = document.createElement("li");
          element.innerHTML =
          "<div class='result_creator_wrapper'>" +
          
            "<div class='flex_layer' style='margin-left: 0px;'>" + 
              "<div class='result_creator_thumbnail_img_wrapper'>"+img+"</div>" +
              "<div class='result_creator_name'>"+creator.title+"</div>" +
              "<button data_creator_id='"+ creator.id +"' data_creator_channel_id='"+creator.channel_id+"' data_creator_title='"+ creator.title +"' data_creator_img_url='"+ creator.thumbnail_url +"' class='result_new_meet_button result_creator_meet_container flex_layer'>" + 
                "<div class='result_creator_meet_word'>"+"새 만나요 만들기"+"</div>" +
                "<div class='result_creator_meet_plus'>" + "<p>+</p>" + "</div>" +
              "</button>" + 
            "</div>" +
          "</div>";
          
          g_creatorsSearchList.append(element);
        }

        var addMeetupObject = function(meetup){
          var img = "<img class='result_creator_thumbnail_img' src='"+meetup.thumbnail_url+"'>";

          var buttonElement = 
          "<button class='result_meetup_meet_button' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"'>" + 
          "<p>만나요</p>" +
          "</button>";

          if(meetup.is_meetup)
          {
            buttonElement = 
            "<button class='result_meetup_meet_cancel_button' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"'>" + 
            "<p>만나요 요청됨</p>" +
            "</button>";
          }

          var element = document.createElement("li");
          element.innerHTML =
          "<div class='result_creator_wrapper'>" +
          
            "<div class='flex_layer' style='margin-left: 0px;'>" + 
              "<div class='result_creator_thumbnail_img_wrapper'>"+img+"</div>" +
              "<div class='result_meetup_content_container'>" + 
                "<div class='result_meetup_name'>"+meetup.title+ "과 " + meetup.where + "에서" +"</div>" + 
                "<div class='result_meetup_content text-ellipsize'>"+meetup.what+"</div>" +
              "</div>" +
              "<div class='result_meetup_meet_button_container'>" +
                buttonElement +
                //"<button class='result_meetup_meet_button' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"'>" + 
                //  "<p>만나요</p>" +
                //"</button>" + 
              "</div>" +
            "</div>" +
          "</div>";
          
          g_meetupSearchList.append(element);
        };

        var addCreatorApiObject = function(creator){
          var channelId = creator.channelId;
          var channelTitle = creator.channelTitle;
          var channelThumbnailURL = creator.thumbnails.high.url;
          var img = "<img class='result_creator_thumbnail_img' src='"+channelThumbnailURL+"'>";

          var element = document.createElement("li");
          element.innerHTML =
          "<div class='result_creator_wrapper'>" +
          
            "<div class='flex_layer' style='margin-left: 0px;'>" + 
              "<div class='result_creator_thumbnail_img_wrapper'>"+img+"</div>" +
              "<div class='result_creator_name'>"+channelTitle+"</div>" +
              "<button class='result_add_new_creator_button result_creator_meet_container flex_layer' data_creator_channel_id='"+channelId+"' data_creator_title='"+channelTitle+"' data_creator_img_url='"+channelThumbnailURL+"'>" + 
                "<div class='result_creator_meet_word'>"+"새 만나요 만들기"+"</div>" +
                "<div class='result_creator_meet_plus'>" + "<p>+</p>" + "</div>" +
              "</button>" + 
            "</div>" +
          "</div>";
          
          g_meetupSearchList.append(element);

          //$(".result_add_new_creator_button").click(function(){

          //});
        };

        var addSearchAPINoCreatorObject = function(){
          var element = document.createElement("li");
          element.innerHTML =
          "<div class='result_creator_wrapper'>" +
            "<div class='result_creator_find_success_title'>"+"없는 채널이네요. 채널 주소를 직접 입력해주세요 👇"+"</div>" +
          "</div>";
          
          g_creatorsSearchList.append(element);
        };

        var removeFooter = function(){
          g_footerContainer.children().remove();
        };

        var addFooter = function(findType){
          removeFooter();
          var element = "";

          if(findType === FIND_TYPE_IN_API)
          {
            element = document.createElement("div");
            element.innerHTML =
            "<div class='flex_layer'>" +
              "<p class='mannayo_search_result_find_label'>원하는 크리에이터가 없나요? 크티가 더 찾아볼게요</p>" +
              "<div class='mannayo_search_result_find_button_wrapper'>" +
                "<button class='mannayo_search_result_find_button'>" +
                  "<span>찾아보기</span>" +
                  "<img src='{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}' style='margin-left:8px; margin-top:1px; margin-right: 24px;'/>" +
                "</button>" +
              "</div>" +
            "</div>";
          }
          else if(findType === FIND_TYPE_IN_CHANNEL)
          {
            element = document.createElement("div");
            element.className = "mannayo_channel_search_container";
            element.innerHTML =
              "<p class='mannayo_channel_input_label'>채널주소 직접 입력하기</p>" +
              "<div class='mannayo_channel_input_wrapper'>" +
                "<div class='flex_layer'>" +
                  "<input class='mannayo_channel_input' placeholder='https://www.youtube.com/channel/UCdD6uPaV3eR95r06R1VgaAA'>" +
                  "<button id='mannayo_channel_input_button' type='button'>검색하기</button>" +
                "</div>" +
                "<p class='mannayo_channel_input_help_block'>유튜브 채널주소를 입력하면 더 정확해요!</p>" +
              "</div>";
          }

          g_footerContainer.append(element);

          $(".mannayo_search_result_find_button").click(function(){
            youtubeGetSearchInfo();
          });

          $('#mannayo_channel_input_button').click(function(){
              youtubeGetSearchChannelInfo();
          });
        };

        var setCreatorList = function(creators, list_first_type){
          removeCreatorList();

          if(list_first_type === TYPE_LIST_FIRST_CREATOR){
            for(var i = 0 ; i < creators.length ; ++i)
            {
              var creator = creators[i];
              addCreatorObject(creator);
            }

            addFooter(FIND_TYPE_IN_API);
          }
          else if(list_first_type === TYPE_LIST_FIRST_FIND_NO){
            addSearchNoCreatorObject();
            addFooter(FIND_TYPE_IN_CHANNEL);
          }
          else if(list_first_type === TYPE_LIST_FIRST_FIND_SUCCESS){
            addSearchFindSuccessObject();
            addFooter(FIND_TYPE_IN_CHANNEL);
          }
          else if(list_first_type === TYPE_LIST_FIRST_FIND_API_NO){
            addSearchAPINoCreatorObject();
            addFooter(FIND_TYPE_IN_CHANNEL);
          }

          setCreatorScrollOption();

          setOpenNewMeetPopup();
        };

        var setMeetupList = function(meetups, list_second_type){
          removeMeetupList();

          if(list_second_type === TYPE_LIST_SECOND_FIND_NO){

          }
          else{
            for(var i = 0 ; i < meetups.length ; ++i)
            {
                var meetup = meetups[i];

                if(list_second_type === TYPE_LIST_SECOND_FIND_API){
                  meetup = meetup.snippet;
                }

                if(list_second_type === TYPE_LIST_SECOND_MEETUP)
                {
                  addMeetupObject(meetup);
                }
                else if(list_second_type === TYPE_LIST_SECOND_FIND_API)
                {
                  addCreatorApiObject(meetup);
                }
            }
          }
          

          setMeetupScrollOption(list_second_type);
          setOpenMeetupPopup();
          setOpenNewCreatorApiMeetupPopup();//
        };

        var removeAllList = function(){
          removeCreatorList();
          removeMeetupList();
        };

        var requestFindCreator = function(){
          if(!$("#input_mannayo_search").val())
          {
            searchingOnOff(false);
            initSearchBar();
            return;
          }

          var url="/get/creator/find/list";
          var method = 'post';
          var data =
          {
              "title" : $("#input_mannayo_search").val()
              //"title" : "공대생"
          }
          var success = function(request) {
            searchingOnOff(false);

            //console.error(request);
            //return;
            if(request.data.length === 0)
            {
              setCreatorList(request.data, TYPE_LIST_FIRST_FIND_NO);
            }
            else
            {
              setCreatorList(request.data, TYPE_LIST_FIRST_CREATOR);
            }

            //console.error(request.meetups.length);
            if(request.meetups.length === 0)
            {
              setMeetupList(null, TYPE_LIST_SECOND_FIND_NO);
            }
            else
            {
              setMeetupList(request.meetups, TYPE_LIST_SECOND_MEETUP);
            }
          };
          
          var error = function(request) {
              swal("에러", '크리에이터를 찾지 못했습니다. 다시 시도해주세요.', 'error');
              console.error(request);
          };

          $.ajax({
          'url': url,
          'method': method,
          'data' : data,
          'success': success,
          'error': error
          });
        };

        $('#input_mannayo_search').keydown(function(){
          searchingOnOff(true);
        });

        $('#input_mannayo_search').keyup(delay(function (e) {
          requestFindCreator();
        }, 300));

        var initSearchBar = function(){
          //searchingOnOff(false);
          $("#mannayo_search_result_container").hide();
        };

        initSearchBar();
        //$("#mannayo_search_result_container").show();


        var youtubeGetSearchInfo = function(){
          searchingOnOff(true);
          var url="/search/creator/api/list";
          var method = 'post';
          var data=
          {
            'searchvalue': $("#input_mannayo_search").val()
            //'searchvalue': '공대생'
          };

          var success = function(request) {
              //console.error(request);
              //setCreatorListInApi(request.data);
              //console.error(JSON.stringify(request));
              
              if(request.data.length === 0){
                setCreatorList(null, TYPE_LIST_FIRST_FIND_API_NO);
                setMeetupList(request.data, TYPE_LIST_SECOND_FIND_API);
              }
              else{
                setCreatorList(null, TYPE_LIST_FIRST_FIND_SUCCESS);
                setMeetupList(request.data, TYPE_LIST_SECOND_FIND_API);
              }

              searchingOnOff(false);
          };

          var error = function(request) {
              //swal("에러", '크리에이터를 찾지 못했습니다. 다시 시도해주세요.', 'error');
              stopLoadingPopup();
              console.error(request);
          };

          $.ajax({
            'url': url,
            'method': method,
            'data' : data,
            'success': success,
            'error': error
          });
        };

        var youtubeGetSearchChannelInfo = function(){
          if(!$(".mannayo_channel_input").val())
          {
            swal("채널 정보를 입력해주세요.", "", "info");
            return;
          }

          searchingOnOff(true);

          var url="/search/creator/crolling/info";
          var method = 'post';
          var data =
          {
              "url" : $(".mannayo_channel_input").val()
          }
          var success = function(request) {
            if(request.data.length === 0){
                setCreatorList(null, TYPE_LIST_FIRST_FIND_API_NO);
                setMeetupList(request.data, TYPE_LIST_SECOND_FIND_API);
            }
            else{
              setCreatorList(null, TYPE_LIST_FIRST_FIND_SUCCESS);
              setMeetupList(request.data, TYPE_LIST_SECOND_FIND_API);
            }

            searchingOnOff(false);            
          };
          
          var error = function(request) {
              swal("에러", '크리에이터를 찾지 못했습니다. 다시 시도해주세요.', 'error');
              console.error(request);
          };

          $.ajax({
          'url': url,
          'method': method,
          'data' : data,
          'success': success,
          'error': error
          });
        };

        //만나요 팝업 start
        //만나요 팝업 end

        //만나요 따로 분리
        var removeSearchBar = function(targetElement){
          $(targetElement).children().remove();
        }

        var addSearchBar = function(targetElement){
          var element = document.createElement("div");
          element.innerHTML =
          "<div class='mannayo_search_container'>" +
              "<div class='mannayo_search_input_container'>" +
                "<div class='flex_layer'>" +
                  "<div class='input_mannayo_search_img'><img src='{{ asset('/img/icons/svg/ic-search-wh.svg') }}' style='width: 24px; height: 24px; margin-top: 19px;'/></div>" +
                  "<input type='text' id='input_mannayo_search' placeholder='크리에이터 검색' />" +
                "</div>" +
              "</div>" +

              "<div class='mannayo_searching_loading_container'>" +
                "<p class='searching'><span>.</span><span>.</span><span>.</span><span>.</span></p>" +
              "</div>" +

              "<div id='mannayo_search_result_container'>" +
                //<!-- 검색 안에 내용 start -->
                //<!-- 크리에이터 검색 결과 START -->
                "<div class='mannayo_search_result_ul_container'>" +
                  "<div class='mannayo_search_result_ul_wrapper'>" +
                    "<ul id='mannayo_search_result_ul'>" +
                    "</ul>" +
                  "</div>" +
                  
                  "<div class='mannayo_result_ul_gradation'>" +
                  "</div>" +
                "</div>" +
                //<!-- 크리에이터 검색 결과 END -->

                //<!-- 이미 만나요 검색 결과 START -->
                "<div class='mannayo_search_result_line'>" +
                "</div>" +
                "<p class='mannayo_search_result_ready_label'>이미 있는 만나요</p>" +
                "<div class='mannayo_search_result_ready_ul_container'>" +
                  "<div class='mannayo_search_result_ready_ul_wrapper'>" +
                    "<ul id='mannayo_search_result_ready_ul'>" +
                    "</ul>" +
                  "</div>" +
                  
                  "<div class='mannayo_result_ul_gradation'>" +
                  "</div>" +
                "</div>" +
                //<!-- 이미 만나요 검색 결과 END -->
                "<div class='mannayo_search_result_find_container'>" +
                "</div>" +
                //<!-- 검색 안에 내용 end -->
              "</div>" +
          "</div>";

          if($(targetElement)){
            $(targetElement).append(element);
          }
        };

        //하단 리스트 START
        var requestMannayoList = function(){
          var url="/mannayo/list";
          var method = 'get';
          var data =
          {
            "sort_type" : SORT_TYPE_NEW
          }
          var success = function(request) {
            console.error(request);
          };
          
          var error = function(request) {
            alert('크리에이터 정보 가져오기 실패. 다시 시도해주세요.');
            
            console.error(request);
          };
          
          $.ajax({
          'url': url,
          'method': method,
          'data' : data,
          'success': success,
          'error': error
          });
        };

        requestMannayoList();
        //하단 리스트 END
      });
    </script>
    
@endsection