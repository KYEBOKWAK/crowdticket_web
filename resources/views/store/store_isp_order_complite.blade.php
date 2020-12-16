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

<link href="{{ asset('/dist/css/StoreISPOrderComplitePage.css?version=0') }}" rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_ISP_ORDER_COMPLITE_PAGE'/>
<input id='imp_uid' type='hidden' value='{{$imp_uid}}'/>
<input id='imp_success' type='hidden' value='{{$imp_success}}'/>
<input id='merchant_uid' type='hidden' value='{{$merchant_uid}}'/>
<input id='store_order_id' type='hidden' value='{{$store_order_id}}'/>

@endsection

@section('js')
@endsection
