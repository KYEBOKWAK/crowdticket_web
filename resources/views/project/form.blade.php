@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-lite.css?version=1') }}"/>
    <style>
        .ps-update-tabs {
            margin-top: 48px;
            margin-bottom: 35px;
            margin-left: -2px;
            margin-right: -2px;
        }

        .ps-update-tabs a {
            text-decoration: none;
        }

        .ps-update-tabs .col-md-1,
        .ps-update-tabs .col-md-2 {
            padding-left: 2px;
            padding-right: 2px;
        }

        .ps-update-tabs .col-md-1 {
            padding-top: 5px;
        }

        .ps-update-tab {
            padding: 10px 0 10px 0;
            text-align: center;
            background-color: #eee;
            color: #384150;
        }

        .ps-update-tab img {
            width: 24px;
            height: 25px;
        }

        .ps-update-tab-selected {
            background-color: #7EC52A;
        }

        .ps-update-tab-title {
            display: inline;
            font-size: 15px;
            font-weight: bold;
            vertical-align: middle;
            margin-left: 8px;
        }

        .ps-update-tab:hover {
            background-color: #ddd;
        }

        .ps-update-tab-selected:hover {
            background-color: #7EC52A;
        }

        .ps-update-body h2 {
            font-weight: bold;
            margin: 8px auto 30px auto;
            text-align: center;
        }

        .ps-update-body .bg-info {
            text-align: center;
            margin-top: 0;
            margin-bottom: 38px;
            background-color: #eaeaea;
            padding: 8px;
            line-height: 1.3em;
        }

        .ps-update-body .form-group label {
            padding-right: 0;
        }

        .ps-col-width-17p2 {
            width: 17.2%;
        }

        #ticket_reward {
            height: 130px;
        }

        .ticket .ticket-footer,
        .ticket .ticket-wrapper {
            border-bottom-right-radius: 0;
        }

        .ticket .ticket-body span {
            font-size: 20px;
        }

        .ticket .col-md-1 {
            position: absolute;
            bottom: 0;
            right: 0;
            margin-right: 14px;
            padding: 0;
        }

        .ticket .col-md-1 button {
            width: 100%;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .ticket .col-md-1 p {
            margin: 0;
        }

        .ticket .col-md-1 .modify-ticket {
            margin-bottom: 5px;
        }

        .ps-update-poster .col-md-8 {
            border-right: 1px #DAD8CC solid;
        }

        .ps-update-sampleview-img {
            margin-top: 17px;
            margin-left: -15px;
            margin-bottom: 15px;
        }

        .ps-update-poster .form-group .bg-base {
            position: relative;
            width: 100%;
            height: 480px;
        }

        .ps-update-poster .form-group .bg-base .middle {
            width: 100%;
            position: absolute;
            top: 45%;
            text-align: center;
        }

        #video_url {
            width: 70%;
        }

        .ps-update-creator h3 {
            text-align: center;
            line-height: 1.4em;
        }

        .ps-update-creator .link-user-form {
            margin-top: 30px;
            margin-bottom: 60px;
        }

        .ps-update-creator .link-user-form a {
            font-size: 18px;
        }

        .ps-update-creator .box-creator-profile {
            margin-top: 15px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/css/project/form.css?version=3') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/goods.css?version=2') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/project/form_body_required.css?version=4') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/welcome.css?version=4') }}"/>

    <link rel="stylesheet" href="{{ asset('/css/tooltip/google.css?version=2') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/tooltip/tippy.css?version=2') }}"/>

    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-crowdticket.css?version=1') }}"/>

@endsection

@section('content')
@include('helper.btn_admin', ['project' => $project])

<?php
$tabs = [
        [
                'key' => 'required',
                'title' => '분류',
                'ico_url' => asset('/img/app/ico_tap01.png')
        ]
];

array_push($tabs, [
        'key' => 'base',
        'title' => '기본정보',
        'ico_url' => asset('/img/app/ico_tap01.png')
]);

array_push($tabs, [
        'key' => 'ticket',
        'title' => '티켓',
        'ico_url' => asset('/img/app/ico_tap02_01.png')
]);

array_push($tabs, [
        'key' => 'poster',
        'title' => '포스터',
        'ico_url' => asset('/img/app/ico_tap03.png')
]);
array_push($tabs, [
        'key' => 'story',
        'title' => '스토리',
        'ico_url' => asset('/img/app/ico_tap04.png')
]);
array_push($tabs, [
        'key' => 'creator',
        'title' => '개설자소개',
        'ico_url' => asset('/img/app/ico_tap05.png')
]);

//최종적으로 success가 떨어져야 다음 탭으로 넘어간다.
  $isReqiredSuccess = "FALSE";
  if($project->project_type != "" && $project->type != "")
  {
    //project type에 저장되어 있는게 있다면, 이미 분류쪽 선택은 끝난 상태
    $isReqiredSuccess = "TRUE";
  }

  $tabInfoJson = json_encode($tabs);
?>
<input type="hidden" id="project_type" value="{{ $project->project_type }}"/>
<input type="hidden" id="project_id" value="{{ $project->id }}"/>
<input type="hidden" id="isReqiredSuccess" value="{{$isReqiredSuccess}}">
<input type="hidden" id="default_img" value="{{ url( $project->getDefaultImgUrl() ) }}"/>

<input type="hidden" id="selected_tab" value="{{$selected_tab}}"/>
<input type="hidden" id="tabInfoJson" value="{{$tabInfoJson}}"/>

<input id="project_target" type="hidden" name="project_target" value="{{ $project->project_target }}">

<div class="project-form-container">
  <div class="project-form-tab-container">
    <div class="flex_layer_project">
      @foreach ($tabs as $tab)
          <div class="project-form-tab-wrapper">
              <a href="#" tab-key-value="{{ $tab['key'] }}" onclick="tabSelect('{{ $tab['key'] }}'); return false;">
                  <div class="project-form-tab @if ($tab['key'] === $selected_tab) project-form-tab-select @endif">
                      <img src="{{ $tab['ico_url'] }}"/>
                      <h5 class="ps-update-tab-title">{{ $tab['title'] }}</h5>
                  </div>
              </a>
          </div>
      @endforeach
      <div class="project-form-tab-preview-btn">
          <a href="{{ url('/projects/') }}/{{ $project->id }}" class="btn btn-success"
             target="_blank">미리보기</a>
      </div>
      @if ($project->isReady())
          <div class="project-form-tab-submit-btn">
              <button id="submit_project" class="btn btn-primary">제출하기</button>
          </div>
      @endif
    </div>
  </div>
</div>

  <div class="project-form-content-container">
    @if ($selected_tab === 'required')
        @include('project.form_body_required', ['project' => $project])
    @elseif ($selected_tab === 'base')
        @include('project.form_body_default', [
            'categories' => $categories,
            'cities' => $cities,
            'project' => $project
        ])
    @elseif ($selected_tab === 'ticket')
        @include('project.form_body_ticket', ['project' => $project])
    @elseif ($selected_tab === 'poster')
        @include('project.form_body_poster', ['project' => $project])
    @elseif ($selected_tab === 'story')
        @include('project.form_body_story', ['project' => $project])
    @elseif ($selected_tab === 'creator')
        @include('project.form_body_creator', ['project' => $project, 'user' => Auth::user()])
    @endif
  </div>

@endsection

@section('js')
    @include('template.ticket')
    @include('template.discount')
    @include('template.goods', ['isForm' => 'true'])
    @include('template.goods_container', ['isForm' => 'true'])
    @include('template.channel_category_url')
    <script src="{{ asset('/js/project/form.js?version=6') }}"></script>
    <script src="{{ asset('/js/tooltip/tippy.min.js?version=2') }}"></script>
    <script src="{{ asset('/js/tooltip/tooltip.js?version=3') }}"></script>
    <script src="{{ asset('/js/editor/summernote-lite.js?version=1') }}"></script>
    <script src="{{ asset('/js/editor/summernote-lite-crowdticket.js?version=1') }}"></script>
@endsection
