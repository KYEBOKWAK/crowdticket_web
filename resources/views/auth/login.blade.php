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


  <link href="{{ asset('/dist/css/ReactToastify.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/PageLoginController.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/LoginStartPage.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/LoginEmailPage.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/LoginKnowSNSPage.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/LoginForgetEmailPage.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/LoginSNSSetEmailPage.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/LoginJoinPage.css?version=1') }}" rel="stylesheet"/>
    
  <link href="{{ asset('/dist/css/Popup_resetSendMail.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/react-phone-input-2-style.css?version=0') }}" rel="stylesheet"/>
  <!--react-phone-input-2-style 이거 밑에 PhoneConfirm 이게 있어야함-->
  <link href="{{ asset('/dist/css/PhoneConfirm.css?version=0') }}" rel="stylesheet"/>
  
  <link href="{{ asset('/dist/css/InputBox.css?version=1') }}" rel="stylesheet"/>
  
@endsection

@section('content')
<input type="hidden" id='redirectURL' value="@if(isset($redirectPath)){{$redirectPath}}@endif"/>
<input type="hidden" name="token" value="@if(isset($token)){{$token}}@endif">


<input id='app_page_key' type='hidden' value='WEB_PAGE_LOGIN'/>

@endsection

@section('js')
@endsection
