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

  <link href="{{ asset('/dist/css/StoreContentConfirm.css?version=3') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreContentsListItem.css?version=6') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/FileUploader.css?version=5') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Popup_text_viewer.css?version=4') }}" rel="stylesheet"/>

  <link href="{{ asset('/dist/css/Popup_image_preview.css?version=2') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/CompletedFileUpLoader.css?version=5') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/Popup_progress.css?version=1') }}" rel="stylesheet"/>
  
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_CONTENT_CONFIRM'/>
<input id="store_order_id" type="hidden" value="{{$store_order_id}}">
@endsection

@section('js')
@endsection
