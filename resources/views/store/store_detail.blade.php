@extends('app')

@section('meta')
  <meta property="og:type" content="website"/>
  <meta property="og:title" content="크티 | {{$store_user_nick_name}} 콘텐츠 상점"/>
  <meta property="og:description" content="{{$store_content}}"/>
  <meta property="og:image" content="{{ asset('/img/app/og_image_3.png') }}"/>  
@endsection

@section('title')
    <title>크티 | {{$store_user_nick_name}} 콘텐츠 상점</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

  <link href="{{ asset('/dist/css/StoreDetailPage.css?version=5') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreContentsListItem.css?version=2') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreReviewList.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreReviewItem.css?version=2') }}" rel="stylesheet"/>
  
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_PAGE_DETAIL'/>
<input id='store_id' type='hidden' value='{{$store_id}}'/>
<input id='store_alias' type='hidden' value='{{$store_alias}}'/>
<input id='store_detail_tabmenu' type='hidden' value='{{$tabmenu}}'/>

@endsection

@section('js')
@endsection
