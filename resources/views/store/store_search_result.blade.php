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
    display: none;
    /* min-height: unset; */
  }
  </style>

  <link href="{{ asset('/dist/css/Home_Thumb_list.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Popular_item.css?version=2') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Tag_Thumb_Item.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/alice-carousel.css?version=0') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Product_Label.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Recommend_Creator_List.css?version=1') }}" rel="stylesheet"/>

  <!-- <link href="{{ asset('/dist/css/Home_Thumb_Tag.css?version=1') }}" rel="stylesheet"/> -->
  <link href="{{ asset('/dist/css/Home_Thumb_Attention_Item.css?version=2') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Container_List.css?version=2') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Container_Item.css?version=3') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Stores_Item.css?version=2') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/SearchResultPage.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Find_Result_Stores_item.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Home_Thumb_Container_Project_Item.css?version=2') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Thumb_Recommend_item.css?version=1') }}" rel="stylesheet"/>
  

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_PAGE_KEY_STORE_SEARCH_RESULT'/>
<input id='search_result' type='hidden' value={{$search}} />
@endsection

@section('js')
@endsection
