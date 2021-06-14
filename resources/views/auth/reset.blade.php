@extends('app')

@section('title')
    <title>크티 | 로그인</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

  <link href="{{ asset('/dist/css/PageLoginController.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/LoginResetPasswordPage.css?version=1') }}" rel="stylesheet"/>
  
@endsection

@section('content')
<input type="hidden" id='redirectURL' value="@if(isset($redirectPath)){{$redirectPath}}@endif"/>
<input type="hidden" id='password_reset_token' name="token" value="@if(isset($token)){{$token}}@endif">


<input id='app_page_key' type='hidden' value='WEB_PAGE_PASSWORD_RESET_EMAIL'/>

@endsection

@section('js')
@endsection
