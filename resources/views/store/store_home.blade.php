@extends('app')

@section('meta')
  <meta property="og:type" content="website"/>
  <meta property="og:title" content="크티 | 콘텐츠 상점"/>
  <meta property="og:description" content="내가 좋아하는 크리에이터가 만들어주는 나만을 위한 콘텐츠, 크티 콘텐츠 상점"/>
  <meta property="og:image" content="{{ asset('/img/app/og_image_3.png') }}"/>  
@endsection

@section('title')
    <title>크티 | 콘텐츠 상점</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

  <link href="{{ asset('/dist/css/StoreHome.css?version=5') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreContentsListItem.css?version=2') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/StoreHomeStoreListItem.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Popup_progress.css?version=0') }}" rel="stylesheet"/>
  
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_PAGE_KEY_STORE_HOME'/>

@endsection

@section('js')
@endsection
