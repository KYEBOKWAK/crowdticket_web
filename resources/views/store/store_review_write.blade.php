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

<link href="{{ asset('/dist/css/ReviewWritePage.css?version=0') }}" rel="stylesheet"/>
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_REVIEW_WRITE'/>
<input id='store_id' type='hidden' value='{{$store_id}}'/>
<input id='comment_id' type='hidden' value='{{$comment_id}}'/>
<input id='comment_write_state' type='hidden' value='{{$comment_write_state}}'/>

@endsection

@section('js')
@endsection
