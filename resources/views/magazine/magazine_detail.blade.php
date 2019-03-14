@extends('app')

@section('css')
    <style>
    .magazine_title_wrapper{
      width: 100%;
      margin-bottom: 20px;
      position: relative;
    }

    .magazine_title{
      /*
      position: absolute;
      top: 70%;
      left: 14%;
      font-size: 18px;
      font-weight: bold;
      */
      position: absolute;
      top: 80%;
      left: 20%;

      font-size: 18px;
      font-weight: bold;
      color: white;

    }

    .magazine_title_img{
      width:100%;
      max-height: 300px;
    }

    .magazine_container{
      width: 620px;
      margin-left: auto;
      margin-right: auto;
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
    .magazine-thumbnail {
      position:relative;
      /*padding-top:75%;*/
      padding-top:40%;
      overflow:hidden;
      background-color: white;
    }

    .magazine-img {
      position:absolute;
      top:0;
      left:0;
      right:0;
      bottom:0;
      max-width:100%;
      margin: auto;
    }

    .magazine_thumb_content_container{
      width: 310px;
      padding: 0px 10px;
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

    </style>
@endsection

@section('content')

<div class="magazine_title_wrapper">
    <img class="magazine_title_img" src="{{$magazine->title_img_url}}"/>
  <div class="black-mask"></div>
  <p class="magazine_title">{{$magazine->title}}</p>
</div>

<div class="magazine_container">
  <div class="magazine_story_wrapper">
   {!! html_entity_decode($magazine->story) !!}
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
});
</script>
@endsection
