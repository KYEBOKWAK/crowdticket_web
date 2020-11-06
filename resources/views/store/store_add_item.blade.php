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

  <link href="{{ asset('/dist/css/StoreAddItemPage.css?version=0') }}" rel="stylesheet"/>
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_ITEM_ADD_PAGE'/>
<input id="add_item_page_state" type="hidden" value="{{$add_item_page_state}}">
<input id="item_id" type="hidden" value="{{$item_id}}">
@endsection

@section('js')
@endsection
