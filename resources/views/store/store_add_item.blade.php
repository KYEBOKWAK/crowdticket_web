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

  <link href="{{ asset('/dist/css/StoreAddItemPage.css?version=11') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/ImageFileUploader.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Popup_progress.css?version=0') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Popup_image_preview.css?version=1') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/ImageCroper.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/react-easy-crop.css?version=0') }}" rel="stylesheet"/>
  
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_ITEM_ADD_PAGE'/>
<input id="add_item_page_state" type="hidden" value="{{$add_item_page_state}}">
<input id="item_id" type="hidden" value="{{$item_id}}">

<input id="store_id" type="hidden" value="{{$store_id}}">
<input id='isAdmin' type='hidden' value='{{$isAdmin}}'/>

<input id='go_back_edit_page' type='hidden' value='{{$goBack}}' />

@endsection

@section('js')
@endsection
