@extends('app')

@section('title')
    <title>크티 | 이벤트</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>


  <link href="{{ asset('/dist/css/EventPage.css?version=3') }}" rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_EVENT_PAGE'/>
<input id='event_alias' type='hidden' value='{{$alias}}'/>

@endsection

@section('js')
@endsection
