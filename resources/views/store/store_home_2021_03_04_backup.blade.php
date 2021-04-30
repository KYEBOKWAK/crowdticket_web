@extends('app')

@section('meta')
  <meta property="og:type" content="website"/>
  <meta property="og:title" content="크티 | 콘텐츠 상점"/>
  <meta property="og:description" content="내가 좋아하는 크리에이터가 만들어주는 나만을 위한 콘텐츠, 크티 콘텐츠 상점"/>
  <meta property="og:image" content="{{ asset('/img/app/og_image_3.png') }}"/>  
@endsection

@section('title')
    <title>크티</title>
@endsection

@section('css')
  <style>
  #main{
    /* display: none; */
    min-height: unset;
  }

  .welcome_start_banner{
    position: relative;
    height: 320px;
    background: linear-gradient(to right, #3bd0ef, #9f83fa 24%, #c72ffd 59%, #e891b7 86%, #f7948f);
  }

  .welcome_start_banner_content_container{
    /*width:1080px;
    margin-left: auto;
    margin-right: auto;*/
    position: relative;
    top: 82px;
    font-size: 28px;
    font-weight: 500;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.38;
    letter-spacing: normal;
    color: #ffffff;
  }

  .welcome_start_content_container{
    width:1060px;
    height: 100%;
    margin-left: auto;
    margin-right: auto;
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

  .welcome_start_bubble_container{
    position: absolute;
    width: 100%;
    height: 320px;
    overflow: hidden;
  }

        

  @media (max-width:1060px) {
    .welcome_start_banner_content_container{
      font-size: 28px;
      font-weight: 500;
      line-height: 1.29;
    }

    .welcome_start_content_container{
      margin-left: 8%;
      width: 70%;
    }

    .welcome_start_button{
      width: 107px;
      height: 51px;
      background-color: white;
      color: #b652fb;
      font-size: 18px;
    }
  }

  @media (max-width: 768px){
    .welcome_start_banner_content_container{
      top: 50px;
    }

    .welcome_start_button_container {
      top: 110px;
    }
  }

  @media (max-width: 381px){
    .welcome_start_button_container {
      top: 85px;
    }
  }
  </style>

  <link href="{{ asset('/dist/css/StoreHome.css?version=8') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreContentsListItem.css?version=5') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/StoreHomeStoreListItem.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Popup_progress.css?version=0') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_list.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Popular_item.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/alice-carousel.css?version=0') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Product_Label.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Recommend_Creator_List.css?version=0') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Tag.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Attention_Item.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Container_List.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Container_Item.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Stores_Item.css?version=1') }}" rel="stylesheet"/>
  
  <link href="{{ asset('/css/bubble.css?version=1') }}" rel="stylesheet"/>
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_PAGE_KEY_STORE_HOME'/>
<div class="welcome_start_banner_container">
  <div class="welcome_start_banner">
      <div class="welcome_start_bubble_container">
      </div>

      <div class="welcome_start_content_container">
        <div class="welcome_start_banner_content_container">
          <b>크리에이터라면,<br>지금바로 콘텐츠상점에 입점해보세요!</b>
        </div>

        <div class="welcome_start_button_container">
          <a href="https://forms.gle/vRiirC1mdfgUbZLt5" target="_blank">
            <button type="button" class="welcome_start_button">입점신청</button>
          </a>
        </div>
      </div>
  </div>
</div>

@endsection

@section('js')
<script>
  $(document).ready(function () {
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
  })
</script>
@endsection
