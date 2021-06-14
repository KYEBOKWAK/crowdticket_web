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

<link href="{{ asset('/dist/css/ReactToastify.css?version=0') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreOrderPage.css?version=5') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreOrderItem.css?version=5') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/FileUploader.css?version=5') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/Popup_progress.css?version=1') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/Popup_image_preview.css?version=2') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StorePlayTimePlan.css?version=2') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/Popup_SelectTime.css?version=2') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/react-phone-input-2-style.css?version=0') }}" rel="stylesheet"/>
  <!--react-phone-input-2-style 이거 밑에 PhoneConfirm 이게 있어야함-->
<link href="{{ asset('/dist/css/PhoneConfirm.css?version=0') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/InputBox.css?version=1') }}" rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_ORDER_PAGE'/>
<input id='store_item_id' type='hidden' value='{{$store_item_id}}'/>

@endsection

@section('js')
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>
@endsection
