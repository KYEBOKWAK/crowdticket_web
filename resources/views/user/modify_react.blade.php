@extends('app')

@section('title')
    <title>크티 | 콘텐츠 상점</title>
@endsection

@section('css')
  <style>
  /* #main{
    display: none;
  } */
  </style>

  <link href="{{ asset('/dist/css/App_modify.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/InputBox.css?version=0') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/ImageCroper.css?version=1') }}" rel="stylesheet"/>  
  
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_PAGE_MODIFY'/>

<div id="react_app_modify_page"></div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/dist/App_modify.js?version=2') }}"></script>
@endsection
