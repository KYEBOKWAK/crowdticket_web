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
    <div class="basecontainer">
      

      
      <div id="stickoffset"></div>
      <div id="sticky" class="container-fluid middle-tap-menu">
        <div class="detail_width_wrapper">
          <div class="detail_tab_container">
            <ul role="tablist" class="nav nav-tabs">
                <li role="presentation" class="active">
                <a href="#tab-story" aria-controls="default" role="tab" data-toggle="tab" class="first-navmenu--margin-top">스토리</a>
                </li>
                <li role="presentation" class="">
                <a href="#tab-news" aria-controls="default" role="tab" data-toggle="tab">업데이트<span class="count">{{ $project->news_count }}</span></a>
                </li>
                <li role="presentation" class="">
                <a href="#tab-comments" aria-controls="default" role="tab" data-toggle="tab">댓글<span class="count">{{ $project->getCommentCount() }}</span></a>
                </li>
                <li id="tabTicketMD" role="presentation" class="">
                <a href="#tab-md" aria-controls="default" role="tab" data-toggle="tab">티켓&amp;MD정보</a>
                </li>
            </ul>
          </div>

          <!-- 중간 네비게이션에 스크롤링에 의해 노출되는 크라우드 티켓팅 버튼 -->
          <div class="nav-ticketing-btn">

               @if($project->isEventTypeCrawlingEvent())
                <a href="@if($project->url_crawlings()) {{$project->url_crawlings()->url}} @endif" target="_blank"><button type="button" class="btn btn-primary btn-block ticketing-btn">외부페이지로 이동</button></a>
               @else
                <button id="detail_tab_cw_btn" type="button" class="btn btn-primary btn-block ticketing-btn">
                @if(env('REVIEW_ON'))
                티켓팅
                @else
                이벤트 참여신청
                @endif
                </button>
               @endif
           </div>
        </div>
      </div>

      <div class="detail_contant_wrapper">
        <div class="detail_width_wrapper">
          <div class="detail_content_calendar_container_grid">
            <div class="tab-content">
              <div id="tab-story" role="tabpanel" class="tab-pane active detail_remove_bottom_border">
                @include('template.picking_list', ['project' => $project])
                <div class="detail_story_wrapper">
                 {!! html_entity_decode($project->story) !!}
                </div>
              </div>

              <div id="tab-news" role="tabpanel" class="tab-pane loadable">
                <ul id="news-container" class="list-group"></ul>
                  @if ($is_master)
                      <div class="text-center">
                          <a href="{{ url('/projects') }}/{{ $project->id }}/news/form"
                             class="btn btn-success">업데이트 작성</a>
                      </div>
                  @endif
                  <div class="tab-pane" style="margin-bottom:0px; margin-top:50px;">

                  </div>
              </div>

              <div id="tab-comments" role="tabpanel" class="tab-pane loadable">
                <form id="addComment" action="{{ url('/projects') }}/{{ $project->id }}/comments" method="post"
                      data-toggle="validator" role="form" class="ps-detail-comment-wrapper">
                    <textarea id="input_comment" name="contents" class="form-control" rows="3"
                              placeholder="프로젝트 진행자에게 궁금한 사항, 혹은 응원의 한마디를 남겨주세요!" required></textarea>
                    <button type="button" class="btn btn-success pull-right detail_comment_add_btn">댓글달기</button>
                    <div class="clear"></div>
                    @include('csrf_field')
                </form>
                <ul id="comments-container"></ul>
              </div>

              <div id="tab-md" role="tabpanel" class="tab-pane loadable">
              </div>
            </div>

            @if($project->isOldProject())
              <div id="old_ticket_list" data-tickets="{{ $project->tickets }}"></div>
            @else
              @include('template.detail_ticket_md')
            @endif

          </div>
        </div>
      </div>

      <div class="nav-ticketing-btn-mobile">
        @if($project->isEventTypeCrawlingEvent())
          <a href="@if($project->url_crawlings()) {{$project->url_crawlings()->url}} @endif" target="_blank"><button type="button" class="btn btn-primary btn-block ticketing-btn">외부페이지로 이동</button></a>
        @else
         <button id="detail_tab_cw_btn_mobile" type="button" class="btn btn-primary btn-block ticketing-btn">이벤트 참여신청</button>
        @endif
       </div>

      <input type="hidden" id="buyable" value="{{ $project->canOrder() ? 1 : 0 }}"/>
      <input type="hidden" id="project_type" value="{{ $project->type }}"/>
      <input type="hidden" id="project_saleType" value="{{ $project->type }}"/>
      <input type="hidden" id="project_id" value="{{ $project->id }}"/>
      <input type="hidden" id="goods_json" value="{{ $project->goods }}"/>

      <input type="hidden" id="isMaster" value="{{ $is_master }}"/>

      <input type="hidden" id="introduce_input_row" value="{{ $project->user->introduce }}">

      <!--baseContainer end-->
    </div>

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
