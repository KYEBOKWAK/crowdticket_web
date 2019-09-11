@extends('app')

@section('meta')
    <meta property="og:image" content="{{ $project->getPosterUrl() }}"/>
    <meta name="description" content="{{ $project->description }}"/>
@endsection

@section('title')
    <title>{{ $project->title }}</title>
@endsection

@section('css')
    <link href="{{ asset('/css/detail.css?version=17') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/goods.css?version=6') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/project/form_body_ticket.css?version=3') }}"/>
    <style>
        .container h2 {
            margin-top: 60px;
            margin-bottom: 25px;
        }

        .ps-detail-category {
            margin-bottom: 30px;
        }

        .ps-detail-category span {
            font-size: 1.2em;
        }

        .project-video,
        .project-thumbnail {
            width: 100%;
            height: 450px;
        }

        .ps-detail-description p,
        .ps-detail-share-facebook span {
            width: 100%;
            height: 50px;
        }

        .ps-detail-description {
            padding-right: 0;
        }

        .ps-detail-description p {
            padding-left: 24px;
            background-color: #aaa;
            color: white;
            font-weight: bold;
            font-size: 18px;
            line-height: 50px;
        }

        .ps-detail-share-facebook {
            padding-left: 0;
            display: none;
        }

        .ps-detail-share-facebook span {
            border: none;
            border-radius: 0;
            color: white;
            font-size: 12px;
            background-color: #3a5795;
            padding-top: 15px;
        }

        .ps-detail-share-facebook span:hover {
            color: #eee;
        }

        .ps-detail-tabs {
            margin-top: 40px;
        }

        .ps-detail-tabs .nav-tabs {
            font-size: 14px;
            color: #8a8273;
        }

        .ps-detail-tabs .active {
            font-weight: bold;
        }

        .ps-detail-right-section {
            padding: 0px 10px 0px 10px;
        }

        .tab-pane {
          /*
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            border-left: 1px #ddd solid;
            border-right: 1px #ddd solid;
            border-bottom: 1px #ddd solid;
            background-color: white;
            padding: 27px 27px 40px 27px;
            */
        }


        #news-container {
            margin-bottom: 20px;
        }

        .ps-detail-comment-wrapper {
            margin-bottom: 20px;
        }

        .ps-detail-comment-wrapper button {
            margin-top: 10px;
        }

        #comments-container {
            padding: 0;
            /*word-break: keep-all;*/
        }

        #ticket_list {
            margin-top: 30px;
			      margin-right: 0px;
			      margin-left: 0px;
        }

        .ticket {
            padding: 0px;
        }

        .creator-wrapper {
            margin-top: 30px;
        }

        .newIcon{
          font-size: 10px;
          font-style: normal;
          font-weight: bold;
          position: relative;
          top: -6px;
          color: #7EC52A
        }

        footer{
          display: none;
        }

        .datepicker-title{
          background-color: #43c9f0 !important;
        }
    </style>

    <link href="{{ asset('/css/calendar.css?version=10') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-lite.css?version=1') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-crowdticket.css?version=3') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/swiper/swiper.min.css?version=1') }}">
@endsection

@section('content')
<?php
$posters = json_decode($posters, true);
$channels = $project->user->channels()->get();
$tickets = $project->tickets()->get();
$discounts = $project->discounts()->get();
$selectedTicket = "";
?>
<input type="hidden" id="isFinished" value="{{ $project->isFinished() }}">
<input type="hidden" id="isWaitSaleTime" value="{{ $project->isWaitSaling() }}" time-value="{{ $project->getStartSaleTime() }}">
<input id="isEventTypeCrawlingEvent" type="hidden" value="{{ $project->isEventTypeCrawlingEvent() }}">
<input type="hidden" id="isPickingFinished" value="{{ $project->isFinishedAndPickingFinished() }}">
<input id="isPickType" type="hidden" value="{{ $project->isPickType() }}">
<input id="g_app_type" type="hidden" value="{{env('APP_TYPE')}}"/>

    @include('helper.btn_admin', ['project' => $project])
    

    <div class="col-md-3 ps-detail-share-facebook" id="BtnFBshare" style="display:none;">
                        <span class="btn">페이스북 공유하기</span>
    </div>
@endsection

@section('js')
    @include('template.comment')
    @include('template.news')
    @include('template.supporter')
    @include('template.detail_ticket_time')
    @include('template.detail_ticket_seat')
    @include('template.shareForm')
    @include('template.fbForm', ['project' => $project])
    @include('template.goods_container', ['isForm' => 'false'])
    @include('template.goods', ['isForm' => 'false'])
    @include('template.ticket_old')
    <script src="{{ asset('/js/lib/clipboard.min.js') }}"></script>
    <script src="{{ asset('/js/swiper/swiper.min.js?version=1') }}"></script>
    <script src="{{ asset('/js/project/detail.js?version=21') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.2/angular.min.js'></script>
    <script src="{{ asset('/js/calendar/calendar.js?version=22') }}"></script>
    <script>
    $(document).ready(function() {
      if($("#g_app_type").val() === 'qa')
      {
        //$("footer").css( "border", "9px solid red" );
        $("footer").show();
      }
    });
    </script>
@endsection
