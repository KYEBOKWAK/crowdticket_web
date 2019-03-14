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

    </style>
@endsection

@section('content')

<div class="magazine_title_wrapper">
    <img class="magazine_title_img" src="https://s3-ap-northeast-1.amazonaws.com/crowdticket0/newtest/maincarousel/yell.jpg"/>
  <div class="black-mask"></div>
  <p class="magazine_title">크라우드티켓 매거진</p>
</div>


<div class="magazine_container">
  @foreach($magazines as $magazine)
    @include('template.magazine_thumb', ['magazine' => $magazine])
  @endforeach

  @if (\Auth::check() && \Auth::user()->isAdmin())
    <button id="go_write_magazine" class="btn btn-success center-block project_form_button">글쓰기</button>
  @endif
</div>

@endsection

@section('js')
<script>
$(document).ready(function () {

  $("#go_write_magazine").click(function(){
     window.location.href = $("#base_url").val() + "/magazine/write"
  });
  //var titleDotMaxLen = 30;
  //replacedotStr()
  //$('.magazine_thumb_content_title').val()
});
</script>
@endsection
