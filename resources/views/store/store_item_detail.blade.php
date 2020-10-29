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

<link href="{{ asset('/dist/css/StoreItemDetailPage.css?version=1') }}" rel="stylesheet"/>
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_ITEM_DETAIL'/>
<input id='store_item_id' type='hidden' value='{{$store_item_id}}'/>

@endsection

@section('js')
@endsection
