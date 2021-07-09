@extends('app')

@section('meta')
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="크티 | 이벤트"/>
    <meta property="og:description" content="내가 좋아하는 크리에이터의 나만을 위한 콘텐츠, 콘텐츠 상점"/>
    <meta property="og:image" content="{{ asset('/img/app/og_image_4.png') }}"/>
    <meta name="description" content="내가 좋아하는 크리에이터의 나만을 위한 콘텐츠, 콘텐츠 상점"/>
@endsection

@section('title')
    <title>크티 | 이벤트</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

  <link href="{{ asset('/dist/css/ReactToastify.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/App_Event.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Container_Item.css?version=3') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Tag_Thumb_Item.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Product_Label.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Home_Thumb_Tag.css?version=1') }}" rel="stylesheet"/>
  

@endsection

@section('content')


@endsection

@section('react_main')
<input id='app_page_key' type='hidden' value='WEB_EVENT_PAGE'/>
<input id='event_alias' type='hidden' value='{{$alias}}'/>

<div id="react_app_event_page"></div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/dist/App_Event.js?version=4') }}"></script>
@endsection
