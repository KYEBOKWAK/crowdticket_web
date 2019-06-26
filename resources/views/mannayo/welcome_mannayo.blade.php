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

        .mannayo_search_container{
          width: 70%;
          margin-left: auto;
          margin-right: auto;
        }

        .mannayo_search_content_container{
          height: 150px;
          overflow-y: auto;
          margin-top: 30px;
          border: 1px solid black;
        }

        .creator_thumbnail_img{
          width: 80px;
          height: 80px;
          border-radius: 50%;
        }

        /*

        ::-webkit-scrollbar {
          width: 8px;
        }

        ::-webkit-scrollbar-track {
          -webkit-box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.3);
          border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb {
          border-radius: 10px;
          background-color: rgba(0, 0, 0, 0.3);
        }
        */

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

<link href="{{ asset('/css/simple-scrollbar.css?version=1') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="welcome_content_container">
      <div class="welcome_content_wrapper">
        <div class="mannayo_search_container">
            <label>검색할 크리에이터를 입력해주세요.</label>
            <input type="text" id="input_find_creator" class="form-control" placeholder="크리에이터를 찾아보세요" />
            
            <div class="mannayo_search_content_container">
              <ul id="mannayo_search_list_ul">
                <li>adfasdfsdf3333</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf</li>
                <li>adfasdfsdf11111</li>
              </ul>
            </div>
            
            
            <div class="mannayo_find_youtube_container" style="display: none;">
              <div style='margin-top: 30px;'>찾는 크리에이터가 없나요? 크라우드티켓이 찾아드릴께요!</div>
              <button type='button' id='find_creator_api_button' class='btn btn-default btn-outline'>찾아주세요!!</button>
            </div>
            <div class="mannayo_search_content_container">
              <ul id="mannayo_search_list_api_ul">
              </ul>
            </div>
            <div class="mannayo_find_youtube_channel_container" style="display: none;">
              <div style='margin-top: 30px;'>
                찾아도 안나오나요?? 이런.. 그렇다면 직접 찾아보아요~!
              </div>
              <input type="text" id="input_find_creator_channel" class="form-control" placeholder="https://www.youtube.com/channel/UCdD6uPaV3eR95r06R1VgaAA" />
              <button type='button' id='find_creator_channel_button' class='btn btn-default btn-outline'>찾아주세요!!</button>
            </div>
        </div>
      </div>
    </div>
 
@endsection

@section('js')
<script src="{{ asset('/js/simple-scrollbar.js?version=1') }}"></script>
    <script>
        $(document).ready(function () {
          var g_creatorsSearchList = $("#mannayo_search_list_ul");
          var g_creatorsSearchApiList = $("#mannayo_search_list_api_ul");

          var removeCreatorListInApi = function(){
            g_creatorsSearchApiList.children().remove();
          }

          var setCreatorListInApi = function(data){
            removeCreatorListInApi();
            for(var i = 0 ; i < data.length ; ++i)
            {
                //snippet.channelTitle
                var creator = data[i].snippet;

                var img = "<img class='creator_thumbnail_img' src='"+creator.thumbnails.default.url+"'>";

                var element = document.createElement("tr");
                element.innerHTML =
                "<div class='flex_layer' style='margin-top: 20px;'>" + 
                  "<div style='margin-right: 20px;'>"+img+"</div>" +
                  "<div style='margin-right: 20px;'>"+creator.channelTitle+"</div>" +
                  "<div style='margin-right: 20px;'>"+ creator.description +"</div>" + 
                  "<div style='margin-right: 20px;'>"+ creator.channelId +"</div>" + 
                  "<div style='margin-right: 20px;'>"+ "추가하면 보임" +"</div>" + 
                  "<div style='margin-right: 20px;'>"+ "선택하기" +"</div>" +
                "</div>";
                

                g_creatorsSearchApiList.append(element);
            }

            $('.mannayo_find_youtube_channel_container').show();
            
          };

          var youtubeGetSearchInfo = function(){
            showLoadingPopup("크리에이터를 찾는 중 입니다..!");

            var url="/search/creator/api/list";
            var method = 'post';
            var data=
            {
              'searchvalue': $("#input_find_creator").val()
            };

            var success = function(request) {
                stopLoadingPopup();
                //console.error(request);
                setCreatorListInApi(request.data);
                //console.error(JSON.stringify(request));
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

          var setFindCreatorApiButton = function(){
            $("#find_creator_api_button").click(function(){
              if(!$("#input_find_creator").val())
              {
                  swal("크리에이터를 입력해주세요!", "", "error");
                  return;
              }
              
              youtubeGetSearchInfo();
            });
          };

          var removeCreatorTableData = function(){
            g_creatorsSearchList.children().remove();
          };
          var setCreatorList = function(creators){
              removeCreatorTableData();
              for(var i = 0 ; i < creators.length ; ++i)
              {
                  var creator = creators[i];

                  var img = "<img class='creator_thumbnail_img' src='"+creator.thumbnail_url+"'>";

                  var element = document.createElement("li");
                  element.innerHTML =
                  "<div class='flex_layer' style='margin-top: 20px;'>" + 
                    "<div style='margin-right: 20px;'>"+img+"</div>" +
                    "<div style='margin-right: 20px;'>"+creator.title+"</div>" +
                    "<div style='margin-right: 20px;'>"+ creator.channel_id +"</div>" + 
                    "<div style='margin-right: 20px;'>"+ addComma(creator.subscriber_count) +"</div>" + 
                    "<div style='margin-right: 20px;'>"+ "선택하기" +"</div>" +
                  "</div>";
                  
                  g_creatorsSearchList.append(element);
              }

              if($("#input_find_creator").val())
              {
                $('.mannayo_find_youtube_container').show();
              }

              setFindCreatorApiButton();
              
          };

          var requestFindCreator = function(){
              var url="/get/creator/find/list";
              var method = 'post';
              var data =
              {
                  "title" : $("#input_find_creator").val()
              }
              var success = function(request) {
                  //console.error(request);
                  setCreatorList(request.data);
                  //console.error(JSON.stringify(request));
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

          $('#input_find_creator').keyup(delay(function (e) {
              //console.log('Time elapsed!', this.value);
              requestFindCreator();
          }, 300));

        });

        var el = document.querySelector('.mannayo_search_content_container');
          SimpleScrollbar.initEl(el);
    </script>
    
@endsection