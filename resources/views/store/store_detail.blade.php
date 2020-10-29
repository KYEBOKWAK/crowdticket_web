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

  <link href="{{ asset('/dist/css/StoreDetailPage.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreContentsListItem.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreReviewList.css?version=1') }}" rel="stylesheet"/>
  <link href="{{ asset('/dist/css/StoreReviewItem.css?version=1') }}" rel="stylesheet"/>
  
@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_PAGE_DETAIL'/>
<input id='store_id' type='hidden' value='{{$store_id}}'/>
<input id='store_alias' type='hidden' value='{{$store_alias}}'/>
<input id='store_detail_tabmenu' type='hidden' value='{{$tabmenu}}'/>

@endsection

@section('js')
@endsection
