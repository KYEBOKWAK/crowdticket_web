@extends('app')

@section('title')
    <title>크티 | 콘텐츠 상점</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

  <link href="{{ asset('/dist/css/App_Category.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Category_Top_Carousel.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/alice-carousel.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Category_Top_Carousel_Item.css?version=2') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Category_Result_List.css?version=3') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Container_Item.css?version=3') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Tag_Thumb_Item.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Product_Label.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Profile.css?version=2') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Category_Creator_List.css?version=2') }}" rel="stylesheet"/>
  
  <link href="{{ asset('/dist/css/Popup_category_filter.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Popup_category_sort.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Popup_category_info.css?version=1') }}" rel="stylesheet"/>
  
@endsection

@section('react_main')
<input id='app_page_key' type='hidden' value='WEB_PAGE_CATEGORY'/>

<input id='category_top_item_id' type='hidden' value='{{$category_top_item_id}}' />

<div id="react_app_category_page"></div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/dist/App_Category.js?version=16') }}"></script>
@endsection
