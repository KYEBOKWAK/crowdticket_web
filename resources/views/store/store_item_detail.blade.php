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

<link href="{{ asset('/dist/css/alice-carousel.css?version=0') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreItemDetailPage.css?version=18') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreUserSNSList.css?version=2') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreOtherItems.css?version=1') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreReviewTalk.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreReviewTalkItem.css?version=0') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/ImageFileUploader.css?version=2') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/Popup_progress.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/Popup_image_preview.css?version=1') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/Popup_refund.css?version=1') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreItemDetailReviewList.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreItemDetailReviewItem.css?version=1') }}" rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_ITEM_DETAIL'/>
<input id='store_item_id' type='hidden' value='{{$store_item_id}}'/>

@endsection

@section('js')
@endsection
