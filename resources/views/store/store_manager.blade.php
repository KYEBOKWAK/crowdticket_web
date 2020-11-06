@extends('app')

@section('title')
    <title>크티 | 상점 관리</title>
@endsection

@section('css')
  <style>
  #main{
    display: none;
  }
  </style>

<link href="{{ asset('/dist/css/StoreManager.css?version=1') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreManagerTabAskOrderListPage.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreManagerTabStoreInfoPage.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreManagerTabItemPage.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreManagerTabOrderListPage.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreManagerTabAccountPage.css?version=0') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreOrderItem.css?version=1') }}" 
rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreReceiptItem.css?version=4') }}" 
rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreContentsListItem.css?version=2') }}" rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_PAGE_MANAGER'/>
<input id='store_manager_tabmenu' type='hidden' value='{{$tabmenu}}'/>

@endsection

@section('js')
@endsection
