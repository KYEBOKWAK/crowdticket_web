@extends('app')

@section('meta')
  <meta property="og:title" content="크라우드티켓 매거진 | 크티"/>
  <meta property="og:description" content="지금 크티에서 일어나고 있는 일들을 소개합니다"/>
  <meta property="og:image" content="{{ asset('/img/app/og_image_3.png') }}"/>
  <meta name="description" content="지금 크티에서 일어나고 있는 일들을 소개합니다"/>
@endsection

@section('title')
  <title>크라우드티켓 매거진 | 크티</title>
@endsection

@section('css')
<style>
  #main{
    display: none;
    /* height: 0px; */
    /* min-height: 0px; */
  }
  </style>

  <link href="{{ asset('/dist/css/App_Magazine.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Magazine_List_Item.css?version=1') }}" rel="stylesheet"/>
  
@endsection

@section('react_main')
<input id='app_page_key' type='hidden' value='WEB_PAGE_MAGAZINE'/>

@if (\Auth::check() && \Auth::user()->isAdmin())
    <button id="go_write_magazine" style="margin-top: 30px;" class="btn btn-success center-block project_form_button">글쓰기</button>
@endif

<div id="react_app_magazine_page"></div>

@if (\Auth::check() && \Auth::user()->isAdmin())
  <div id="magazine_page_hidden_list" style="margin-top: 50px;" ></div>
@endif

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/dist/App_Magazine.js?version=4') }}"></script>
@endsection
