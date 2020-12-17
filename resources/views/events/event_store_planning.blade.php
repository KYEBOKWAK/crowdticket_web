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


  <link href="{{ asset('/dist/css/EventStorePlanning.css?version=0') }}" rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_EVENT_STORE_PLANNING'/>

@endsection

@section('js')
@endsection
