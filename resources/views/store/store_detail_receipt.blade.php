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

<link href="{{ asset('/dist/css/StoreDetailReceipt.css?version=1') }}" 
rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreOrderItem.css?version=1') }}" 
rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreReceiptItem.css?version=3') }}" 
rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_DETAIL_RECEIPT'/>
<input id='store_order_id' type='hidden' value='{{$store_order_id}}'/>

@endsection

@section('js')
@endsection
