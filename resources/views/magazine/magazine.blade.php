@extends('app')

@section('css')
    <style>
    .magazine_title_wrapper{
      width: 100%;
      margin-bottom: 20px;
      position: absolute;
      overflow: hidden;
    }

    .magazine_title{
      font-size: 18px;
      font-weight: bold;
      color: white;
      margin-bottom: 75px;
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
      /*width: 620px;*/
      width: 710px;
      margin-left: auto;
      margin-right: auto;
      position: relative;
      top: 290px;
      margin-bottom: 290px;
    }
    .magazine_thumbnail_container{
      /*width: 90%;*/
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      margin-bottom: 35px;
    }
    .magazine_thumbnail_image_wrapper{
      /*width: 100%;*/
      width: 50%;
    }
    .magazine-thumbnail {
      position:relative;
      /*padding-top:75%;*/
      padding-top:56.25%;
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
      width: 50%;
      padding: 0px 10px;
      word-break: break-all;
    }

    .magazine_thumb_content_title{
      font-weight: 500;
      font-size: 20px;

      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      line-height: 26px;     /* fallback */
      max-height: 51px;      /* fallback */
      -webkit-line-clamp: 2; /* number of lines to show */
      -webkit-box-orient: vertical;
    }

    .magazine_thumb_content_content{
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      line-height: 20px;
      max-height: 100px;
      -webkit-line-clamp: 5;
      -webkit-box-orient: vertical;
      margin-top: 15px;
      font-weight: 400;
      font-size: 13px;
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

    .magazine_thumb_date{
      font-size: 14px;
      color: #777;
      margin-top: 15px;
      font-weight: 400;
    }
/*
    @media (max-width:720px) {
    	.magazine_container{
    		width: 100%;
        padding: 0px 20px;
    	}

      .magazine_thumb_content_title{
        font-size: 17px;
      }

      .magazine_thumb_content_content{
        margin-top: 7%;
        font-size: 12px;
      }
    }
*/

    @media (max-width:720px) {
      .magazine_container{
        width: 100%;
        padding: 0px 20px;
      }

      .magazine_thumb_content_content{
        margin-top: 2%;
        -webkit-line-clamp: 5;
      }

      .magazine_thumb_date{
        margin-top: 2%;
      }
    }

    @media (max-width:670px) {
      .magazine_thumb_content_content{
        -webkit-line-clamp: 4;
      }

      .magazine_thumb_content_content{
        font-size: 12px;
      }

      .magazine_thumb_date{
        font-size: 12px;
      }

      .magazine_thumb_content_title{
        font-size: 18px;
      }
    }

    @media (max-width:590px) {
      .magazine_thumb_content_content{
        -webkit-line-clamp: 2;
      }

      .magazine_thumb_content_content{
        font-size: 12px;
      }

      .magazine_thumb_date{
        font-size: 12px;
      }

      .magazine_thumb_content_title{
        font-size: 18px;
      }
    }

    @media (max-width:450px) {
      .magazine_thumb_content_title{
        font-size: 14px;
        line-height: 18px;
      }

      .magazine_thumb_content_content{
        margin-top: 4%;
        font-size: 10px;
        line-height: 13px;
        -webkit-line-clamp: 2;
      }

      .magazine_thumb_date{
        font-size: 9px;
        margin-top: 4%;
      }

      .magazine_title{
        margin-bottom: 55px;
      }

      .magazine_thumbnail_container{
        margin-bottom: 20px;
      }
    }

    @media (max-width:320px) {
      .magazine_thumb_content_title{
        font-size: 11px;
        line-height: 13px;
      }

      .magazine_thumb_content_content{
        margin-top: 5%;
        font-size: 10px;
        line-height: 13px;
        -webkit-line-clamp: 2;
      }

      .magazine_thumb_date{
        font-size: 9px;
        margin-top: 5px;
      }

      .magazine_title{
        margin-bottom: 55px;
      }

      .magazine_thumbnail_container{
        margin-bottom: 20px;
      }
    }

    </style>
@endsection

@section('content')

<div class="magazine_title_wrapper">
  <div class="magazine_title_image_container">
    <div class="bg-base magazine_title_img_wrapper">
      <img class="magazine_title_img" src="https://s3-ap-northeast-1.amazonaws.com/crowdticket0/newtest/magazine/maintitle/maintitle.jpg"/>
    </div>
  </div>

  <div class="black-mask"></div>
</div>

<div class="magazine_container">
  <p class="magazine_title">크라우드티켓 매거진</p>

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

  var resizeTitleImg = function(){
    var parentData = $('.magazine_title_image_container')[0];
    var imgData = $('.magazine_title_img')[0];
    //console.error('nowWidth: ' + data.width + 'nowHeight: ' + data.height);
    //console.error('oriWidth: ' + data.naturalWidth + 'oriHeight: ' + data.naturalHeight);

    var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);

    //console.error(window.innerWidth);

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

  resizeTitleImg();

  $(window).resize(function() {
    //console.error("adf");
    resizeTitleImg();
  });

  $('.magazine_subtitle_data').each(function(){
    var magazineId = $(this).attr("data-magazine-id");
    var magazineContentClassName = '.magazine_thumb_content_content_'+magazineId;

    var converterData = getConverterEnterString($(this).val());

    $(magazineContentClassName).append(converterData);

  });
});

</script>
@endsection
