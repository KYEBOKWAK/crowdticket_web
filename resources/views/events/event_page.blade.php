@extends('app')

@section('meta')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="크티 | 이벤트"/>
    <meta property="og:description" content="내가 좋아하는 크리에이터의 나만을 위한 콘텐츠, 콘텐츠 상점"/>
    <meta property="og:image" content="{{ asset('/img/app/og_image_3.png') }}"/>
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


  <link href="{{ asset('/dist/css/EventPage.css?version=4') }}" rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_EVENT_PAGE'/>
<input id='event_alias' type='hidden' value='{{$alias}}'/>

@endsection

@section('js')
@endsection
