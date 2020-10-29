@extends('app')

@section('title')
    <title>크티 | 나의 컨텐츠</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

<link href="{{ asset('/dist/css/MyContentsPage.css?version=1') }}" 
rel="stylesheet"/>

  <link href="{{ asset('/dist/css/StoreOrderItem.css?version=1') }}" 
rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreReceiptItem.css?version=1') }}" 
rel="stylesheet"/>
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_MY_CONTENTS_PAGE'/>

@endsection

@section('js')
@endsection
