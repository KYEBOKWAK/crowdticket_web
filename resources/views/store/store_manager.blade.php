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

<link href="{{ asset('/dist/css/StoreManager.css?version=2') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreManagerTabAskOrderListPage.css?version=3') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreManagerTabStoreInfoPage.css?version=3') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreManagerTabItemPage.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreManagerTabOrderListPage.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreManagerTabAccountPage.css?version=2') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreOrderItem.css?version=1') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreReceiptItem.css?version=11') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/StoreContentsListItem.css?version=2') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/FileUploader.css?version=4') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/Popup_image_preview.css?version=1') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/Popup_text_editor.css?version=0') }}" rel="stylesheet"/>
<link href="{{ asset('/dist/css/quill.snow.css?version=0') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/Popup_progress.css?version=0') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/Popup_text_viewer.css?version=3') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StoreStateProcess.css?version=2') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/StorePlayTimePlan.css?version=1') }}" rel="stylesheet"/>

<link href="{{ asset('/dist/css/TableComponent.css?version=0') }}" rel="stylesheet"/>

@endsection

@section('content')
<input id='app_page_key' type='hidden' value='WEB_STORE_PAGE_MANAGER'/>
<input id='store_manager_tabmenu' type='hidden' value='{{$tabmenu}}'/>

<input id='isAdmin' type='hidden' value='{{$isAdmin}}'/>
<input id='store_id' type='hidden' value='{{$store_id}}'/>

@endsection

@section('js')
@endsection
