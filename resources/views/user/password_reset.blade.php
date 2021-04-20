@extends('app')

@section('title')
    <title>크티 | 콘텐츠상점</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

  <link href="{{ asset('/dist/css/PageLoginController.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/InputBox.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/LoginForgetEmailPage.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Popup_resetSendMail.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/PasswordResetPage.css?version=0') }}" rel="stylesheet"/>
  
@endsection

@section('content')

<input id='app_page_key' type='hidden' value='WEB_PAGE_PASSWORD_RESET'/>

@endsection

@section('js')
@endsection
