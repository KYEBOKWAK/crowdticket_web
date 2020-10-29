@extends('app')

@section('title')
    <title>크티 | 상점</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

  <link href="{{ asset('/dist/css/StoreHome.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreContentsListItem.css?version=0') }}" rel="stylesheet"/>
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_PAGE_KEY_STORE_HOME'/>

@endsection

@section('js')
@endsection
