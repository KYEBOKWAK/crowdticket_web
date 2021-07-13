@extends('app')

@section('title')
    <title>크티 | 팬 이벤트</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }

  .carousel_creator_container{
    display: none;
    /* height: 235px; */
    /* height: 235px; */
    height: 390px;
    /* margin-top: 20px; */
    background-color: #fafafa;
  }

  .carousel_bottom_box {
    width: 100%;
    height: 80px;
    background-color: #fafafa;
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

  .creator_slide_container{
    position:absolute; 
    /* width:90%; */
    width:85%;
    height:auto; 
  }

  .swiper-slide{
    background: none;
  }

  .thumb-black-mask{
    /* display: none; */
    width:100%;
    height:50%;
    position:absolute;
    bottom:0;
    /* background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.3)); */
    background-image: linear-gradient(to bottom, rgba(54, 54, 54, 0), rgba(25, 25, 25, 0.5));
    border-radius: 4px;
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

  .Footer_React {
    padding-top: 0px !important;
  }

  @media (max-width: 2793px) {
    .carousel_creator_container{
      height: 345px;
    }
  }

  @media (max-width: 2125px) {
    .carousel_creator_container{
      height: 280px;
    }
  }

  @media (max-width: 1176px) {
    .carousel_bottom_box {
      height: 72px;
    }
  }

  @media (max-width:768px) {
    .creator_slide_container{
      margin-top: 0px !important;
    }

    .carousel_creator_container{
      /* margin-top: -37px; */
      height: 190px;
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

    .carousel_bottom_box {
      height: 48px;
    }
  }
  </style>
  
  <link href="{{ asset('/dist/css/App_Fan_Event.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Thumb_Project_Item.css?version=2') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_list.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/alice-carousel.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Tag.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Fan_Project_List.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Container_Project_Item.css?version=2') }}" rel="stylesheet"/>

  <link rel="stylesheet" href="{{ asset('/css/swiper/swiper.min.css?version=1') }}"/>
  
  
@endsection

@section('react_main')
<input id='app_page_key' type='hidden' value='WEB_PAGE_FAN_EVENT'/>

<div id="react_app_fan_event_page"></div>

<div class="carousel_creator_container">
    @include('template.carousel_creator_new', ['project' => ''])
</div>

<div class="carousel_bottom_box">
</div>

@endsection

@section('js')
<script src="{{ asset('/js/swiper/swiper.min.js?version=1') }}"></script>
<script type="text/javascript" src="{{ asset('/dist/App_Fan_Event.js?version=19') }}"></script>

@endsection
