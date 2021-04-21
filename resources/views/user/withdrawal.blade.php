

@extends('app')

@section('title')
    <title>크티 | 콘텐츠 상점</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

  <link href="{{ asset('/dist/css/Page_pc_776_Controller.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/WithdrawalPage.css?version=1') }}" rel="stylesheet"/>
  
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_PAGE_WITHDRAWAL'/>
@endsection

@section('js')
@endsection
