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

<link href="{{ asset('/dist/css/StoreOrderPage.css?version=0') }}" 
rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreOrderItem.css?version=0') }}" 
rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_ORDER_PAGE'/>
<input id='store_item_id' type='hidden' value='{{$store_item_id}}'/>

@endsection

@section('js')
@endsection
