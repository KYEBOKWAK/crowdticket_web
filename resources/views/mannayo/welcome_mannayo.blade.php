@extends('app')
@section('meta')
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="크라우드티켓"/>
    <meta property="og:description" content="크리에이터에게 만나요를 요청해보세요!"/>
    <meta property="og:image" content="{{ asset('/img/app/og_image_2.png') }}"/>
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

        .mannayo_search_container_popup{
          position: absolute;
          top: 0;
          width: 100%;
          z-index: 1000;
        }

        .mannayo_search_container_target{
          position: absolute;
          width: 520px;
          left: 50%;
          top: 288px;
          transform:translate(-50%, 0);
          z-index: 10000;
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

        .input_mannayo_search_img_popup{
          height: 56px;
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

        #input_mannayo_search::-ms-input-placeholder { 
          color: white;
          opacity: 0.5;
          margin-left: 140px;
        }
        #input_mannayo_search::-webkit-input-placeholder { 
          color: white;
          opacity: 0.5;
          margin-left: 140px;
        } 
        #input_mannayo_search::-moz-placeholder { 
          color: white;
          opacity: 0.5;
          margin-left: 140px;
        }

        .input_mannayo_search_popup{
          font-size: 16px !important;
          /*padding-left: 62px !important;*/
          text-align: left !important;
          height: 56px !important;
          color: black !important;
        }

        #mannayo_search_result_container{
          display: none;
          width: 100%;
          background-color: white;
          border-radius: 10px;
          text-align: left;
          box-shadow: 4px 4px 30px 0 rgba(0, 0, 0, 0.1);
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

        .mannayo_searching_loading_container_popup{
          height: 50px;
        }

        .mannayo_searching_loading_container span{
          font-size: 50px;
        }

        .mannayo_searching_loading_container_popup span{
          font-size: 30px;
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
          margin-left: 0px;
          position: relative;
        }

        .result_creator_thumbnail_img_wrapper_popup{
          margin: 14px 20px;
          margin-left: 0px;
        }

        .result_creator_meet_more_search_title{
          font-size: 17px;
          color: #4d4d4d;
          /*margin-top: 17px;*/
          /*margin-left: 20px;*/
          margin-left: 0px;
          padding-right: 0px;
        }

        .result_creator_meet_more_search_title_popup{
          font-size: 12px;
          margin-top: 0px;
          margin-left: 0px;
        }

        .result_creator_thumbnail_img{
          width: 52px;
          height: 52px;
          border-radius: 100%;
        }

        .result_creator_thumbnail_img_popup{
          width: 36px;
          height: 36px;
        }

        .result_creator_name{
          font-size: 20px;
          color: #4d4d4d;
          margin-top: auto;
          margin-bottom: auto;
        }

        .result_creator_name_width{
          width: 210px;
        }

        .result_creator_name_in_main{
          width: 230px;
        }

        .result_creator_name_popup{
          font-size: 16px;
          margin-top: auto;
        }

        li { list-style: none }
        ul { 
          padding: 0;
          margin-bottom: 0px;
        }

        .result_creator_wrapper{
          /*height: 76px;*/
          /*padding-top: 5px;*/
          position: relative;
          padding: 0px 20px;
        }

        .result_creator_wrapper_main{
          width: 520px;
          height: 100px;
        }
/*
        .result_meetup_container:hover{
          background-color: #f7f7f7;
        }
*/
        .result_creator_meet_container{
          margin-left: auto;
          border: 0;
          background-color: rgba(255, 255, 255, 0);
          padding-right: 0px;
        }

        .result_creator_meet_word{
          font-size: 16px;
          color: #acacac;
          margin-right: 12px;
          margin-top: auto;
          margin-bottom: auto;
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
          position: relative;
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

        .mannayo_search_result_find_button_popup{
          text-align: left;
          height: auto;
          font-size: 10px;
        }

        .mannayo_search_result_find_button_wrapper{
          width: 143px;
          text-align: right;
          padding-top: 3px;
          margin-top: auto;
          margin-bottom: auto;
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
          /*width: 476px;*/
          padding-left: 20px;
          margin: 0px auto;
          text-align: left;
        }

        .mannayo_search_result_ready_ul_container{
          position: relative;
        }

        .mannayo_search_result_line{
          /*width: 476px;*/
          width: 91%;
          height: 1px;
          opacity: 0.2;
          background-color: #acacac;
          margin: 16px auto;
          margin-top: 0px;
        }

        .result_meetup_meet_button{
          width: 95%;
          height: 70%;
          position: absolute;
          top: 0;
          left: 0;
          opacity: 0;
          /*
          width: 85px;
          height: 40px;
          font-size: 16px;
          border-radius: 21px;
          border: 0.8px solid #acacac;
          color: #acacac;
          */
        }

        .result_meetup_meet_button_popup{
          width: 95%;
          height: 70%;
          position: absolute;
          top: 0;
          left: 0;
          opacity: 0;
        }

        .result_meetup_content_container{
          /*width: 320px;*/
          width: 100%;
          padding-top: 14px;
          text-align: left;
        }

        .result_meetup_content_container_popup{
          padding-top: 10px;
        }

        .result_meetup_name{
          font-size: 18px;
          color: #4d4d4d;
        }

        .result_meetup_name_popup{
          font-size: 16px;
        }

        .result_meetup_content{
          /*width: 280px;*/
          font-size: 14px;
          line-height: 1.57;
          color: #acacac;
        }

        .result_meetup_content_popup{
          font-size: 12px;
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

        .mannayo_channel_input_label_popup{
          font-size: 12px;
        }

        .mannayo_channel_input{
          width: 100%;
          height: 40px;
          border-radius: 5px;
          border: 1px solid #e6e6e6;
        }

        .mannayo_channel_input::-ms-input-placeholder{
          color: #acacac;
          padding-left: 16px;
        }
        .mannayo_channel_input::-webkit-input-placeholder{
          color: #acacac;
          padding-left: 16px;
        }
        .mannayo_channel_input::-moz-placeholder{
          color: #acacac;
          padding-left: 16px;
        }

        .mannayo_channel_input_popup{
          height: 28px;
        }

        .mannayo_channel_input_popup::-ms-input-placeholder { 
          font-size: 10px;
        }
        .mannayo_channel_input_popup::-webkit-input-placeholder { 
          font-size: 10px;
        } 
        .mannayo_channel_input_popup::-moz-placeholder { 
          font-size: 10px;
        }

        .mannayo_channel_input_in_main{
          width: 100%;
          height: 40px;
        }

        .mannayo_search_result_find_label{
          font-size: 17px;
          color: #4d4d4d;
          margin-bottom: 0px;
          margin-left: 20px;
          /*margin-top: 38px;*/
          margin-top: 0px;
        }

        .mannayo_search_result_find_label_popup{
          font-size: 12px;
          margin-top: 0px;
          text-align: left;
          margin-left: 0px;
        }

        .mannayo_search_result_footer_wrapper_popup{
          height: 75px;
          text-align: left;
          line-height: 1.0;
          padding: 20px;
          position: relative;
        }

        .mannayo_search_result_find_fake_button{
          width: 100%;
          height: 100%;
          border: 0;
          position: absolute;
          top: 0;
          left: 0;
          z-index: 100;
          opacity: 0;
        }

        .mannayo_channel_search_container{
          padding: 20px;
        }

        .mannayo_channel_search_container_in_main{
          height: auto;
          padding: 10px 10px;
          text-align: left;
        }

        .mannayo_channel_input_help_block{
          font-size: 12px;
          color: #acacac;
          margin-top: 8px;
        }

        .mannayo_channel_input_help_block_popup{
          font-size: 10px;
        }

        .result_creator_find_success_title{
          padding-top: 24px;
          font-size: 17px;
          margin-left: 20px;
        }

        .result_creator_find_success_title_popup{
          font-size: 12px;
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
          margin-left: auto;
        }

        .swal-content{
          margin-top: 40px;
          margin-bottom: 40px;
        }

        .meetup_popup_option_img{
          width: 36px;
          height: 36px;
          margin-left: 20px;
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
          color: #4d4d4d;
        }

        .meetup_popup_title_container>h3{
          font-size: 16px;
          font-weight: 500;
          margin-bottom: 0px;
        }

        select{
            width: 100%;
            height: 100%;
            -webkit-appearance: menulist-button;
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
          margin-left: 20px;
          /*margin-right: 95px;*/
          margin-right: auto;
        }

        .meetup_popup_option_wrapper{
          margin-top: 12px; 
        }

        #meetup_popup_option_what_input{
          width: 100%;
          height: 100%;
          border-radius: 5px;
          border: 1px solid #e6e6e6;
          text-align: left;
          padding-left: 20px;
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
          text-align: left;
        }
        #meetup_popup_option_what_input::-webkit-input-placeholder { 
          color: #e6e6e6;
          text-align: left;
        } 
        #meetup_popup_option_what_input::-moz-placeholder { 
          color: #e6e6e6;
          text-align: left;
        }

        #meetup_popup_option_comment_input{
          width: 100%;
          height: 100%;
          border-radius: 5px;
          border: 1px solid #e6e6e6;
          text-align: left;
          padding-left: 20px;
        }

        #meetup_popup_option_comment_input::-ms-input-placeholder { 
          color: #e6e6e6;
          text-align: left;
        }
        #meetup_popup_option_comment_input::-webkit-input-placeholder { 
          color: #e6e6e6;
          text-align: left;
        } 
        #meetup_popup_option_comment_input::-moz-placeholder { 
          color: #e6e6e6;
          text-align: left;
        }

        .meetup_popup_option_comment_input_wrapper{
          width: 100%;
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
          color: #4d4d4d;
        }

        .meetup_popup_user_options_container{
          text-align: left;
        }

        .meetup_checkbox_wrapper{
          position: relative;
        }

        .meetup_checkbox_img{
          display: none;
          position: absolute;
          top: 3px;
          left: 0px;
        }

        .meetup_checkbox_img_unselect{
          display: block;
        }

        #meetup_popup_user_anonymous_inputbox{
          opacity: 0;
          position: relative;
          z-index: 100;
          bottom: 4px;
        }

        .meetup_radio_wrapper{
          position: relative;
        }

        .meetup_radio_img{
          display: none;
          position: absolute;
          top: 3px;
          left: 0px;
        }

        .meetup_radio_img_unselect{
          display: block;
        }

        .meetup_popup_user_anonymous_inputbox[type="checkbox"]{
          /*display: none;*/
          width: 16px;
          margin-right: 8px;
          margin-top: 2px;
        }

        .meetup_popup_user_gender_input[type="radio"]{
          width: 20px;
          margin-right: 0px;
          position: relative;
          opacity: 0;
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

        #meetup_callyou_popup_option_contact_input::-ms-input-placeholder { 
          color: #acacac;
        }
        #meetup_callyou_popup_option_contact_input::-webkit-input-placeholder { 
          color: #acacac;
        } 
        #meetup_callyou_popup_option_contact_input::-moz-placeholder { 
          color: #acacac;
        }

        #meetup_callyou_popup_option_email_input{
          background-color: #f7f7f7;
          color: #acacac;
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
          border: 0;
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
          margin-bottom: 16px;
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
          display: none;
          /*margin-top: 130px;*/
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

        .mannayo_create_button{
          position:absolute;
          border: 0;
          width: 100%;
          top:0;
          left:0;
          right:0;
          bottom:0;
          max-width:100%;
          margin: auto;
          border-radius: 10px;
          background-color: #43c9f0;
        }

        .mannayo_create_button>p{
          width: 171px;
          font-size: 32px;
          font-weight: bold;
          line-height: 1.25;
          color: white;
          margin-left: auto;
          margin-right: auto;
          margin-top: 12px;
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
          border-radius: 10px;
        }

        .meetup_users_profile_img{
          width: 16px; 
          height: 16px; 
          border-radius: 100%; 
          margin-left: -4px;
          position: relative;
        }

        .mannayo_thumb_content_container{
          font-size: 12px;
          color: #808080;
          word-break: break-all;
        }

        .mannayo_thumb_container{
          width: 250px;
          margin-bottom: 40px;
          position: relative;
        }

        .mannayo_list_loading_container{
          text-align: center;
          font-size: 40px;
        }

        .mannayo_list_more_wrapper{
          display: none;
          text-align: center;
        }

        .mannayo_list_more_button{
          width: 140px;
          height: 56px;
          border: 0;
          border-radius: 28px;
          background-color: #f7f7f7;
          font-size: 20px;
          font-weight: 500;
          color: #808080;
        }

        .mannayo_flex_second_object{
          margin-left: 20px;
        }

        .mannayo_thumb_title_wrapper{
          margin-top: 20px;
          font-size: 16px;
          font-weight: bold;
        }

        .mannayo_thumb_content_container{
          font-size: 12px;
          color: #808080;
          margin-top: 8px;
        }

        .mannayo_thumb_button_wrapper{
          margin-top: 16px;
        }

        .mannayo_thumb_meetup_button_fake{
          width: 79px;
          height: 44px;
          border-radius: 5px;
          background-color: #f7f7f7;
          border: 0;
          font-size: 14px;
          font-weight: 500;
          color: #4d4d4d;
        }

        .mannayo_thumb_meetup_cancel_button_fake{
          width: 121px;
          height: 44px;
          border-radius: 5px;
          background-color: #43c9f0;
          border: 0;
          font-size: 14px;
          font-weight: 500;
          color: white;
        }

        .mannayo_thumb_meetup_button{
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          opacity: 0;
        }

        .mannayo_thumb_meetup_cancel_button{
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          opacity: 0;
        }

        .mannayo_search_cancel_button{
          width: 95%;
          height: 70%;
          position: absolute;
          top: 0;
          left: 0;
          opacity: 0;
        }

        .meetup_popup_option_creator_info_target{
          width: 327px;
          position: relative;
        }

        .mannayo_search_result_container_popup{
          box-shadow: 4px 4px 30px 0 rgba(0, 0, 0, 0.1);
        }

        .mannayo_search_input_container_popup{
          border-radius: 5px;
          border: solid 1px #e6e6e6;
        }

        #meetup_popup_option_user_cancel_button{
          position: absolute;
          right: 0;
          height: 100%;
          width: 60px;
          background-color: rgba(255, 255, 255, 0);
          border: 0;
          z-index: 100;
          opacity: 0.5;
        }

        #meetup_cancel_button{
          /*margin-top: 40px;*/
          width: 380px;
          height: 56px;
          border: 0;
          border-radius: 5px;
          background-color: #f7f7f7;
          font-size: 20px;
          font-weight: 500;
          color: #808080;
        }

        .mannayo_is_meetup_thumb_mask{
          width: 100%;
          height: 100%;
          position: absolute;
          top: 0;
          border-radius: 100%;
          background-color: rgba(67, 201, 240, 0.3);
        }

        .mannayo_is_meetup_thumb_mask_check_img{
          position: absolute;
          bottom: 0;
          right: 0; 
        }

        .mannayo_is_meetup_thumb_mask_check_img_popup{
          width: 14px;
        }

        .swal-footer{
          text-align: center !important;
        }

        .swal-button{
          background-color: #43c9f0 !important;
        }

        .mannayo_alert_popup{
          width: 400px;
        }

        .meetup_popup_cancel_callback{
          margin-top: 40px;
          font-size: 16px;
          color: #4d4d4d;
        }

        .meetup_popup_cancel_callback_ok{
          width: 165px;
          height: 56px;
          border-radius: 5px;
          background-color: #43c9f0;
          font-size: 20px;
          font-weight: 500;
          color: white;
          border: 0;
        }

        .mannayo_creator_list_container{
          display: none;
          margin-top: 64px;
        }

        .mannayo_creator_list_title{
          display: none;
          font-size: 24px;
          color: #000000;
        }

        .mannayo_creator_list{
          margin-top: 32px;
        }

        .mannayo_search_result_find_container_main{
          display: none;
          height: 100px;
          border-radius: 10px;
          background-color: #f7f7f7;
          text-align: center;
          /*margin-top: 24px;*/
          margin-top: 64px;
          position: relative;
        }

        .mannayo_search_result_find_wrapper{
          width: 530px;
          margin-left: auto;
          margin-right: auto;
          height: 100%;
        }

        .mannayo_no_creator_list_container{
          display: none;
          margin-top: 64px;
          text-align: center;
          margin-bottom: 64px;
        }

        .mannayo_no_creator_list_container>p{
          margin-top: 24px;
          font-size: 24px;
          color: #acacac;
        }

        .mannayo_no_creator_list_in_api_container{
          display: none;
          margin-top: 64px;
          text-align: center;
          margin-bottom: 64px;
        }

        .mannayo_no_creator_list_in_api_container>p{
          margin-top: 24px;
          font-size: 24px;
          color: #acacac;
        }

        .mannayo_sort_select{
          opacity:0;
          position: relative;
          z-index: 1000;
        }

        .mannayo_sort_fake_text_container{
          position: absolute;
          width: 100%;
          padding: 0px 16px;
          margin-top: 14px;
        }

        .mannayo_sort_container{
          width: 160px;
          height: 52px;
          position: relative;
          margin-left: auto;
          border-radius: 5px;
          background-color: #f7f7f7;
          font-size: 16px;
          margin-top: 50px;
          margin-bottom: 28px;
        }

        .mannayo_thumb_object_container_in_main{

        }

        .mannayo_search_result_find_more_img{
          margin-left:8px; 
          margin-top:1px; 
          margin-right: 24px;
        }

        .meetup_popup_user_anonymous_text{
          font-size: 14px;
        }

        .meetup_popup_user_options_container>p{
          font-size: 12px;
          color: #808080;
        }

        .meetup_popup_user_option_gender_text{
          font-size: 18px !important;
          margin-left: 12px;
        }

        #mannayo_channel_input_button{
          width: 66px;
          height: 40px;
          border-radius: 5px;
          background-color: #acacac;
          font-size: 14px;
          font-weight: 500;
          color: white;
          border: 0;
        }

        .mannayo_channel_input_button_popup{
          width: 39px !important;
          height: 28px !important;
          font-size: 12px !important;
          font-weight: 500 !important;
        }

        .result_creator_plus_img_pop{
          width: 24px;
          height: 24px;
          margin-top: auto;
          margin-bottom: auto;
        }

        .meetup_callyou_popup_container{
          width: 100%;
        }

        .popup_call_meetup{
          width: 400px;
          padding: 0px 20px;
        }

        .search_img{
          width: 24px; 
          height: 24px; 
          margin-top: 19px;
          opacity: 0.5;
        }

        .search_img_popup{
          width: 24px;
          height: 24px; 
          margin-top: 16px;
        }

        .mannayo_title_text_pc{
          display: block;
        }

        .mannayo_title_text_mobile{
          display: none;
        }

        .result_creator_meet_container_popup{
          /*margin-top: -48px !important;*/
        }

        .meetup_popup_option_label_creator_what{
          
        }

        .result_object_button_fake{
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          opacity: 0;
        }

        .mannayo_search_no_creator_object_container{
          height: auto;
        }

        .mannayo_search_result_find_container_container{
          padding-top: 40px;
        }

        .mannayo_search_result_find_label_fix{
          margin-top: auto;
          margin-bottom: auto;
        }

        .mannayo_search_result_find_button_fix{
          height: auto;
        }

        .mannayo_youtube_crolling_info_container{
          display: none;
        }

        .mannayo_youtube_crolling_info_container_main{
          font-size: 24px;
          padding-top: 40px;
          color: #acacac;
        }

        .mannayo_youtube_crolling_info_container_search{
          font-size: 17px;
          color: #4d4d4d;
          padding-top: 10px;
        }

        .mannayo_youtube_crolling_info_container_popup{
          font-size: 12px;
          color: #4d4d4d;
        }

        .mannayo_thumb_user_list_thumb_button{
          width: 110%;
          height: 110%;
          position: absolute;
          top: 0;
          left: 0;
          z-index: 1000;
          opacity: 0;
        }

        .mannayo_thumb_user_name_container{
          display: none;
          position: relative;
        }

        .mannayo_thumb_user_name_ul_container{
          position: absolute;
          background-color: #4d4d4d;
          border-radius: 5px;
          text-align: left;
          top: 0;
          right: 0;
          width: 74px;
          max-height: 99px;
          z-index: 100;
          padding: 5px;
          font-size: 12px;
          color: white;
        }

        .mannayo_thumb_user_container_arrow{
          position: absolute;
          width: 10px;
          height: 10px;
          background-color: #4d4d4d;
          top: -5px;
          right: 15px;
          transform: rotate(45deg);
          -webkit-transform: rotate(45deg);
        }

        .mannayo_popup_tab_button{
          /*width: 78px;*/
          font-weight: 500;
          text-align: center;
          /*line-height: 20px;*/
          font-size: 16px;
          color:#acacac;
          border-radius: 0;
          margin: 0;
          margin-right: 16px;
          background-color: white;
          border: 0;
          padding: 0;
          padding-bottom: 6px;
          cursor:pointer
        }

        .mannayo_popup_tab_button_active{
          color: black;
          border-bottom: 2px solid #43c9f0;
        }

        .meetup_popup_container_wrapper{
          padding: 0px 20px;
        }

        .popup_close_button_meetup_popup{
          padding: 0px;
          border: 0;
          background-color: white;
        }

        .mannayo_popup_tab_title_right_wrapper{
          margin-left: auto;
        }

        .mannayo_popup_tab_counter_text{
          font-size: 12px;
          margin-left: 4px;
          margin-top: 2px;
          color: #43c9f0;
        }

        .mannayo_meetup_popup_users_searching_wrapper>p{
          font-size: 50px;
        }

        .result_creator_wrapper_user_object{
          padding: 0px;
        }

        .mannayo_meetup_popup_users_container{
          margin-top: 20px;
        }

        .result_creator_thumbnail_img_user_object{
          width: 50px;
          height: 50px;
        }

        .result_creator_thumbnail_img_wrapper_user_object{
          margin: 16px 20px;
          margin-left: 0px;
        }

        .result_creator_name_user_object{
          font-size: 16px;
        }

        .result_user_thumbnail_line{
          opacity: 0.2;
          border: 1px solid #acacac;
        }

        .mannayo_meetup_popup_comments_container{
          margin-top: 20px;
        }

        .mannayo_comments_button{
          margin-top: 10px;
          padding: 10px 20px;
          font-size: 14px;
          font-weight: 400;
          background-color: #43c9f0 !important;
          border-color: #43c9f0 !important;
          border: 0;
        }

        .mannayo_comments_button:hover{
          background-color: #43c9f0;
          border-color: #43c9f0;
        }
        .mannayo_comments_button:active{
          background-color: #43c9f0;
          border-color: #43c9f0;
        }

        .user-photo-comment{
          width: 50px;
          height: 50px;
        }

        .comment-list{
          text-align: left;
        }

        .comment-section-right{
          margin-top: 0px !important;
          font-size: 12px;
        }

        .toggle-reply{
          color: #43c9f0;
          font-weight: bold;
          margin-right: 5px;
        }

        .mannayo_meetup_popup_comments_ul_wrapper{
          height: 570px;
        }

        .loading_size_20{
          margin-left: 10px;
          border: 3px solid rgba(67, 201,240,.3);
          border-top-color: #43c9f0;
        }

        .button-comments-comment{
          background-color: #43c9f0;
          border-color: #43c9f0;
        }

        .button-comments-comment:hover{
          background-color: #43c9f0;
          border-color: #43c9f0;
        }

        .delete-comment{
          cursor:pointer; 
        }

        .delete-comment-fake{
          
        }
        .delete-comment-real{
          display: none;
          margin-right: 10px;
        }

        /*취소 팝업 css start*/
        .meetup_popup_thumb_container_cancel{
          margin-top: 110px;
        }

        .meetup_popup_content_container_cancel{
          margin-top: 20px;
        }

        .meetup_popup_meet_count_container_cancel{
          margin-top: 28px;
        }

        .meetup_popup_meet_count_container_cancel>p{
          margin-top: 4px;
        }

        .meetup_new_button_wrapper{
          margin-top: 28px;
        }

        .meetup_new_button_wrapper_cancel{
          margin-top: 173px;
        }

        .meetup_cancel_button{
          /*margin-top: 173px !important;*/
        }

        
        /*취소 팝업 css end*/

        .comments_length_text{
          text-align: right;
          font-size: 11px;
          color: #aaa;
        }

        .comments_comment_length_text{
          text-align: right;
          font-size: 11px;
          color: #aaa;
        }

        .meetup_popup_option_creator_what_wrapper{
          width: 254px;
        }

        .welcome_content_title{
          width: 100%;
          font-size: 24px;
          margin-bottom: 32px;
        }

        .thumb_container_is_mobile{
          margin-right: 20px;
        }

        .mannayo_creator_pop_list_title{
          font-size: 24px;
        }

        .mannayo_sort_fake_text_container>img{
          margin-left: auto;
        }

        .mannayo_creator_list_title_searching{
          margin-bottom: 48px;
          margin-top: 12px;
        }

        @media (max-width:1060px) {
          .mannayo_list_container{
            margin-top: 0px !important;
          }

          .mannayo_creator_list_title_searching{
            margin-bottom: 0px;
          }

          #mannayo_sort_fake_text{
            margin-left: auto;
          }

          .mannayo_sort_fake_text_container>img{
            margin-left: 8px;
          }

          .mannayo_creator_pop_list_title{
            padding-left: 5px;
          }
          .welcome_content_title{
            padding-left: 5px;
          }
          .thumb_container_is_mobile{
            margin-right: 0px;
            margin-bottom: 24px;
          }

          .mannayo_creator_list_title{
            margin-left: 19px;
          }

          .mannayo_no_creator_list_in_api_container{
            margin-top: 40px;
          }

          .mannayo_no_creator_list_container{
            margin-top: 40px;
          }
          .mannayo_creator_list_container{
            margin-top: 40px;
          }
          .mannayo_search_result_find_container_main{
            margin-top: 40px;
            margin-left: auto;
            margin-right: auto;
            width: 90%;
          }
          .welcome_start_content_container{
            margin-left: 13%;
            width: 70%;
          }

          .mannayo_flex_second_object{
            margin-left: 0px;
          }

          .result_creator_wrapper_main{
            width: 100%;
          }

          .mannayo_sort_container{
            /*margin-right: auto;*/
            margin-top: 41px;
            background-color: white;
          }

          .mannayo_thumb_object_container_in_main{
            flex-basis: 50%;
            margin: 0px 5px;
          }

          .mannayo_thumb_container{
            width: 100%;
          }

          .mannayo_thumb_img_wrapper{
            width: 100%;
            max-width: 100%;
          }

          .mannayo_meetup_list_container{
            padding: 0px 5px;
          }

          .mannayo_search_result_find_label_fix{
            margin-left: 0px;
            padding-top: 25px;
          }

          .mannayo_search_result_find_button_wrapper_in_main{
            margin-left: auto;
            margin-right: auto;
          }

          .mannayo_search_result_find_button_fix{
            width: 100px;
          }
        }

        @media (max-width:1030px) {
          .result_creator_meet_more_search_title{
            font-size: 12px;
            margin: 0;
            margin-top: 17px;
            color: #808080;
          }

          .mannayo_search_result_find_button_wrapper{
            width: 105px; 
          }

          .mannayo_search_result_find_container_container{
            padding-top: 25px;
          }
        }

        @media (max-width:720px) {
          .popup_close_button_wrapper{
            top: 20px;
            right: 20px;
          }
        }

        @media (max-width:650px) {
          .welcome_content_container{
            width: 100% !important;
          }
        }

        @media (max-width:650px) {
          
        }

        /*@media (max-width:320px) {*/
        @media (max-width:650px) {
          .mannayo_creator_list_title_searching{
            margin-bottom: 0px;
            margin-top: 50px;
          }

          .swal-content{
            margin-top: 20px;
          }
          .mannayo_search_container_target{
            width: 100%;
            padding: 0px 20px;
            /*top: 132px;*/
            top: 271px;
          }

          .mannayo_title_background{
            height: 323px;
            background-image: linear-gradient(to right, #9f83fa, #c72ffd 34%, #e891b7 82%, #f7948f);
          }
          
          .mannayo_title_background p{
            width: 300px;
            font-size: 20px;
            font-weight: 500;
            padding-top: 72px;
            margin-left: auto;
            margin-right: auto;
          }

          .mannayo_sort_container{
            margin-top: 40px !important;
            margin-bottom: 24px;
          }

          .mannayo_create_button>p{
            width: 100%;
            font-size: 20px;
            line-height: 1.2;
          }

          .mannayo_peace_img{
            width: 52px;
          }

          .mannayo_thumb_title_wrapper{
            font-size: 14px;
            font-weight: 500;
            line-height: 1.36;
            margin-top: 12px;
          }

          .mannayo_thumb_content_container{
            margin-top: 4px;
          }

          .mannayo_list_more_button{
            font-size: 16px;
            font-weight: normal;
            color: #808080;
          }

          #input_mannayo_search{
            font-size: 20px;
          }

          .result_creator_thumbnail_img_wrapper{
            margin-right: 8px;
            margin-top: 16px;
            margin-bottom: 16px;
          }

          .result_creator_thumbnail_img{
            width: 36px;
            height: 36px;
          }
          
          .result_creator_name{
            width: 100%;
            font-size: 16px;
          }

          .result_meetup_name{
            font-size: 14px;
            line-height: 1.29;
          }

          .result_meetup_content{
            font-size: 12px;
            line-height: 1.5;
          }

          .result_meetup_content_container{
            padding-top: 18px;
          }

          .mannayo_search_result_find_label{
            font-size: 12px;
            color: #808080;
            margin-top: 0px;
            padding-top: 17px;
            margin-left: auto;
            margin-right: auto;
          }

          .mannayo_search_result_find_container{
            text-align: center;
          }

          .mannayo_search_result_find_button_wrapper{
            margin-left: auto;
            margin-right: auto;
            /*margin-top: -20px;*/
            text-align: center;
            padding: 0;
          }

          .mannayo_search_result_find_button{
            font-size: 10px;
            color: #808080;
            text-align: center;
            height: 55px;
          }

          .mannayo_search_result_find_more_img{
            width: 5px;
            margin-left: 3px;
            margin-top: -2px;
          }

          .ss-content{
            width: 100% !important;
          }

          .mannayo_search_result_ul_wrapper{
            max-height: 234px;
          }

          .result_creator_find_success_title{
            margin-left: 0px;
            font-size: 12px;
            text-align: center;
            color: #808080;
          }

          .mannayo_channel_search_container{
            padding: 16px 20px;
            text-align: left;
          }

          .mannayo_channel_input_label{
            font-size: 12px;
            color: #1a1a1a;
          }

          .mannayo_channel_input{
            height: 28px;
          }

          .mannayo_channel_input_help_block{
            font-size: 10px;
          }

          .blueprint_popup{
            width: 100%;
            position: absolute;
            top:0;
            left:0;
            margin-top: 0px;
          }

          .meetup_popup_container{
            width: 100%;
          }

          .meetup_popup_option_creator{
            width: 100%;
          }

          .meetup_popup_option_label{
            font-size: 14px;
            color: #808080;
          }

          .meetup_popup_option_label_creator_input{
            width: 40px;
            margin-left: auto;
          }

          .meetup_popup_option_creator_info_target{
            width: 90%;
          }

          .meetup_popup_user_label{
            font-size: 14px;
            margin-right: 46px;
            color: #808080;
          }

          .meetup_popup_user_nickname_input{
            font-size: 16px;
          }

          .meetup_popup_user_anonymous_text{
            font-size: 12px;
          }

          .meetup_popup_user_options_container>p{
            /*font-size: 14px;*/
          }

          .meetup_popup_title_container>h2{
            opacity: 0.7;
            font-size: 16px;
            font-weight: 500;
          }

          .meetup_popup_title_container>p{
            font-size: 14px;
            line-height: 1.57;
          }

          .meetup_popup_content_container{
            font-size: 20px;
            color: #4d4d4d
          }

          .meetup_popup_content_point_color{
            font-size: 20px;
            font-weight: 500;
          }

          .meetup_count_loading_container>p{
            font-size: 14px;
            font-weight: 500;
            line-height: 1.29;
          }

          #meetup_cancel_button{
            width: 100%;
          }

          .popup_call_meetup{
            width: 90%;
            padding: 0px 12px;
          }

          .meetup_callyou_popup_title{
            font-size: 14px;
          }

          .mannayo_title_text_pc{
            display: none;
          }

          .mannayo_title_text_mobile{
            display: block;
          }

          .result_creator_meet_container{
            /*margin-top: -40px;*/

            /*height: 30px;*/
            padding: 0;
          }

          #mannayo_channel_input_button{
            height: 29px;
          }

          .result_creator_meet_word{
            display: none;
          }

          .result_creator_plus_img{
            width: 24px;
            height: 24px;
            margin-top: auto;
            margin-bottom: auto;
          }

          .result_creator_wrapper{
            padding: 0px 16px;
          }

          .mannayo_alert_popup{
            width: 90%;
          }

          .mannayo_search_no_creator_object_container{
            padding: 0px 10px;
          }

          .mannayo_search_no_creator_title{
            padding-top: 22px;
          }

          .mannayo_search_result_find_container_container{
            padding-top: 20px;
          }

          .mannayo_search_result_find_wrapper{
            width: 100%;
          }

          .mannayo_search_result_find_label_fix{
            padding-top: 30px;
          }

          .mannayo_popup_tab_button{
            font-size: 14px;
          }

          .result_creator_name_user_object{
            text-align: left;
            padding-left: 20px;
          }

          .reply-button{
            margin-top: 70px !important;
          }

          .meetup_new_button_wrapper_cancel{
            margin-top: 36px;
          }
        }

        @media (max-width:420px) {
          .meetup_popup_option_label_creator_what{
            width: 50px;
          }

          .meetup_popup_container_wrapper{
            padding: 0px;
          }
        }

        @media (max-width:320px) {
          .mannayo_title_background p{
            width: 296px;
          }

          .mannayo_thumb_meet_users_container{
            display: none;
          }
        }
    </style>

<link href="{{ asset('/css/simple-scrollbar.css?version=1') }}" rel="stylesheet"/>
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

@if(isset($share_channel_id))
<input id='share_channel_id' type='hidden' value='{{$share_channel_id}}'/>
@else
<input id='share_channel_id' type='hidden' value=''/>
@endif

@if(isset($share_meetup_info))
<input id='share_meetup_info' type='hidden' value='{{$share_meetup_info}}'/>
@else
<input id='share_meetup_info' type='hidden' value=''/>
@endif

<?php
$maxItemCountInLine = 4;  //한줄에 표시될 아이템 개수
$mobileOneLineItemCount = 2;  //모바일일때 한 라인에 보여질 아이템 개수
?>

    <div class="mannayo_title_container">
        <div class="mannayo_title_background">  
          <p class='mannayo_title_text mannayo_title_text_pc'>만나고 싶은 크리에이터를 등록하세요.<br>
          가장 먼저 이벤트에 초대해 드릴게요.</p>
          <p class='mannayo_title_text mannayo_title_text_mobile'>만나고 싶은 크리에이터를 등록하세요.
          가장 먼저 이벤트에 초대해 드릴게요.</p>
        </div>
    </div>

    <div class="mannayo_search_container_target">
      <div class="mannayo_search_container">
          <div class="mannayo_search_input_container">
            <div class="flex_layer">
              <div class="input_mannayo_search_img"><img src="{{ asset('/img/icons/svg/ic-search-wh.svg') }}" class='search_img'/></div>
              <input type="text" id="input_mannayo_search" placeholder="크리에이터 검색"/>
            </div>
          </div>

          <div class="mannayo_searching_loading_container">
            <div class='mannayo_youtube_crolling_info_container mannayo_youtube_crolling_info_container_search'>
              <p class='mannayo_youtube_crolling_now_counter'></p>
              <p class='mannayo_youtube_crolling_all_counter'></p>
            </div>
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

    <div class="welcome_content_container welcome_content_new_meetup_container">
      <div class="welcome_content_wrapper">
        <div class="flex_layer">
          <div class="welcome_content_title">
            최신 만나요
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
                for($j = $i ; $j < count($newmeetups) ; $j++)
                {
                  $meetup = $newmeetups[$projectIndex];

                  //만나요
                  ?>
                  @if($i === 0 && $j === 0)
                    <div class='mannayo_thumb_object_container_in_main'>
                      <div class='mannayo_thumb_container' style='margin-right: 20px;'>
                        <div class='mannayo_thumb_img_wrapper'>
                          <div class='mannayo_thumb_img_resize'>
                            <button class='mannayo_create_button' type='button'>
                              <img class='mannayo_peace_img' src="{{ asset('/img/icons/ic-emoji-wantomeet-peace-64.png') }}" style=''/>
                              <p>새 만나요 만들기</p>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  @else
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
                    ?>
                  @endif
                  <?php
                  $itemCount++;
                  
                  if(count($newmeetups) < $projectIndex + 1)
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

    <div class="welcome_content_container">
        <div class='mannayo_search_result_find_container_main'>
        </div>
        <div class='mannayo_no_creator_list_container'>
          <img src="{{ asset('/img/icons/svg/ic-no-result-emoji.svg') }}"/>
          <p>검색 결과가 없어요</p>
        </div>
        <div class='mannayo_no_creator_list_in_api_container'>
          <img src="{{ asset('/img/icons/svg/ic-no-result-emoji.svg') }}"/>
          <p>없는 채널이네요. 채널 주소를 직접 입력해주세요</p>
        </div>
        <div class='mannayo_creator_list_container'>
          <div class='mannayo_creator_list_title'>
            새 만나요 만들기
          </div>
          <div class='mannayo_creator_list'>
          </div>
        </div>

        <div class='mannayo_list_container'>
          <div class='flex_layer'>
            <div class='mannayo_creator_list_title mannayo_creator_list_title_searching'>
              이미 있는 만나요
            </div>
            <div class='mannayo_creator_pop_list_title' style='margin-top: 51px;'>
              인기 만나요
            </div>
            <div class='mannayo_sort_container'>
              <div class='mannayo_sort_fake_text_container flex_layer'>
                <p id='mannayo_sort_fake_text'>최신순</p>
                <img src="{{ asset('/img/icons/svg/icon-box.svg') }}">
              </div>
              <select class='mannayo_sort_select' name='mannayo_sort'>
                <option value='0' selected>최신순</option>
                <option value='1'>인기순</option>
                @if(\Auth::check() && \Auth::user())
                <option value='2'>나의 만나요</option>
                @endif
              </select>
            </div>
          </div>
          <div class='mannayo_meetup_list_container'>
          </div>
        </div>

        <div class='mannayo_meetup_list_end_fake_offset'>
        </div>

        <div class="mannayo_list_loading_container mannayo_list_loading_container_main">
          <div class='mannayo_youtube_crolling_info_container mannayo_youtube_crolling_info_container_main'>
            <p class="mannayo_youtube_crolling_now_counter"></p>
            <p class="mannayo_youtube_crolling_all_counter"></p>
          </div>
          <p class="searching"><span>.</span><span>.</span><span>.</span><span>.</span></p>
        </div>
        <div class="mannayo_list_more_wrapper">
          <button id="mannayo_list_more_button" class="mannayo_list_more_button">
            더보기
          </button>
        </div>
    </div>
 
@endsection

@section('js')
<script src="{{ asset('/js/simple-scrollbar.js?version=1') }}"></script>
<script src="{{ asset('/js/lib/clipboard.min.js') }}"></script>

    <script>
      const FIND_TYPE_IN_API = 1;
      const FIND_TYPE_IN_CHANNEL = 2;
      const FIND_TYPE_IN_API_MAIN = 3;//엔터 쳤을때 메인에 붙는 풋터
      const FIND_TYPE_IN_CHANNEL_MAIN = 4;

      const TYPE_LIST_FIRST_CREATOR = 1;
      const TYPE_LIST_FIRST_FIND_SUCCESS = 2;
      const TYPE_LIST_FIRST_FIND_NO = 3;
      const TYPE_LIST_FIRST_FIND_API_NO = 4;
      const TYPE_LIST_FIRST_CREATOR_MAIN = 5;
      const TYPE_LIST_FIRST_CREATOR_MAIN_FIND_API = 6;
      const TYPE_LIST_FIRST_FIND_API_NO_MAIN = 7; //메인에서 api 요청으로 값이 없을때

      const TYPE_LIST_SECOND_MEETUP = 1;
      const TYPE_LIST_SECOND_FIND_API = 2;
      const TYPE_LIST_SECOND_FIND_NO = 3;
      
      //const SEARCH_OBJECT_HEIGHT_PC = 100;
      const SEARCH_OBJECT_HEIGHT_PC = 76;
      const SEARCH_OBJECT_HEIGHT_POPUP = 64;

      var SEARCH_OBJECT_HEIGHT = SEARCH_OBJECT_HEIGHT_PC;
      //const SEARCH_OBJECT_HEIGHT = 64;

      const AGE_NONE_TYPE_OPTION = 9999;//선택되지 않은 년생 option 값

      var sortTypes = ['최신순', '인기순', '나의 만나요'];
      //서버와 동일
      const SORT_TYPE_NEW = 0;
      const SORT_TYPE_POPULAR = 1;
      const SORT_TYPE_MY_MEETUP = 2;

      const CALL_MANNAYO_ONCE_MAX_COUNT = 12;
      const CALL_MANNAYO_POPUP_ONCE_USERS_MAX_COUNT = 12; //팝업시 유저 정보 요청수
      const CALL_MANNAYO_POPUP_ONCE_USERS_COMMENT_MAX_COUNT = 12; //팝업시 유저 정보 요청수

      const MANNAYO_COLUM_COUNT = 4;

      const TYPE_CREATE_MEETUP = 0;
      const TYPE_CREATE_MEETUP_NEW = 1;

      const INPUT_SEARCH_WAIT_MS = 300;

      //서버 코드와 동일
      const INPUT_KEY_TYPE_NORMAL = 'key_type_normal';
      const INPUT_KEY_TYPE_ENTER = 'key_type_enter';
      const INPUT_KEY_TYPE_MORE = 'key_type_more_button';

      const MAIN_FIND_STATE_NORMAL = 0;
      const MAIN_FIND_STATE_FIND_API = 1;
      const MAIN_FIND_STATE_NO_LIST = 2;
      const MAIN_FIND_STATE_NO_LIST_IN_API = 3;
      const MAIN_FIND_STATE_NO_MORE = 4;

      const YOUTUBE_SEARCH_TYPE_API = 0;
      const YOUTUBE_SEARCH_TYPE_CROLLING = 1;

      const TYPE_TAB_MEETUP_POPUP_MEET = 0;
      const TYPE_TAB_MEETUP_POPUP_UESRS = 1;
      const TYPE_TAB_MEETUP_POPUP_COMMENT = 2;

      var citys = ['장소 선택', '서울', '부산', '대전', '대구', '광주', '울산', '인천', '경기도', '강원도', '충청도', '경상도', '전라도', '제주'];

      //var g_mannayoArray = new Array();
      var g_mannayoCounter = 0;

      var isPressEnterKey = false;

      //var g_sortType = SORT_TYPE_NEW;
      var g_sortType = SORT_TYPE_POPULAR;

      var g_nowOpenPopup_meetup_id = 0;
      var g_nowOpenPopup_meetup_channel = '';
      //var g_inputKeyType = INPUT_KEY_TYPE_NORMAL;//정렬에만 씀.

      $(document).ready(function () {
        var g_creatorsSearchList = $("#mannayo_search_result_ul");
        var g_meetupSearchList = $("#mannayo_search_result_ready_ul");
        var g_footerContainer = $(".mannayo_search_result_find_container");

        var g_creatorsSearchList_main = $(".mannayo_creator_list");
        var g_footerContainer_main = $(".mannayo_search_result_find_container_main");

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

        setScrollUI(".mannayo_search_result_ul_wrapper");
        setScrollUI(".mannayo_search_result_ready_ul_wrapper");

        var isMannayoSearchPopup = function(){
          if($("#mannayo_new_meetup_popup").length > 0)
          {
            return true;
          }

          return false;
        }

        var removeOptionMannayoSearchPopup = function(){
          $("#mannayo_new_meetup_popup").remove();
        }

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

        var setSwitchMoreLoading = function(loading, keyType, state){
          if(loading)
          {
            $(".mannayo_list_loading_container").show();
            $(".mannayo_list_more_wrapper").hide();
            $(".mannayo_creator_list_container").hide();
            //$(".mannayo_list_container").hide();
            $(".mannayo_search_result_find_container_main").hide();
            $(".mannayo_no_creator_list_container").hide();
            $(".mannayo_no_creator_list_in_api_container").hide();

            if(keyType === INPUT_KEY_TYPE_MORE)
            {
              $(".mannayo_list_container").show();
            }
            else
            {
              $(".mannayo_list_container").hide();
            }
          }
          else
          {
            if(state === MAIN_FIND_STATE_NO_LIST)
            {
              $(".mannayo_list_loading_container").hide();
              $(".mannayo_list_more_wrapper").hide();
              $(".mannayo_creator_list_container").hide();
              $(".mannayo_list_container").hide();
              $(".mannayo_search_result_find_container_main").show();
              $(".mannayo_no_creator_list_container").show();
              $(".mannayo_no_creator_list_in_api_container").hide();
            }
            else if(state === MAIN_FIND_STATE_NO_LIST_IN_API)
            {
              $(".mannayo_list_loading_container").hide();
              $(".mannayo_list_more_wrapper").hide();
              $(".mannayo_creator_list_container").hide();
              $(".mannayo_list_container").hide();
              $(".mannayo_search_result_find_container_main").show();
              $(".mannayo_no_creator_list_container").hide();
              $(".mannayo_no_creator_list_in_api_container").show();
            }
            else
            {
              if(keyType === INPUT_KEY_TYPE_ENTER)
              {
                $(".mannayo_list_loading_container").hide();
                $(".mannayo_list_more_wrapper").hide();
                $(".mannayo_creator_list_container").show();
                //$(".mannayo_list_container").show();
                $(".mannayo_search_result_find_container_main").show();
                if(state === MAIN_FIND_STATE_FIND_API)
                {
                  $(".mannayo_list_container").hide();
                }
                else
                {
                  $(".mannayo_list_container").show();
                }

                $(".mannayo_no_creator_list_container").hide();
                $(".mannayo_no_creator_list_in_api_container").hide();
              }
              else
              {
                $(".mannayo_list_loading_container").hide();
                $(".mannayo_list_more_wrapper").show();
                $(".mannayo_creator_list_container").hide();
                $(".mannayo_list_container").show();
                $(".mannayo_search_result_find_container_main").hide();
                $(".mannayo_no_creator_list_container").hide();
                $(".mannayo_no_creator_list_in_api_container").hide();
              }
            }
          }

          if(state === MAIN_FIND_STATE_NO_MORE)
          {
            $(".mannayo_list_more_wrapper").hide();
          }
        };

        var setCreatorScrollOption = function(list_first_type){
          if(isMannayoSearchPopup())
          {
            SEARCH_OBJECT_HEIGHT = SEARCH_OBJECT_HEIGHT_POPUP;
          }
          else
          {
            SEARCH_OBJECT_HEIGHT = SEARCH_OBJECT_HEIGHT_PC;
            if(list_first_type === TYPE_LIST_FIRST_FIND_SUCCESS)
            {
              //찾았어요! wrapper 수정란
              SEARCH_OBJECT_HEIGHT = 100;
              $('.result_creator_find_success_title').css('padding-top', '40px');
            }
            else if(list_first_type === TYPE_LIST_FIRST_FIND_NO)
            {
              SEARCH_OBJECT_HEIGHT = 100;
            }
            else
            {
              SEARCH_OBJECT_HEIGHT = SEARCH_OBJECT_HEIGHT_PC;
            }

            if(isMobile())
            {
              //SEARCH_OBJECT_HEIGHT = SEARCH_OBJECT_HEIGHT_POPUP;
            }
          }

          if(g_creatorsSearchList.children().size() < 4){
            $(".mannayo_search_result_ul_container").find(".mannayo_result_ul_gradation").hide();

            var ssContent = $(".mannayo_search_result_ul_wrapper").find(".ss-content");
            if(ssContent)
            {
              ssContent[0].style.width = '100%';
            }

            //var resultULHeight = Number(g_creatorsSearchList.children().size()) * SEARCH_OBJECT_HEIGHT;
            var resultULHeight = (Number(g_creatorsSearchList.children().size()) * SEARCH_OBJECT_HEIGHT);
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

            if(isMobile())
            {
              $(".mannayo_search_result_ul_wrapper")[0].style.height = "234px";
            }
            else
            {
              $(".mannayo_search_result_ul_wrapper")[0].style.height = "258px";
            }
          }
        }

        var setMeetupScrollOption = function(list_second_type){
          if(isMannayoSearchPopup())
          {
            SEARCH_OBJECT_HEIGHT = SEARCH_OBJECT_HEIGHT_POPUP;
          }
          else
          {
            SEARCH_OBJECT_HEIGHT = SEARCH_OBJECT_HEIGHT_PC;

            if(isMobile())
            {
              SEARCH_OBJECT_HEIGHT = SEARCH_OBJECT_HEIGHT_POPUP;
            }
          }

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

              if(isMobile())
              {
                $(".mannayo_search_result_ready_ul_wrapper")[0].style.height = "234px";
              }
              else
              {
                $(".mannayo_search_result_ready_ul_wrapper")[0].style.height = "258px";
              }
            }
          }
        };

        var removeCreatorList = function(){
          g_creatorsSearchList.children().remove();
        };

        var removeMeetupList = function(){
          g_meetupSearchList.children().remove();
        }

        var removeCreatorListInMain = function(){
          g_creatorsSearchList_main.children().remove();
        };

        var removeCreatorLastObject = function(){
          
        }

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
                var baseUrl = $('#base_url').val();
                if(window.location.href === baseUrl){
                  window.location.reload();
                }
                else{
                  window.location.href = baseUrl+'/mannayo';
                }
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

          $(".popup_call_meetup").css('height', 'auto');

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

        var checkCreateMeetup = function(creator_channel_id){
          if(!creator_channel_id || creator_channel_id === '0')
          {
            alert('크리에이터가 선택되지 않았습니다. 크리에이터를 다시 선택해주세요.');
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
            "age" : $(".age_user_select").val(),
            'comment' : $('#meetup_popup_option_comment_input').val()
          }
          
          var success = function(request) {
            loadingProcessStop($("#meetup_new_button"));
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
            loadingProcessStop($("#meetup_new_button"));
            $(".popup_close_button_wrapper").show();
            alert('만나요 생성 실패. 다시 시도해주세요.');
          };
          
          $.ajax({
          'url': url,
          'method': method,
          'data' : data,
          'success': success,
          'error': error
          });
          
        };

        //기존 팝업
        var openNewMeetPopup = function(creator_id, creator_title, creator_thumbnail_url, creator_channel_id, type){
          var cityOptions = '';
          var ageOptions = '';
          
          if(!creator_thumbnail_url)
          {
            creator_thumbnail_url = '';
          }

          for(var i = 0 ; i < citys.length ; i++)
          {
            var value = citys[i];

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

          var creatorInfoElement = '';
          if(type === TYPE_CREATE_MEETUP)
          {
            creatorInfoElement = "<div class='meetup_popup_option_creator'>" +
                                    "<div class='flex_layer'>" +
                                      "<img class='meetup_popup_option_img' src='"+creator_thumbnail_url+"'>" +
                                      "<p class='meetup_popup_option_creator_title'>" + 
                                        creator_title +
                                      "</p>" +
                                    "</div>" +
                                  "</div>";
          }
          else
          {
            creatorInfoElement = "<div class='meetup_popup_option_creator' style='background-color: white;'>"+"</div>";
          }
          
          var elementPopup = document.createElement("div");
          elementPopup.innerHTML = 
          "<div id='mannayo_new_meetup_popup'>" + 
          "</div>" +
          "<div class='meetup_popup_container'>" + 
            "<div class='meetup_popup_title_container'>" +
              "<h2>새 만나요 만들기</h2>" +
              "<p>언제까지 좋아요만 누를 순 없다! <br>크리에이터와 만나요 요청하고 진짜 만나요</p>" +
            "</div>" +
            
            "<div class='meetup_popup_option_container'>" + 
              "<div class='meetup_popup_option_wrapper flex_layer'>" +
                "<div class='meetup_popup_option_creator_info_target'>" + 
                  creatorInfoElement +
                "</div>" +
                "<div class='meetup_popup_option_creator_info_target_popup'>" + 
                "</div>" +
                "<p class='meetup_popup_option_label meetup_popup_option_label_creator_input'>과/와" + 
                "</p>" +
              "</div>" +

              "<div class='meetup_popup_option_wrapper flex_layer'>" +
                "<div class='meetup_popup_option_creator'>" +
                  "<div class='meetup_popup_city_text_container flex_layer'>" +
                    "<p id='meetup_popup_city_text'>장소 선택</p>" +
                    "<img src='{{ asset('/img/icons/svg/icon-box.svg') }}' style='margin-right: 24px;'>" +
                  "</div>" +
                  "<select class='city_meetup_select' name='city_meetup'>" +
                      cityOptions +
                  "</select>" +
                "</div>" +
                "<p class='meetup_popup_option_label meetup_popup_option_label_creator_input'>에서" + 
                "</p>" +
              "</div>" +

              "<div class='meetup_popup_option_wrapper flex_layer'>" +
                "<div class='meetup_popup_option_creator meetup_popup_option_creator_what_wrapper'>" +
                  "<input id='meetup_popup_option_what_input' placeholder='무엇을 하고 싶나요?'/>" + 
                "</div>" +
                "<p class='meetup_popup_option_label meetup_popup_option_label_creator_what'>를 하고 싶어요!" + 
                "</p>" +
              "</div>" +

              "<div class='meetup_popup_option_wrapper'>" +
                "<div class='meetup_popup_option_creator meetup_popup_option_comment_input_wrapper'>" +
                  "<input id='meetup_popup_option_comment_input' placeholder='크리에이터에게 한마디 (선택)'/>" + 
                "</div>" +
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

          stopDocumentScroll();
          swal({
                  content: elementPopup,
                  allowOutsideClick: "true",
                  className: "blueprint_popup",
                  closeOnClickOutside: false,
                  closeOnEsc: false
              }).then(function(value){
                reStartDocumentScroll();
                removeOptionMannayoSearchPopup();
                if(type === TYPE_CREATE_MEETUP_NEW)
                {
                  removeSearchBar($(".meetup_popup_option_creator_info_target"));
                  addSearchBar($(".mannayo_search_container_target"));
                }
              });

          $(".swal-footer").hide();

          $('.popup_close_button').click(function(){
              swal.close();
              $(".blueprint_popup").remove();
          });

          $(".city_meetup_select").change(function(){
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

          $("#meetup_new_button").click(function(){
            requestCreateMeetUp($(this).attr('data_creator_id'), $(this).attr('data_creator_channel_id'), $(this).attr('data_creator_title'), $(this).attr('data_creator_img_url'));
          });

          resetPopupContentHeight();
        };

        //신규 만남 만들기 팝업 START
        
        //신규 만남 만들기 팝업 END        

        var callUserInfo = function(successFunc){
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

              if(successFunc != null)
              {
                successFunc();
              }
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
          //swal.close();
          swal('로그인 완료!', '', 'success');
          callUserInfo(null);
        };

        var setCreatorInfoInNewMeetPopup = function(creator_id, creator_title, creator_thumbnail_url, creator_channel_id){
          //removeSearchBar($(".meetup_popup_option_creator_info_target"));
          $(".meetup_popup_option_creator_info_target").hide();

          var creatorInfoElement = document.createElement("div");
          creatorInfoElement.innerHTML = "<div class='meetup_popup_option_creator'>" +
                                            "<div class='flex_layer'>" +
                                              "<img class='meetup_popup_option_img' src='"+creator_thumbnail_url+"'>" +
                                              "<p class='meetup_popup_option_creator_title'>" + 
                                                creator_title +
                                              "</p>" +
                                              "<button id='meetup_popup_option_user_cancel_button'>" + 
                                                "<img src='{{ asset('/img/icons/svg/ic-exit-circle-20.svg') }}'>" +
                                              "</button>" +
                                            "</div>" +
                                          "</div>";

          $(".meetup_popup_option_creator_info_target_popup").append(creatorInfoElement);
          
          $('#meetup_new_button').attr('data_creator_channel_id', creator_channel_id);
          $('#meetup_new_button').attr('data_creator_title', creator_title);
          $('#meetup_new_button').attr('data_creator_img_url', creator_thumbnail_url);

          $('.meetup_popup_option_creator_info_target_popup').css('width', '100%');
          $('.meetup_popup_option_creator_info_target_popup').css('margin-right', '10px');

          $("#meetup_popup_option_user_cancel_button").click(function(){
            $(".meetup_popup_option_creator_info_target_popup").children().remove();
            $(".meetup_popup_option_creator_info_target").show();

            $('#meetup_new_button').attr('data_creator_channel_id', '');
            $('#meetup_new_button').attr('data_creator_title', '');
            $('#meetup_new_button').attr('data_creator_img_url', '');

            $('.meetup_popup_option_creator_info_target_popup').css('width', 'auto');
            $('.meetup_popup_option_creator_info_target_popup').css('margin-right', '0px');
          });
        };

        var setOpenNewMeetPopup = function(){
          $(".result_new_meet_button").click(function(){
            if(!isLogin())
            {
              loginPopup(closeLoginPopup, null);
              return;
            }
            var element = $(this);

            if(isMannayoSearchPopup())
            {
              setCreatorInfoInNewMeetPopup(null, element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"));
            }
            else
            {
              openNewMeetPopup(element.attr("data_creator_id"), element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"), TYPE_CREATE_MEETUP);
            }
          });
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
              window.location.reload();
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
                    var baseUrl = $('#base_url').val();
                    if(window.location.href === baseUrl){
                      window.location.reload();
                    }
                    else{
                      window.location.href = baseUrl+'/mannayo';
                    }
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

          $("#meetup_cancel_button").click(function(){
            //requestMeetUp($(this).attr('data_meetup_id'));
            requestCancelMeetUp($(this).attr('data_meetup_id'));
          });

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
              profile_photo_url = $('#asset_url').val()+'img/icons/ic-default-profile-512.png';
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
                  
                  var lastObjectTop = $(lastObjectName).offset().top;
                  var targetObjectTop = $('.mannayo_meetup_popup_scroll_bottom_fake_offset').offset().top;

                  if(isEndUsers){
                    return;
                  }

                  if(lastObjectTop < targetObjectTop)
                  {
                    if(!isRequestUsers)
                    {
                      addMeetupUserMoreObject();
                      requestMeetupUsersInPopup();
                      isRequestUsers = true;
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
              var defultURL = $('#asset_url').val()+'img/icons/ic-default-profile-512.png';
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
            //var commentsCommentFormId = 'mannayo_comments_comment_form_'+user.index_object;
            var commentsCommentFormId = 'mannayo_comments_comment_form_'+comment.id;
            if(isLogin()){
              commentscommentElement = "<form id='"+commentsCommentFormId+"' action='{{ url('/mannayocommentscomment') }}/"+comment.id+"/comments' method='post' data-toggle='validator' role='form' class='form-horizontal'>" +
                                        "<div class='form-group'>" +
                                          "<div class='col-md-2'>" +
                                          "</div>" +
                                          "<div class='col-md-7 reply-textarea'>" +
                                            "<textarea id='comments_comment_textarea_id_"+comment.id+"' name='contents' maxlength='255' class='form-control' rows='3' placeholder='답글을 입력하세요'></textarea>" +
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
              profile_photo_url = $('#asset_url').val()+'img/icons/ic-default-profile-512.png';
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

              },
              'success': function(request) {

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

            },
            'success': function(request) {

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

              if(request.state === 'success'){
                for(var i = 0 ; i < request.meetup_comments.length ; i++)
                {
                  var meetup_comment = request.meetup_comments[i];
                  var objectIndex = ((i+1) + popupNowMannayoCommentCountNumber);

                  meetup_comment.user.index_object = objectIndex;

                  addMannayoCommentObject(meetup_comment, false);
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
          //////////////////////tab cancel end/////

          resetPopupContentHeight();
        };
        //만나요 취소 팝업 END

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
              profile_photo_url = $('#asset_url').val()+'img/icons/ic-default-profile-512.png';
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
                  var lastObjectName = '.li_meetup_object_' + g_popupNowMannayoCount;
                  
                  var lastObjectTop = $(lastObjectName).offset().top;
                  var targetObjectTop = $('.mannayo_meetup_popup_scroll_bottom_fake_offset').offset().top;

                  if(isEndUsers){
                    return;
                  }

                  if(lastObjectTop < targetObjectTop)
                  {
                    if(!isRequestUsers)
                    {
                      addMeetupUserMoreObject();
                      requestMeetupUsersInPopup();
                      isRequestUsers = true;
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
              var defultURL = $('#asset_url').val()+'img/icons/ic-default-profile-512.png';
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
                                            "<textarea id='comments_comment_textarea_id_"+comment.id+"' name='contents' maxlength='255' class='form-control' rows='3' placeholder='답글을 입력하세요'></textarea>" +
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
              profile_photo_url = $('#asset_url').val()+'img/icons/ic-default-profile-512.png';
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

              },
              'success': function(request) {

                var parentUlClass = request.commentscomment_parent;
                var buttonID = "#"+request.commentscomment_button_id;

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

        var requestCreateCreator = function(creator_title, creator_thumbnail_url, creator_channel_id){
          var url="/mannayo/create/creator";
          var method = 'post';
          var data =
          {
            "creator_channel_id" : creator_channel_id,
            "creator_title" : creator_title,
            "creator_img_url" : creator_thumbnail_url
          }
          var success = function(request) {
          };
          
          var error = function(request) {
            alert('크리에이터 정보 추가 실패');
          };
          
          $.ajax({
          'url': url,
          'method': method,
          'data' : data,
          'success': success,
          'error': error
          });
        };

        //api 를 통해 새로운 크리에이터 팝업
        var setOpenNewCreatorApiMeetupPopup = function(){
          $(".result_add_new_creator_button").click(function(){
            if(!isLogin())
            {
              loginPopup(closeLoginPopup, null);
              return;
            }

            var element = $(this);
            
            requestCreateCreator(element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"));

            if(isMannayoSearchPopup())
            {
              setCreatorInfoInNewMeetPopup(null, element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"));
            }
            else
            {
              openNewMeetPopup('', element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"), TYPE_CREATE_MEETUP);
            }
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
            openMeetPopup(element.attr("data_meetup_channel_id"), element.attr("data_meetup_id"), element.attr("data_meetup_title"), element.attr("data_meetup_where"), element.attr("data_meetup_what"), element.attr("data_meetup_img_url"), element.attr("data_meetup_count"), element.attr("data_comments_count"));
          });
        };

        var addSearchFindSuccessObject = function(){
          var element = document.createElement("li");
          
          if(isMannayoSearchPopup())
          {
            element.innerHTML =
              "<div class='result_creator_wrapper' style='height: 64px; background-color: #f7f7f7'>" +
                "<div class='result_creator_find_success_title result_creator_find_success_title_popup'>"+"찾았어요! 👇"+"</div>" +
              "</div>";
          }
          else
          {
            element.innerHTML =
              "<div class='result_creator_wrapper'>" +
                "<div class='result_creator_find_success_title'>"+"찾았어요! 👇"+"</div>" +
              "</div>";
          }
          
          
          g_creatorsSearchList.append(element);
        };

        var addSearchNoCreatorObject = function(){
          var element = document.createElement("li");
          if(isMannayoSearchPopup())
          {
            element.innerHTML =
              "<div class='mannayo_search_result_footer_wrapper_popup mannayo_search_no_creator_object_container'>" + 
                "<p class='mannayo_search_result_find_label mannayo_search_result_find_label_popup mannayo_search_no_creator_title'>검색값이 없네요 :( 크티가 더 찾아볼까요?</p>" +
                "<div class='mannayo_search_result_find_button_popup'>" +
                  "<span>찾아보기</span>" +
                  "<img src='{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}' style='margin-left:2px; margin-top:0px; margin-right: 24px; margin-bottom: 1px; width:5px;'/>" +
                "</div>" +

                "<button class='mannayo_search_result_find_fake_button'>" +
                "</button>" +
              "</div>";
          }
          else
          {
            element.innerHTML =
              "<div class='result_creator_wrapper'>" +
                "<div class='flex_layer_mobile' style='margin-top: 38px;'>" + 
                  "<div class='result_creator_meet_more_search_title'>"+"검색값이 없네요 :( 크티가 더 찾아볼까요?"+"</div>" +
                  "<div class='result_creator_meet_container'>" + 
                    "<span>찾아보기</span>" + 
                    "<img src='{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}' style='margin-left:8px; margin-top:1px; margin-right: 0px;'/>" +
                  "</div>" + 
                "</div>" +

                "<button id='mannayo_search_result_find_button' class='result_object_button_fake'>" + 
                "</button>" +
              "</div>";
          }
          
          g_creatorsSearchList.append(element);

          $("#mannayo_search_result_find_button").click(function(){
            youtubeGetSearchInfo(FIND_TYPE_IN_API);
          });
        };

        var addCreatorObject = function(creator){
          var img = "<img class='result_creator_thumbnail_img' src='"+creator.thumbnail_url+"'>";

          var element = document.createElement("li");

          if(isMannayoSearchPopup())
          {
            element.innerHTML =
            "<div class='result_creator_wrapper'>" +
            
              "<div class='flex_layer' style='margin-left: 0px;'>" + 
                "<div class='result_creator_thumbnail_img_wrapper result_creator_thumbnail_img_wrapper_popup'>"+
                  "<img class='result_creator_thumbnail_img result_creator_thumbnail_img_popup' src='"+creator.thumbnail_url+"'>" +
                "</div>" +
                "<div class='result_creator_name text-ellipsize result_creator_name_popup'>"+creator.title+"</div>" +
                "<div class='result_creator_meet_container result_creator_meet_container_popup flex_layer'>" + 
                  "<img class='result_creator_plus_img result_creator_plus_img_pop' src='{{ asset('/img/icons/svg/ic-plus-blue-circle-36.svg') }}'/>" +
                "</div>" + 
              "</div>" +
              
              "<button data_creator_id='"+ creator.id +"' data_creator_channel_id='"+creator.channel_id+"' data_creator_title='"+ creator.title +"' data_creator_img_url='"+ creator.thumbnail_url +"' class='result_new_meet_button result_object_button_fake' type='button'>" + 
              "</button>" + 
            "</div>";

            
          }
          else
          {
            element.innerHTML =
            "<div class='result_creator_wrapper'>" +
            
              "<div class='flex_layer' style='margin-left: 0px;'>" + 
                "<div class='result_creator_thumbnail_img_wrapper'>"+img+"</div>" +
                "<div class='result_creator_name text-ellipsize'>"+creator.title+"</div>" +

                "<div class='result_creator_meet_container flex_layer'>" + 
                  "<div class='result_creator_meet_word'>"+"새 만나요 만들기"+"</div>" +
                  "<img class='result_creator_plus_img' src='{{ asset('/img/icons/svg/ic-plus-blue-circle-36.svg') }}'/>" +
                "</div>" +
              "</div>" +
              "<button data_creator_id='"+ creator.id +"' data_creator_channel_id='"+creator.channel_id+"' data_creator_title='"+ creator.title +"' data_creator_img_url='"+ creator.thumbnail_url +"' class='result_new_meet_button result_object_button_fake'>" +
              "</button>" +
            "</div>";
          }
          
          
          g_creatorsSearchList.append(element);           
        }

        var addMeetupObject = function(meetup){
          var isMeetupCoverElement = '';
          //var buttonElement = '';
          
          var buttonElement = 
          "<button class='result_meetup_meet_button mannayo_search_cancel_button' data_meetup_channel_id='"+meetup.channel_id+"' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"' data_meetup_count='"+meetup.meet_count+"' data_comments_count='"+meetup.comments_count+"'>" + 
          "</button>";
          
          if(meetup.is_meetup)
          {

            buttonElement = 
            "<button class='mannayo_thumb_meetup_cancel_button mannayo_search_cancel_button' data_meetup_channel_id='"+meetup.channel_id+"' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"' data_meetup_count='"+meetup.meet_count+"' data_comments_count='"+meetup.comments_count+"'>" + 
            "</button>";

            if(isMannayoSearchPopup())
            {
              isMeetupCoverElement = 
                "<div class='mannayo_is_meetup_thumb_mask'>" + 
                "</div>" + 
                "<img class='mannayo_is_meetup_thumb_mask_check_img mannayo_is_meetup_thumb_mask_check_img_popup' src='{{ asset('/img/icons/svg/ic-meet-search-check-circle-20.svg') }}'>";
            }
            else
            {
              isMeetupCoverElement = 
                "<div class='mannayo_is_meetup_thumb_mask'>" + 
                "</div>" + 
                "<img class='mannayo_is_meetup_thumb_mask_check_img' src='{{ asset('/img/icons/svg/ic-meet-search-check-circle-20.svg') }}'>";
            }
          }

          var element = document.createElement("li");

          if(isMannayoSearchPopup())
          {
            element.innerHTML =
              "<div class='result_creator_wrapper'>" +
                "<div class='flex_layer result_meetup_container' style='margin-left: 0px;'>" + 
                  "<div class='result_creator_thumbnail_img_wrapper result_creator_thumbnail_img_wrapper_popup'>"+
                    "<img class='result_creator_thumbnail_img result_creator_thumbnail_img_popup' src='"+meetup.thumbnail_url+"'>" +
                    isMeetupCoverElement +
                  "</div>" +
                  "<div class='result_meetup_content_container result_meetup_content_container_popup'>" + 
                    "<div class='result_meetup_name result_meetup_name_popup'>"+meetup.title+ "과 " + meetup.where + "에서" +"</div>" + 
                    "<div class='result_meetup_content result_meetup_content_popup text-ellipsize'>"+meetup.what+"</div>" +
                  "</div>" +
                "</div>" +
                buttonElement +
              "</div>";
          }
          else
          {
            element.innerHTML =
              "<div class='result_creator_wrapper'>" +
              
                "<div class='flex_layer result_meetup_container' style='margin-left: 0px;'>" + 
                  "<div class='result_creator_thumbnail_img_wrapper'>"+
                    "<img class='result_creator_thumbnail_img' src='"+meetup.thumbnail_url+"'>" +
                    isMeetupCoverElement +
                  "</div>" +
                  "<div class='result_meetup_content_container'>" + 
                    "<div class='result_meetup_name'>"+meetup.title+ "과 " + meetup.where + "에서" +"</div>" + 
                    "<div class='result_meetup_content text-ellipsize'>"+meetup.what+"</div>" +
                  "</div>" +
                "</div>" +
                buttonElement +
              "</div>";
          }
          
          
          g_meetupSearchList.append(element);

          $(".result_meetup_meet_button").mouseover(function(){
            $(this).prevAll(".result_meetup_container").css('background-color', '#f7f7f7');
          });

          $(".result_meetup_meet_button").mouseleave(function(){
            $(this).prevAll(".result_meetup_container").css('background-color', 'white');
          });
        };

        var addCreatorApiObject = function(creator){
          var channelId = '';
          var channelTitle = '';
          var channelThumbnailURL = '';
          var img = '';
          if(creator.created_at)
          {
            channelId = creator.channel_id;
            channelTitle = creator.title;
            channelThumbnailURL = creator.thumbnail_url;
            img = "<img class='result_creator_thumbnail_img' src='"+channelThumbnailURL+"'>";
          }
          else
          {
            channelId = creator.channelId;
            channelTitle = creator.channelTitle;
            channelThumbnailURL = creator.thumbnails.high.url;
            img = "<img class='result_creator_thumbnail_img' src='"+channelThumbnailURL+"'>";
          }
          

          var element = document.createElement("li");

          if(isMannayoSearchPopup())
          {
            element.innerHTML =
              "<div class='result_creator_wrapper'>" +
              
                "<div class='flex_layer' style='margin-left: 0px;'>" + 
                  "<div class='result_creator_thumbnail_img_wrapper result_creator_thumbnail_img_wrapper_popup'>" +
                    "<img class='result_creator_thumbnail_img result_creator_thumbnail_img_popup' src='"+channelThumbnailURL+"'>" +
                  "</div>" +
                  "<div class='result_creator_name text-ellipsize result_creator_name_popup'>"+channelTitle+"</div>" +
                  "<div class='result_creator_meet_container flex_layer'>" + 
                    "<img class='result_creator_plus_img result_creator_plus_img_pop' src='{{ asset('/img/icons/svg/ic-plus-blue-circle-36.svg') }}'/>" +
                  "</div>" + 
                "</div>" +
                "<button class='result_add_new_creator_button result_object_button_fake' data_creator_channel_id='"+channelId+"' data_creator_title='"+channelTitle+"' data_creator_img_url='"+channelThumbnailURL+"'>" + 
                "</button>" + 
              "</div>";
          }
          else
          {
            element.innerHTML =
              "<div class='result_creator_wrapper'>" +
                "<div class='flex_layer' style='margin-left: 0px;'>" + 
                  "<div class='result_creator_thumbnail_img_wrapper'>"+img+"</div>" +
                  "<div class='result_creator_name text-ellipsize result_creator_name_width'>"+channelTitle+"</div>" +
                  "<div class='result_creator_meet_container flex_layer'>" + 
                    "<div class='result_creator_meet_word'>"+"새 만나요 만들기"+"</div>" +
                    "<img class='result_creator_plus_img' src='{{ asset('/img/icons/svg/ic-plus-blue-circle-36.svg') }}'/>" +
                  "</div>" + 
                "</div>" +
                "<button class='result_add_new_creator_button result_object_button_fake' data_creator_channel_id='"+channelId+"' data_creator_title='"+channelTitle+"' data_creator_img_url='"+channelThumbnailURL+"'>" + 
                "</button>" + 
              "</div>";

            
          }
          
          g_meetupSearchList.append(element);

        };

        var addSearchAPINoCreatorObject = function(){
          var element = document.createElement("li");

          if(isMannayoSearchPopup())
          {
            element.innerHTML =
              "<div class='result_creator_wrapper'>" +
                "<div class='result_creator_find_success_title result_creator_find_success_title_popup'>"+"없는 채널이네요. 채널 주소를 직접 입력해주세요 👇"+"</div>" +
              "</div>";
          }
          else
          {
            element.innerHTML =
              "<div class='result_creator_wrapper'>" +
                "<div class='result_creator_find_success_title'>"+"없는 채널이네요. 채널 주소를 직접 입력해주세요 👇"+"</div>" +
              "</div>";
          }

          g_creatorsSearchList.append(element);
        };

        var addCreatorObjectInMain = function(creator, targetElement){
          var img = "<img class='result_creator_thumbnail_img' src='"+creator.thumbnail_url+"'>";

          var element = document.createElement("div");

          element.innerHTML =
          "<div class='result_creator_wrapper result_creator_wrapper_main'>" +
          
            "<div class='flex_layer' style='margin-left: 0px;'>" + 
              "<div class='result_creator_thumbnail_img_wrapper'>"+img+"</div>" +
              "<div class='result_creator_name text-ellipsize'>"+creator.title+"</div>" +
              "<div class='result_creator_meet_container flex_layer'>" + 
                "<div class='result_creator_meet_word'>"+"새 만나요 만들기"+"</div>" +
                "<img class='result_creator_plus_img' src='{{ asset('/img/icons/svg/ic-plus-blue-circle-36.svg') }}'/>" +
              "</div>" + 
            "</div>" +
            "<button data_creator_id='"+ creator.id +"' data_creator_channel_id='"+creator.channel_id+"' data_creator_title='"+ creator.title +"' data_creator_img_url='"+ creator.thumbnail_url +"' class='result_new_meet_button_in_main result_object_button_fake'>" +
            "</button>" + 
          "</div>";

          
          targetElement.appendChild(element);
        };

        var addCreatorObjectInMainFindApi = function(creator, targetElement){
          var channelId = '';
          var channelTitle = '';
          var channelThumbnailURL = '';
          var img = '';
          if(creator.created_at)
          {
            channelId = creator.channel_id;
            channelTitle = creator.title;
            channelThumbnailURL = creator.thumbnail_url;
            img = "<img class='result_creator_thumbnail_img' src='"+channelThumbnailURL+"'>";
          }
          else
          {
            channelId = creator.channelId;
            channelTitle = creator.channelTitle;
            channelThumbnailURL = creator.thumbnails.high.url;
            img = "<img class='result_creator_thumbnail_img' src='"+channelThumbnailURL+"'>";
          }

          var element = document.createElement("div");
          element.innerHTML =
          "<div class='result_creator_wrapper result_creator_wrapper_main'>" +
          
            "<div class='flex_layer' style='margin-left: 0px;'>" + 
              "<div class='result_creator_thumbnail_img_wrapper'>"+img+"</div>" +
              "<div class='result_creator_name result_creator_name_in_main text-ellipsize'>"+channelTitle+"</div>" +
              "<div class='result_creator_meet_container flex_layer'>" + 
                "<div class='result_creator_meet_word'>"+"새 만나요 만들기"+"</div>" +
                "<img class='result_creator_plus_img' src='{{ asset('/img/icons/svg/ic-plus-blue-circle-36.svg') }}'/>" +
              "</div>" + 
            "</div>" +

            "<button data_creator_channel_id='"+channelId+"' data_creator_title='"+ channelTitle +"' data_creator_img_url='"+ channelThumbnailURL +"' class='result_add_new_creator_button_in_main result_object_button_fake'>" + 
            "</button>" + 
          "</div>";
          
          
          targetElement.appendChild(element);
        };

        var addSearchAPINoCreatorObjectInMain = function(){
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

        var removeMainFooter = function(){
          g_footerContainer_main.children().remove();
        };

        var addFooter = function(findType){
          removeFooter();
          var element = "";

          if(findType === FIND_TYPE_IN_API)
          {
            element = document.createElement("div");

            if(isMannayoSearchPopup())
            {
              element.innerHTML =
                  "<div class='mannayo_search_result_footer_wrapper_popup'>" + 
                    "<p class='mannayo_search_result_find_label mannayo_search_result_find_label_popup'>원하는 크리에이터가 없나요? 크티가 더 찾아볼게요</p>" +
                    "<div class='mannayo_search_result_find_button_popup' disabled='disabled'>" +
                      "<span>찾아보기</span>" +
                      "<img src='{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}' style='margin-left:2px; margin-top:0px; margin-right: 24px; margin-bottom: 1px; width:5px;'/>" +
                    "</div>" +

                    "<button class='mannayo_search_result_find_fake_button'>" +
                    "</button>" +
                  "</div>";
            }
            else
            {
              element.innerHTML =
                "<div class='flex_layer_mobile'>" +
                  "<p class='mannayo_search_result_find_label'>원하는 크리에이터가 없나요? 크티가 더 찾아볼게요</p>" +
                  "<div class='mannayo_search_result_find_button_wrapper'>" +
                    "<div>" +
                      "<span>찾아보기</span>" +
                      "<img class='mannayo_search_result_find_more_img' src='{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}'/>" +
                    "</div>" +
                  "</div>" +
                "</div>" +

                "<button class='mannayo_search_result_find_button result_object_button_fake'>" +
                "</button>";

                $('.mannayo_search_result_find_container').css('height', '100px');

                element.className = 'mannayo_search_result_find_container_container';
                
              
            }
            
          }
          else if(findType === FIND_TYPE_IN_CHANNEL)
          {
            element = document.createElement("div");
            element.className = "mannayo_channel_search_container";

            if(isMannayoSearchPopup())
            {
              element.innerHTML =
                "<p class='mannayo_channel_input_label mannayo_channel_input_label_popup'>채널주소 직접 입력하기</p>" +
                "<div class='mannayo_channel_input_wrapper'>" +
                  "<div class='flex_layer'>" +
                    "<input class='mannayo_channel_input mannayo_channel_input_popup' placeholder='https://www.youtube.com/channel&user/0000'/>" +
                    "<button id='mannayo_channel_input_button' class='mannayo_channel_input_button_popup' type='button'>입력</button>" +
                  "</div>" +
                  "<p class='mannayo_channel_input_help_block mannayo_channel_input_help_block_popup'>유튜브 채널주소를 입력하면 더 정확해요!</p>" +
                "</div>";
            }
            else
            {
              var buttonText = "입력";
              if(isMobile())
              {
                buttonText = '입력';
              }

              element.innerHTML =
                "<p class='mannayo_channel_input_label'>채널주소 직접 입력하기</p>" +
                "<div class='mannayo_channel_input_wrapper'>" +
                  "<div class='flex_layer'>" +
                    "<input class='mannayo_channel_input' placeholder='https://www.youtube.com/channel&user/0000'/>" +
                    "<button id='mannayo_channel_input_button' type='button'>" + buttonText + "</button>" +
                  "</div>" +
                  "<p class='mannayo_channel_input_help_block'>유튜브 채널주소를 입력하면 더 정확해요!</p>" +
                "</div>";

              $('.mannayo_search_result_find_container').css('height', '134px');
            }
          }
          else if(findType === FIND_TYPE_IN_API_MAIN)
          {
            removeMainFooter();

            element = document.createElement("div");
            element.className = 'mannayo_search_result_find_wrapper';

            element.innerHTML =
              "<div class='flex_layer_thumb' style='height: 100%'>" +
                "<p class='mannayo_search_result_find_label mannayo_search_result_find_label_fix'>원하는 크리에이터가 없나요? 크티가 더 찾아볼게요</p>" +
                "<div class='mannayo_search_result_find_button_wrapper mannayo_search_result_find_button_wrapper_in_main'>" +
                  "<div class='mannayo_search_result_find_button mannayo_search_result_find_button_fix'>" +
                    "<span>찾아보기</span>" +
                    "<img src='{{ asset('/img/icons/svg/ic-more-line-7-x-13.svg') }}' style='margin-left:8px; margin-top:1px; margin-right: 24px;'/>" +
                  "</div>" +
                "</div>" +
              "</div>" +

              "<button class='mannayo_search_result_find_button_fake result_object_button_fake'>" +
              "</button>";

            /*
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
              */

            //$('.mannayo_search_result_find_container').css('height', '100px');
          }
          else if(findType === FIND_TYPE_IN_CHANNEL_MAIN)
          {
            removeMainFooter();

            element = document.createElement("div");
            element.className = "mannayo_channel_search_container_in_main";
            element.innerHTML =
              "<p class='mannayo_channel_input_label'>채널주소 직접 입력하기</p>" +
              "<div class='mannayo_channel_input_wrapper'>" +
                "<div class='flex_layer'>" +
                  "<input class='mannayo_channel_input_in_main' placeholder='https://www.youtube.com/channel&user/0000'/>" +
                  "<button id='mannayo_channel_input_button_in_main' type='button'>입력</button>" +
                "</div>" +
                "<p class='mannayo_channel_input_help_block'>유튜브 채널주소를 입력하면 더 정확해요!</p>" +
              "</div>";
            
          }

          if(findType === FIND_TYPE_IN_API_MAIN ||
            findType === FIND_TYPE_IN_CHANNEL_MAIN)
          {
            g_footerContainer_main.append(element);

            if(findType === FIND_TYPE_IN_CHANNEL_MAIN){
              g_footerContainer_main.css('height', 'auto');
            }
            else{
              g_footerContainer_main.css('height', '100px');
            }
          }
          else
          {
            g_footerContainer.append(element);
          }

          $(".mannayo_search_result_find_button").click(function(){
            youtubeGetSearchInfo(findType);
          });

          $(".mannayo_search_result_find_button_fake").click(function(){
            youtubeGetSearchInfo(findType);
          });

          $(".mannayo_search_result_find_fake_button").click(function(){
            youtubeGetSearchInfo(findType);
          });

          $('#mannayo_channel_input_button').click(function(){
              youtubeGetSearchChannelInfo(findType);
          });

          $('#mannayo_channel_input_button_in_main').click(function(){
              youtubeGetSearchChannelInfo(findType);
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
          else if(list_first_type === TYPE_LIST_FIRST_FIND_API_NO_MAIN){
            removeCreatorListInMain();
            addFooter(FIND_TYPE_IN_CHANNEL_MAIN);
          }
          else if(list_first_type === TYPE_LIST_FIRST_CREATOR_MAIN ||
                  list_first_type === TYPE_LIST_FIRST_CREATOR_MAIN_FIND_API){
            removeCreatorListInMain();

            var rowCount = Math.ceil(creators.length / 2);
            var index = 0;
            for(var i = 0 ; i < rowCount ; i++)
            {
              var mannayoFlexLayer = document.createElement("div");
              mannayoFlexLayer.className = 'mannayo_creator_object_container flex_layer_thumb';
              g_creatorsSearchList_main.append(mannayoFlexLayer);

              var isEnd = false;
              for(var j = 0 ; j < 2 ; j++)
              {
                var creator = creators[index];

                if(list_first_type === TYPE_LIST_FIRST_CREATOR_MAIN_FIND_API){
                  if(!creator.created_at)
                  {
                    creator = creator.snippet;
                  }
                  addCreatorObjectInMainFindApi(creator, mannayoFlexLayer);
                }
                else
                {
                  addCreatorObjectInMain(creator, mannayoFlexLayer);
                }

                
                index++;

                if(index >= creators.length)
                {
                  isEnd = true;
                  break;
                }
              }

              if(isEnd)
              {
                break;
              }
            }

            if(rowCount === 0)
            {
              setSwitchMoreLoading(false, INPUT_KEY_TYPE_ENTER, MAIN_FIND_STATE_NO_LIST);
            }

            $(".result_new_meet_button_in_main").click(function(){
              //메인 새로 만나요 버튼
              if(!isLogin())
              {
                loginPopup(closeLoginPopup, null);
                return;
              }
              var element = $(this);
              openNewMeetPopup(element.attr("data_creator_id"), element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"), TYPE_CREATE_MEETUP);
            });

            $(".result_add_new_creator_button_in_main").click(function(){
              if(!isLogin())
              {
                loginPopup(closeLoginPopup, null);
                return;
              }

              var element = $(this);
              
              requestCreateCreator(element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"));
              openNewMeetPopup('', element.attr("data_creator_title"), element.attr("data_creator_img_url"), element.attr("data_creator_channel_id"), TYPE_CREATE_MEETUP);
            });

            if(list_first_type === TYPE_LIST_FIRST_CREATOR_MAIN_FIND_API)
            {
              addFooter(FIND_TYPE_IN_CHANNEL_MAIN);
            }
            else
            {
              addFooter(FIND_TYPE_IN_API_MAIN);
            }
          }

          setCreatorScrollOption(list_first_type);

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
                  if(!meetup.created_at)
                  {
                    meetup = meetup.snippet;
                  }
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
          setMannayoCancelButton();
        };

        var removeAllList = function(){
          removeCreatorList();
          removeMeetupList();
        };

        var requestFindCreator = function(keyType){
          isPressEnterKey = false;
          hideYoutubeCrollingListCounter();
          searchingOnOff(true);
          if(!$("#input_mannayo_search").val())
          {
            searchingOnOff(false);
            $("#mannayo_search_result_container").hide();
            return;
          }

          if(keyType === INPUT_KEY_TYPE_ENTER)
          {
            isPressEnterKey = true;
            searchingOnOff(false);
            $("#mannayo_search_result_container").hide();
            $('.welcome_content_new_meetup_container').hide();
            requestMannayoList(INPUT_KEY_TYPE_ENTER);
            return;
          }

          var url="/get/creator/find/list";
          var method = 'post';
          var data =
          {
              "title" : $("#input_mannayo_search").val(),
              "keytype" : keyType
          }
          var success = function(request) {
            //if(Number(request.keytype) === INPUT_KEY_TYPE_ENTER)
            //{
            //  return;
            //}
            if(isPressEnterKey)
            {
              return;
            }

            searchingOnOff(false);

            if(request.data.length === 0)
            {
              setCreatorList(request.data, TYPE_LIST_FIRST_FIND_NO);
            }
            else
            {
              setCreatorList(request.data, TYPE_LIST_FIRST_CREATOR);
            }

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
              searchingOnOff(false);
              swal("에러", '크리에이터를 찾지 못했습니다. 다시 시도해주세요.', 'error');
          };

          $.ajax({
          'url': url,
          'method': method,
          'data' : data,
          'success': success,
          'error': error
          });
        };

        var initSearchBar = function(){
          //searchingOnOff(false);
          $("#mannayo_search_result_container").hide();


          var g_keyType = INPUT_KEY_TYPE_NORMAL;
          var callbackSearchRequest = function(){
            requestFindCreator(g_keyType);
          }
          var callbackSearchRequestInfo = null;

          var resetSearchCallbackTimer = function(keyType, ms){
            g_keyType = keyType;
            clearTimeout(callbackSearchRequestInfo);
            callbackSearchRequestInfo = setTimeout(callbackSearchRequest, ms);
          }


          $('#input_mannayo_search').keydown(function(event){
            if (event.which === 13) {
              if(!isMannayoSearchPopup())
              {
                event.preventDefault();
                resetSearchCallbackTimer(INPUT_KEY_TYPE_ENTER, 0);
              }
            }
            else
            {
              resetSearchCallbackTimer(INPUT_KEY_TYPE_NORMAL, INPUT_SEARCH_WAIT_MS);
            }

            //return false;
          });
        };

        initSearchBar();
        //$("#mannayo_search_result_container").show();

        var hideYoutubeCrollingListCounter = function(){
          if(isMannayoSearchPopup()){
            $('.mannayo_searching_loading_container').css('height', '50px');
          }
          else{
            $('.mannayo_searching_loading_container').css('height', '100px');
          }

          $('.mannayo_youtube_crolling_info_container').hide();
          $('.mannayo_youtube_crolling_now_counter').hide();
          $('.mannayo_youtube_crolling_all_counter').hide();
        }

        var setYoutubeCrollingListNowCounter = function(nowCount, allCount){
          $('.mannayo_youtube_crolling_now_counter').text(nowCount + "/" + allCount);
          $('.mannayo_youtube_crolling_now_counter').show();
          $('.mannayo_youtube_crolling_info_container').show();
          $('.mannayo_searching_loading_container').css('height', 'auto');
        };

        var setYoutubeCrollingListAllCounter = function(allCount){
          $('.mannayo_youtube_crolling_all_counter').text(allCount+"명를 발견했어요! 조금만 기다려주세요!");
          $('.mannayo_youtube_crolling_all_counter').show();
          $('.mannayo_youtube_crolling_info_container').show();
          $('.mannayo_searching_loading_container').css('height', 'auto');
        };

        
        var g_youtubeCrollingDataArray = [];
        var youtubeGetCrollingCreatorData = function(channels, channelAllCount, findType){
          var url="/search/creator/find/crolling";
          var method = 'post';
          var data=
          {
            'channels' : channels,
            'channel_all_count' : channelAllCount
          };

          var success = function(request) {
            if(request.state === 'error')
            {
              alert(request.message);
              return;
            }
            var allCount = Number(request.channel_all_count);
            var nowCount = allCount - request.channels.length;

            setYoutubeCrollingListNowCounter(nowCount, allCount);

            g_youtubeCrollingDataArray.push(request.channel);

            if(request.channels.length > 0){
              youtubeGetCrollingCreatorData(request.channels, channelAllCount, findType);
            }
            else{
              //완료
              
              if(findType === FIND_TYPE_IN_API_MAIN)
              {
                if(g_youtubeCrollingDataArray.length === 0){
                  setCreatorList(null, TYPE_LIST_FIRST_FIND_API_NO_MAIN);
                  setSwitchMoreLoading(false, INPUT_KEY_TYPE_ENTER, MAIN_FIND_STATE_NO_LIST_IN_API);
                }
                else{
                  setCreatorList(g_youtubeCrollingDataArray, TYPE_LIST_FIRST_CREATOR_MAIN_FIND_API);
                  removeMannayoListInMain();
                  setSwitchMoreLoading(false, INPUT_KEY_TYPE_ENTER, MAIN_FIND_STATE_FIND_API);
                }

                
              }
              else
              {
                if(g_youtubeCrollingDataArray.length === 0){
                  setCreatorList(null, TYPE_LIST_FIRST_FIND_API_NO);
                  setMeetupList(g_youtubeCrollingDataArray, TYPE_LIST_SECOND_FIND_API);
                }
                else{
                  setCreatorList(null, TYPE_LIST_FIRST_FIND_SUCCESS);
                  setMeetupList(g_youtubeCrollingDataArray, TYPE_LIST_SECOND_FIND_API);
                }

                searchingOnOff(false);
              }

              while(g_youtubeCrollingDataArray.length)
              {
                g_youtubeCrollingDataArray.pop();
              }

              hideYoutubeCrollingListCounter();
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


        var youtubeGetSearchInfo = function(findType){
          if(!$("#input_mannayo_search").val()){
            alert('검색어가 없습니다.');
            return;
          }

          if(findType === FIND_TYPE_IN_API_MAIN)
          {
            setSwitchMoreLoading(true, INPUT_KEY_TYPE_ENTER, MAIN_FIND_STATE_FIND_API);
          }
          else
          {
            searchingOnOff(true);
          }

          var url="/search/creator/api/list";
          var method = 'post';
          var data=
          {
            'searchvalue': $("#input_mannayo_search").val()
          };

          var success = function(request) {
            
            if(request.search_type === YOUTUBE_SEARCH_TYPE_CROLLING)
            {
              //타입이 크롤링이면 유투브 api 횟수 초과 혹은 에러로 인해 크롤링 검색으로 데이터가 왔다.
              if(request.data.length > 0)
              {
                setYoutubeCrollingListNowCounter(0, request.data.length);
                setYoutubeCrollingListAllCounter(request.data.length);
                youtubeGetCrollingCreatorData(request.data, request.data.length, findType);
                return;
              }
            }

            if(findType === FIND_TYPE_IN_API_MAIN)
            {
              if(request.data.length === 0){
                setCreatorList(null, TYPE_LIST_FIRST_FIND_API_NO_MAIN);
                setSwitchMoreLoading(false, INPUT_KEY_TYPE_ENTER, MAIN_FIND_STATE_NO_LIST_IN_API);
              }
              else{
                setCreatorList(request.data, TYPE_LIST_FIRST_CREATOR_MAIN_FIND_API);
                removeMannayoListInMain();
                setSwitchMoreLoading(false, INPUT_KEY_TYPE_ENTER, MAIN_FIND_STATE_FIND_API);
              }

              
            }
            else
            {
              if(request.data.length === 0){
                setCreatorList(null, TYPE_LIST_FIRST_FIND_API_NO);
                setMeetupList(request.data, TYPE_LIST_SECOND_FIND_API);
              }
              else{
                setCreatorList(null, TYPE_LIST_FIRST_FIND_SUCCESS);
                setMeetupList(request.data, TYPE_LIST_SECOND_FIND_API);
              }

              searchingOnOff(false);
            }         
          };

          var error = function(request) {
              //swal("에러", '크리에이터를 찾지 못했습니다. 다시 시도해주세요.', 'error');
              //stopLoadingPopup();
          };

          $.ajax({
            'url': url,
            'method': method,
            'data' : data,
            'success': success,
            'error': error
          });
        };

        var youtubeGetSearchChannelInfo = function(findType){
          var inputURL = '';
          if(findType === FIND_TYPE_IN_CHANNEL_MAIN)
          {
            if(!$(".mannayo_channel_input_in_main").val())
            {
              swal("채널 정보를 입력해주세요.", "", "info");
              return;
            }

            setSwitchMoreLoading(true, INPUT_KEY_TYPE_ENTER, MAIN_FIND_STATE_FIND_API);

            inputURL = $(".mannayo_channel_input_in_main").val();
          }
          else
          {
            if(!$(".mannayo_channel_input").val())
            {
              swal("채널 정보를 입력해주세요.", "", "info");
              return;
            }

            searchingOnOff(true);

            inputURL = $(".mannayo_channel_input").val();
          }
          

          var url="/search/creator/find/crolling/channel";
          var method = 'post';
          var data =
          {
              "url" : inputURL
          }
          var success = function(request) {
            if(request.state === 'error')
            {
              alert(request.message);
              return;
            }

            if(findType === FIND_TYPE_IN_CHANNEL_MAIN)
            {
              if(request.data.length === 0){
                setCreatorList(null, TYPE_LIST_FIRST_FIND_API_NO_MAIN);
              }
              else{
                setCreatorList(request.data, TYPE_LIST_FIRST_CREATOR_MAIN_FIND_API);
                removeMannayoListInMain();
              }

              setSwitchMoreLoading(false, INPUT_KEY_TYPE_ENTER, MAIN_FIND_STATE_FIND_API);
            }
            else
            {
              if(request.data.length === 0){
                setCreatorList(null, TYPE_LIST_FIRST_FIND_API_NO);
                setMeetupList(request.data, TYPE_LIST_SECOND_FIND_API);
              }
              else{
                setCreatorList(null, TYPE_LIST_FIRST_FIND_SUCCESS);
                setMeetupList(request.data, TYPE_LIST_SECOND_FIND_API);
              }

              searchingOnOff(false); 
            }           
          };
          
          var error = function(request) {
              swal("에러", '크리에이터를 찾지 못했습니다. 다시 시도해주세요.', 'error');
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
                  "<div class='input_mannayo_search_img'><img class='search_img' src='{{ asset('/img/icons/svg/ic-search-wh.svg') }}'/></div>" +
                  "<input type='text' id='input_mannayo_search' placeholder='크리에이터 검색' />" +
                "</div>" +
              "</div>" +

              "<div class='mannayo_searching_loading_container'>" +
                "<div class='mannayo_youtube_crolling_info_container mannayo_youtube_crolling_info_container_search'>" +
                  "<p class='mannayo_youtube_crolling_now_counter'></p>" +
                  "<p class='mannayo_youtube_crolling_all_counter'></p>" +
                "</div>" +
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

          g_creatorsSearchList = $("#mannayo_search_result_ul");
          g_meetupSearchList = $("#mannayo_search_result_ready_ul");
          g_footerContainer = $(".mannayo_search_result_find_container");

          setScrollUI(".mannayo_search_result_ul_wrapper");
          setScrollUI(".mannayo_search_result_ready_ul_wrapper");

          initSearchBar();

          setInputAction();
        };

        var addSearchBarPopup = function(targetElement){
          var element = document.createElement("div");
          element.innerHTML =
          "<div class='mannayo_search_container mannayo_search_container_popup'>" +
              "<div class='mannayo_search_input_container mannayo_search_input_container_popup'>" +
                "<div class='flex_layer'>" +
                  "<div class='input_mannayo_search_img input_mannayo_search_img_popup'><img class='search_img search_img_popup' src='{{ asset('/img/icons/svg/ic-search-gray.svg') }}'/></div>" +
                  "<input type='text' id='input_mannayo_search' class='input_mannayo_search_popup' placeholder='크리에이터 검색' />" +
                "</div>" +
              "</div>" +
            //팝업임
              "<div class='mannayo_searching_loading_container mannayo_searching_loading_container_popup'>" +
                "<div class='mannayo_youtube_crolling_info_container mannayo_youtube_crolling_info_container_popup'>" +
                  "<p class='mannayo_youtube_crolling_now_counter'></p>" +
                  "<p class='mannayo_youtube_crolling_all_counter'></p>" +
                "</div>" +
                "<p class='searching'><span>.</span><span>.</span><span>.</span><span>.</span></p>" +
              "</div>" +

              "<div id='mannayo_search_result_container' class='mannayo_search_result_container_popup'>" +
                //<!-- 검색 안에 내용 start -->
                //<!-- 크리에이터 검색 결과 START -->
                "<div class='mannayo_search_result_ul_container'>" +
                  "<div class='mannayo_search_result_ul_wrapper'>" +
                    "<ul id='mannayo_search_result_ul'>" +
                    "</ul>" +
                  "</div>" +
                  //팝업임
                  "<div class='mannayo_result_ul_gradation'>" +
                  "</div>" +
                "</div>" +
                //<!-- 크리에이터 검색 결과 END -->

                //<!-- 이미 만나요 검색 결과 START -->
                //"<div class='mannayo_search_result_line'>" +
                //"</div>" +
                "<p class='mannayo_search_result_ready_label'>이미 있는 만나요</p>" +
                "<div class='mannayo_search_result_ready_ul_container'>" +
                  "<div class='mannayo_search_result_ready_ul_wrapper'>" +
                    "<ul id='mannayo_search_result_ready_ul'>" +
                    "</ul>" +
                  "</div>" +
                  //팝업임
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

          g_creatorsSearchList = $("#mannayo_search_result_ul");
          g_meetupSearchList = $("#mannayo_search_result_ready_ul");
          g_footerContainer = $(".mannayo_search_result_find_container");

          setScrollUI(".mannayo_search_result_ul_wrapper");
          setScrollUI(".mannayo_search_result_ready_ul_wrapper");

          initSearchBar();

          setInputAction();
        };

        //하단 리스트 START
        var addCreateMannayoObject = function(parentElement){
          var mannayoObject = document.createElement("div");
          mannayoObject.className = 'mannayo_thumb_object_container_in_main';
          mannayoObject.innerHTML = 
            "<div class='mannayo_thumb_container' style='margin-right: 20px;'>" +
              "<div class='mannayo_thumb_img_wrapper'>" +
                "<div class='mannayo_thumb_img_resize'>" +
                  "<button class='mannayo_create_button' type='button'>" +
                    "<img class='mannayo_peace_img' src='{{ asset('/img/icons/ic-emoji-wantomeet-peace-64.png') }}' style=''/>" +
                    "<p>새 만나요 만들기</p>" +
                  "</button>" +
                "</div>" +
              "</div>" +
            "</div>";

            parentElement.appendChild(mannayoObject);
        };

        var addMannayoObject = function(meetup, parentElement, index){
          var thumbnail_url = meetup.thumbnail_url;

          var meetupUsersElement = '';
          var meetupUserNames = '';

          var zIndex = meetup.meetup_users.length;
          for(var i = 0 ; i < meetup.meetup_users.length ; i++)
          {
            var meetup_user = meetup.meetup_users[i];
            meetupUsersElement += "<img src='"+meetup_user.user_profile_url+"' class='meetup_users_profile_img' style='z-index:"+zIndex+"'/>";
            zIndex--;

            meetupUserNames += "<li class='text-ellipsize'>"+ meetup_user.user_name +"</li>";
          }

          if(meetup.meet_count >= 4)
          {
            //인원이 4명 초과면 ... 이 나오게 한다.
            meetupUsersElement += "<img src='{{ asset('/img/icons/ic-profile-more-512.png') }}' class='meetup_users_profile_img' style='z-index:"+zIndex+"'/>";
            meetupUserNames += "<li>"+ "외 "+ (Number(meetup.meet_count) - meetup.meetup_users.length)+"명"+"</li>";
          }
          
          var meetupMeetButtonFake = '';
          if(meetup.is_meetup)
          {
            meetupMeetButtonFake = "<button class='mannayo_thumb_meetup_cancel_button_fake' data_meetup_channel_id='"+meetup.channel_id+"' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"' data_meetup_count='"+meetup.meet_count+"' data_comments_count='"+meetup.comments_count+"'>" +
                                "만나요 요청됨" +
                                "</button>";
          }
          else
          {
            meetupMeetButtonFake = "<button class='mannayo_thumb_meetup_button_fake' data_meetup_channel_id='"+meetup.channel_id+"' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"' data_meetup_count='"+meetup.meet_count+"' data_comments_count='"+meetup.comments_count+"'>" +
                                "만나요" +
                                "</button>";
          }

          var meetupMeetButton = '';
          if(meetup.is_meetup)
          {
            meetupMeetButton = "<button class='mannayo_thumb_meetup_cancel_button' data_meetup_channel_id='"+meetup.channel_id+"' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"' data_meetup_count='"+meetup.meet_count+"' data_comments_count='"+meetup.comments_count+"'>" +
                                "</button>";
          }
          else
          {
            meetupMeetButton = "<button class='mannayo_thumb_meetup_button' data_meetup_channel_id='"+meetup.channel_id+"' data_meetup_id='"+meetup.id+"' data_meetup_title='"+ meetup.title +"' data_meetup_where='"+ meetup.where +"' data_meetup_what='"+ meetup.what +"' data_meetup_img_url='"+ meetup.thumbnail_url +"' data_meetup_count='"+meetup.meet_count+"' data_comments_count='"+meetup.comments_count+"'>" +
                                "</button>";
          }

          var containerStyle = '';
          if(index === 0)
          {
            containerStyle = 'margin-right: 20px;';
          }

          var mannayoObject = document.createElement("div");
          mannayoObject.className = 'mannayo_thumb_object_container_in_main';
          mannayoObject.innerHTML = 
            "<div class='mannayo_thumb_container' style='"+containerStyle+"'>" +
              "<div class='mannayo_thumb_img_wrapper'>" +
                "<div class='mannayo_thumb_img_resize'>" +
                  "<img class='mannayo_thumb_img project-img' src='"+thumbnail_url+"'>" +
                  "<div class='thumb-black-mask'>" +
                  "</div>" +
                  "<div class='mannayo_thumb_meet_count'>" +
                    "<img src='{{ asset('/img/icons/svg/ic-meet-join-member-wh.svg') }}' style='margin-right: 4px; margin-bottom: 3px;'/>" + meetup.meet_count + "명 요청중" +
                  "</div>" +

                  "<div class='mannayo_thumb_meet_users_container'>" +
                    meetupUsersElement +
                    "<button class='mannayo_thumb_user_list_thumb_button' data_meetup_id='"+meetup.id+"'>" + 
                    "</button>" +
                  "</div>" +
                "</div>" +
                "<div class='mannayo_thumb_user_name_container mannayo_thumb_user_name_container_"+meetup.id+"'>" +
                  "<div class='mannayo_thumb_user_container_arrow'>" +
                  "</div>" + 
                  "<div class='mannayo_thumb_user_name_ul_container'>" +
                    "<ul>" + 
                      meetupUserNames +
                    "</ul>" +
                  "</div>" +
                "</div>" +
              "</div>" +

              "<div class='mannayo_thumb_title_wrapper'>" +
                meetup.title +
              "</div>" +
              "<div class='text-ellipsize-2 mannayo_thumb_content_container'>" +
                meetup.where+"에서 · " + meetup.what +
              "</div>" +
              "<div class='mannayo_thumb_button_wrapper'>" +
                meetupMeetButtonFake + 
              "</div>" +
              meetupMeetButton +
            "</div>";

            //parentElement.append(mannayoObject);
            parentElement.appendChild(mannayoObject);
        };

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
        }

        var removeMannayoListInMain = function(){
          var mannayoListElement = $(".mannayo_meetup_list_container");
          mannayoListElement.children().remove();
        };


        //원본 START
        var setMannayoList = function(meetups, requestKeyType){
          if(requestKeyType === INPUT_KEY_TYPE_ENTER)
          {
            $('.mannayo_creator_pop_list_title').hide();
            $(".mannayo_creator_list_title").show();
            $('.mannayo_list_container').css("margin-top", '64px');

            $('.mannayo_sort_container').css('margin-top', '0px');
          }
          else
          {
            //$('.mannayo_sort_container').css('margin-top', '41px');
          }

          var mannayoListElement = $(".mannayo_meetup_list_container");
          if(requestKeyType !== INPUT_KEY_TYPE_MORE)
          {
            removeMannayoListInMain();
          }
          
          var rowCount = Math.ceil((meetups.length + 1) / MANNAYO_COLUM_COUNT);
          
          var index = 0;
          for(var i = 0 ; i < rowCount ; i++)
          {
            var mannayoFlexLayer = document.createElement("div");
            mannayoFlexLayer.className = 'mannayo_object_container flex_layer_thumb';
            mannayoListElement.append(mannayoFlexLayer);

            var isEnd = false;

            //2칸씩 flex_layer 해줘야함
            for(var j = 0 ; j < 2 ; j++)
            {
              var objectFlexLayer = document.createElement("div");
              if(j === 1)
              {
                objectFlexLayer.className = 'flex_layer mannayo_flex_second_object';
              }
              else
              {
                objectFlexLayer.className = 'flex_layer';
              }

              mannayoFlexLayer.appendChild(objectFlexLayer);

              for(var k = 0 ; k < 2 ; k++)
              {
                if(i === 0 && j === 0 && k === 0 && g_mannayoCounter === 0 && isPressEnterKey)
                {
                  //처음 오브젝트는 새 만나요 만들기 버튼
                  addCreateMannayoObject(objectFlexLayer);
                }
                else
                {
                  var meetup = meetups[index];
                  if(meetup)
                  {
                    addMannayoObject(meetup, objectFlexLayer, k);
                  }
                  index++;
                }

                if(index >= meetups.length)
                {
                  isEnd = true;
                  break;
                }

                /*
                if(i === 0 && j === 0 && k === 0 && g_mannayoCounter === 0)
                {
                  //처음 오브젝트는 새 만나요 만들기 버튼
                  addCreateMannayoObject(objectFlexLayer);
                }
                else
                {
                  var meetup = meetups[index];
                  if(meetup)
                  {
                    addMannayoObject(meetup, objectFlexLayer, k);
                  }
                  index++;
                }

                if(index >= meetups.length)
                {
                  isEnd = true;
                  break;
                }
                */
              }

              if(isEnd)
              {
                break;
              }
            }

            if(isEnd)
            {
              break;
            }
          }

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

          var setMannayoCreateMeetupButton = function(){
            $(".mannayo_create_button").click(function(){
              if(!isLogin())
              {
                loginPopup(closeLoginPopup, null);
                return;
              }

              removeSearchBar($(".mannayo_search_container_target"));
              openNewMeetPopup('', '', '', '', TYPE_CREATE_MEETUP_NEW);
              addSearchBarPopup($(".meetup_popup_option_creator_info_target"));
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
          setMannayoCreateMeetupButton();
          setMannayoCancelButton();
          setMannayoUserInfoButton();
        };
        //원본END
        
        //원본 START
        //원본END

        var requestMannayoList = function(keyType){
          if(keyType === INPUT_KEY_TYPE_ENTER)
          {
            g_mannayoCounter = 0;
          }
          setSwitchMoreLoading(true, keyType, MAIN_FIND_STATE_NORMAL);

          var callMannayoOnceMaxCounter = CALL_MANNAYO_ONCE_MAX_COUNT
          if(g_mannayoCounter === 0 && isPressEnterKey)
          {
            //처음엔 새만나요 만들기 때문에 첫 요청시에는 11개만 요청해야만 했다.
            callMannayoOnceMaxCounter = CALL_MANNAYO_ONCE_MAX_COUNT - 1;
          }

          var url="/mannayo/list";
          var method = 'get';
          var data =
          {
            "sort_type" : g_sortType,
            "call_once_max_counter" : callMannayoOnceMaxCounter,
            "call_skip_counter" : g_mannayoCounter,
            'keytype' : keyType,
            'searchvalue': $("#input_mannayo_search").val()
          }
          var success = function(request) {
            if(request.state === 'success')
            {
              if(isPressEnterKey && request.keytype === INPUT_KEY_TYPE_NORMAL)
              {
                return;
              }
              
              if(request.meetups.length < callMannayoOnceMaxCounter)
              {
                //length보다 호출된 개수가 작으면 더보기가 없다
                setSwitchMoreLoading(false, request.keytype, MAIN_FIND_STATE_NO_MORE);
              }
              else
              {
                setSwitchMoreLoading(false, request.keytype, MAIN_FIND_STATE_NORMAL);
              }
              
              if(request.keytype === INPUT_KEY_TYPE_ENTER)
              {
                setCreatorList(request.creators, TYPE_LIST_FIRST_CREATOR_MAIN);
              }

              setMannayoList(request.meetups, request.keytype);
              g_mannayoCounter += request.meetups.length;
            }
          };
          
          var error = function(request) {
            setSwitchMoreLoading(false, INPUT_KEY_TYPE_NORMAL, MAIN_FIND_STATE_NORMAL);
            alert('크리에이터 정보 가져오기 실패. 다시 시도해주세요.');
          };
          
          $.ajax({
          'url': url,
          'method': method,
          'data' : data,
          'success': success,
          'error': error
          });
        };

        var openShareCallMeetupPopup = function(){
          if(!$('#share_meetup_info').val())
          {
            return;
          }

          var share_meetup_info_json = $.parseJSON($('#share_meetup_info').val());
          if(share_meetup_info_json)
          {
            var data_meetup_id = share_meetup_info_json.id;
            var data_meetup_title = share_meetup_info_json.creator.title;
            var data_meetup_channel_id = share_meetup_info_json.creator.channel_id;
            var data_meetup_where = share_meetup_info_json.where;
            var data_meetup_what = share_meetup_info_json.what;
            var data_meetup_img_url = share_meetup_info_json.creator.thumbnail_url;
            var data_meetup_count = share_meetup_info_json.meet_count;
            var data_meetup_comments_count = share_meetup_info_json.comments_count;
            openMeetPopup(data_meetup_channel_id, data_meetup_id, data_meetup_title, data_meetup_where, data_meetup_what, data_meetup_img_url, data_meetup_count, data_meetup_comments_count);
          }
        };

        var shareCallMeetupPopup = function(){
          if(!isLogin())
          {
            loginPopup(shareCallMeetupPopup, null);
            return;
          }

          callUserInfo(openShareCallMeetupPopup);
        };

        if($('#share_channel_id').val()){
          $("#input_mannayo_search").val($('#share_channel_id').val());
          requestMannayoList(INPUT_KEY_TYPE_ENTER);
          $("#input_mannayo_search").val('');
        }
        else if($('#share_meetup_info').val()){
          if($('#share_meetup_info').val() === 'none'){
            alert('크리에이터의 만나요가 없습니다!');
            requestMannayoList(INPUT_KEY_TYPE_NORMAL);
          }
          else{
            shareCallMeetupPopup();
            requestMannayoList(INPUT_KEY_TYPE_NORMAL);
          }
        }
        else{
          requestMannayoList(INPUT_KEY_TYPE_NORMAL);
        }

        $("#mannayo_list_more_button").click(function(){
          requestMannayoList(INPUT_KEY_TYPE_MORE);
        });
        //하단 리스트 END

        var setSortMannayoText = function(optionValue){
          $("#mannayo_sort_fake_text").text(sortTypes[optionValue]);
          $(".mannayo_sort_select").val(optionValue);
        };

        setSortMannayoText(g_sortType);

        $(".mannayo_sort_select").change(function(){
          var optionValue = Number($(this).val());
          
          //$("#mannayo_sort_fake_text").text(sortTypes[optionValue]);
          setSortMannayoText(optionValue);
          g_sortType = optionValue;
          g_mannayoCounter = 0;

          if($('.mannayo_search_result_find_container_main').css("display") === 'none')
          {
            requestMannayoList(INPUT_KEY_TYPE_NORMAL);
          }
          else
          {
            requestMannayoList(INPUT_KEY_TYPE_ENTER);   
          }
          
        });

        var setInputAction = function(){
          $('#input_mannayo_search').click(function(){
            $('.search_img').css('opacity', '1');
          });

          $('#input_mannayo_search').focusout(function(){
            $('.search_img').css('opacity', '0.5');
          });
        };

        setInputAction();

        $(window).bind('scroll', function(){
          if($('.mannayo_list_more_button').is(':visible'))
          {
            var lastObjectName = '.mannayo_meetup_list_end_fake_offset';
            var lastObjectTop = $(lastObjectName).offset().top;
            var targetObjectTop = $(window).scrollTop() + $(window).height();

            if(lastObjectTop < targetObjectTop)
            {
              requestMannayoList(INPUT_KEY_TYPE_MORE);
            }
          }
        });
      });

    </script>
    
@endsection