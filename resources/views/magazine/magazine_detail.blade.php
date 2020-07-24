@extends('app')

@section('meta')
  <meta property="og:image" content="{{ $magazine->thumb_img_url }}"/>
  <meta property="og:title" content="크티 : 크라우드티켓 매거진"/>
  <meta property="og:description" content="{{ $magazine->title }}"/>
@endsection

@section('title')
  <title>{{ $magazine->title }}</title>
@endsection

@section('css')
    <style>
    .magazine_title_wrapper{
      /*
      width: 100%;
      margin-bottom: 20px;
      position: relative;
      overflow: hidden;
      */

      width: 100%;
      margin-bottom: 20px;
      position: absolute;
      overflow: hidden;
    }

    .magazine_title{
      /*
      font-size: 18px;
      font-weight: bold;
      color: white;
      margin-bottom: 60px;
      */

      font-weight: bold;
      font-size: 19px;
      color: white;

      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      line-height: 26px;     /* fallback */
      max-height: 51px;      /* fallback */
      -webkit-line-clamp: 2; /* number of lines to show */
      -webkit-box-orient: vertical;
      margin-bottom: 60px;

      word-break: break-all;
    }

    .magazine_title_img{
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

    .magazine_container{
      width: 620px;
      margin-left: auto;
      margin-right: auto;
      position: relative;
      top: 290px;
      margin-bottom: 310px;
    }
    .magazine_thumbnail_container{
      /*width: 90%;*/
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      margin-bottom: 20px;
    }
    .magazine_thumbnail_image_wrapper{
      /*width: 100%;*/
      width: 320px;
    }

    .magazine_thumb_content_container{
      width: 310px;
      padding-left: 32px;
      word-break: break-all;
    }

    .magazine_thumb_content_title{
      font-weight: bold;
      font-size: 19px;

      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      line-height: 27px;     /* fallback */
      max-height: 51px;      /* fallback */
      -webkit-line-clamp: 2; /* number of lines to show */
      -webkit-box-orient: vertical;
      margin-top: 5px;
    }

    .magazine_thumb_content_content{
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      line-height: 18px;     /* fallback */
      max-height: 40px;      /* fallback */
      -webkit-line-clamp: 2; /* number of lines to show */
      -webkit-box-orient: vertical;
      margin-top: 30px;
    }

    .magazine_story_wrapper{

    }

    .magazine_story_wrapper{
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }

    .magazine_control_container{
      width: 136px;
      margin-left: auto;
      margin-right: auto;
      margin-top: 20px;
    }

    .magazine_title_img_wrapper{
      width: 100%;
    }

    .magazine_title_image_container{
      /*width: 320px;*/
      width: 100%;
      height: 350px;
      margin-left: auto;
      margin-right: auto;
      overflow: hidden;
    }

    .mannayo_banner_container{
      margin-top: 64px;
      margin-bottom: 44px;
      margin-left: auto;
      margin-right: auto;
    }

    .mannayo_banner_img{
      width: 100%;
    }

    .mannayo_banner_img_pc{
      border-radius: 10px;
    }

    .mannayo_banner_img_mobile{
      display: none;
    }

    @media (max-width:640px) {
      .magazine_container{
        width: 100%;
        padding: 0px 15px;
      }

      .mannayo_banner_container{
        margin-top: 40px;
        margin-bottom: 0px;
      }

      .mannayo_banner_img_pc{
        display: none;
      }
      .mannayo_banner_img_mobile{
        display: block;
      }
    }

    </style>

    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-lite.css?version=1') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-crowdticket.css?version=3') }}"/>
@endsection

@section('content')

<div class="magazine_title_wrapper">
  <div class="magazine_title_image_container">
    <div class="bg-base magazine_title_img_wrapper">
      @if($magazine->title_img_url)
        <img class="magazine_title_img" src="{{$magazine->title_img_url}}" onload="resizeMagazineTitleImgOnLoad();"/>
      @else
        <img class="magazine_title_img" src="{{$magazine->thumb_img_url}}" onload="resizeMagazineTitleImgOnLoad();"/>
      @endif

    </div>
  </div>

  <div class="black-mask"></div>
</div>

<div class="magazine_container">
  <p class="magazine_title">{{$magazine->title}}</p>

  <div class="magazine_story_wrapper">
    @if (\Auth::check() && \Auth::user()->isAdmin())
    조회수 : {{$magazine->view_count}}
    @endif

   {!! html_entity_decode($magazine->story) !!}
  </div>

  <div class='mannayo_banner_container'>
    <a href="{{url('/mannayo')}}" target='_blank'>
      <img class='mannayo_banner_img mannayo_banner_img_pc' src='https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/190806_meet_banner_wide.png'>
      <img class='mannayo_banner_img mannayo_banner_img_mobile' src='https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/190806_meet_banner.png'>
    </a>
  </div>
</div>

@if (\Auth::check() && \Auth::user()->isAdmin())
  <div class="magazine_control_container">
    <div class="flex_layer">
      <button id="modify_story" data-magazine-id="{{$magazine->id}}" type="button" class="btn btn-success center-block project_form_button">수정</button>
      <button id="delete_story" data-magazine-id="{{$magazine->id}}" type="button" class="btn btn-success center-block project_form_button">삭제</button>
    </div>
  </div>
@endif


@endsection

@section('js')
<script>
$(document).ready(function () {
  var deleteMagazine = function(){
    showLoadingPopup('삭제중입니다..');
    var magazineId = $("#delete_story").attr("data-magazine-id");

    var url = '/magazine/'+ magazineId +'/delete';
    var method = 'delete';

    var success = function(e) {
      stopLoadingPopup();
      if(e.state == 'fail')
      {
        swal("삭제 실패.", e.message, "error");
      }
      else
      {
        swal("삭제 성공.", "", "success").then(function(){
          var base_url = window.location.origin;

          window.location.href = base_url + "/magazine";
        });
      }
    };
    var error = function(e) {
      stopLoadingPopup();
      swal("삭제 실패.", "관리자만 삭제할 수 있습니다.", "error");
    };

    $.ajax({
      'url': url,
      'method': method,
      'success': success,
      'error': error
    });
  };

  $("#delete_story").click(function(){
    swal("정말 삭제 하시겠습니까?", "", "warning", {
				  buttons: {
				    save: {
				      text: "삭제",
				      value: "delete",
				    },

            nosave: {
			      text: "취소",
			      value: "cancel",
			    },
				  },
				}).then(function(value){
          if(value == 'delete')
          {
            deleteMagazine();
          }

				});
  });

  $('#modify_story').click(function(){
    var magazineId = $('#modify_story').attr('data-magazine-id');
    var base_url = window.location.origin;

    window.location.href = base_url + "/magazine/" + magazineId + "/modify";
  });

  var resizeTitleImg = function(){
    var parentData = $('.magazine_title_image_container')[0];
    var imgData = $('.magazine_title_img')[0];

    var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);

    if(targetWidth <= window.innerWidth)
    {
      $('.magazine_title_img').css('width', '100%');
      $('.magazine_title_img').css('height', 'auto');
    }
    else
    {
      $('.magazine_title_img').css('width', targetWidth);
      $('.magazine_title_img').css('height', parentData.clientHeight);
    }
  };

  //resizeTitleImg();

  $(window).resize(function() {
		//console.error("adf");
    resizeTitleImg();
  });
});
</script>
@endsection
