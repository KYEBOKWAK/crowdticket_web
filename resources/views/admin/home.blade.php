@extends('app')

@section('css')
    <style>
        .list-group-item-heading {
            font-weight: bold
        }

        .list-group-item-text {
            margin-bottom: 1em
        }

        /*프로세스바*/
        #loader {
          display: none;
          position: absolute;
          left: 50%;
          top: 50%;
          z-index: 1;
          width: 150px;
          height: 150px;
          margin: -75px 0 0 -75px;
          border: 16px solid #f3f3f3;
          border-radius: 50%;
          border-top: 16px solid #EF4D5D;
          width: 120px;
          height: 120px;
          -webkit-animation: spin 2s linear infinite;
          animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

        /* Add animation to "page content" */
        .animate-bottom {
          position: relative;
          -webkit-animation-name: animatebottom;
          -webkit-animation-duration: 1s;
          animation-name: animatebottom;
          animation-duration: 1s
        }

        @-webkit-keyframes animatebottom {
          from { bottom:-100px; opacity:0 }
          to { bottom:0px; opacity:1 }
        }

        @keyframes animatebottom {
          from{ bottom:-100px; opacity:0 }
          to{ bottom:0; opacity:1 }
        }

        #bodyDiv {
          /*display: none;*/
          /*text-align: center;*/
        }
        /*프로세스바end*/
    </style>
@endsection

@section('navbar')
    <nav class="navbar navbar-default">
        <a class="navbar-brand" href="{{ url('/') }}">CROWD TICKET</a>
        <p class="navbar-text">관리 콘솔 :P</p>
    </nav>
@endsection

@section('content')
<div id="loader"></div>
<div id="bodyDiv">
  <div class="container first-container">
      <div class="row">
          <div class="col-md-10 col-md-offset-1">
              <ul role="tablist" class="nav nav-tabs">
                  <li role="presentation" class="active"><a href="#blueprint" aria-controls="blueprint" role="tab"
                                                            data-toggle="tab">제안서</a></li>
                  <li role="presentation"><a href="#blueprint-approved" aria-controls="blueprint-approved" role="tab"
                                             data-toggle="tab">제안서 (승인완료)</a></li>
                  <li role="presentation"><a href="#blueprint-project-created"
                                             aria-controls="blueprint-project-created" role="tab" data-toggle="tab">제안서
                          (공연생성)</a></li>
                  <li role="presentation"><a href="#project" aria-controls="project" role="tab"
                                             data-toggle="tab">프로젝트</a></li>
                  <li role="presentation"><a href="#order" aria-controls="order" role="tab" data-toggle="tab">펀딩취소</a>
                  </li>
                  <li role="presentation"><a href="#email" aria-controls="email" role="tab" data-toggle="tab">메일/문자</a>
                  </li>
                  <li role="presentation"><a href="#emailevent" aria-controls="emailevent" role="tab" data-toggle="tab">이벤트이메일(임시)</a>
                  </li>
                  <li role="presentation"><a href="#ordercheck" aria-controls="ordercheck" role="tab" data-toggle="tab">주문자 정보 비교(iamport)</a>
                  </li>
              </ul>
              <div class="tab-content">
                  <ul id="blueprint" role="tabpanel" class="tab-pane active list-group">
                      @foreach ($blueprints as $blueprint)
                          @if (!$blueprint->hasApproved())
                              <li class="list-group-item">
                                  <form action="{{ url('/admin/blueprints/') }}/{{ $blueprint->id }}/approval"
                                        method="post">
                                      <p class="list-group-item-text">아이디 : {{ $blueprint->user->id }}, 이메일
                                          : {{ $blueprint->user->email }}, 이름 : {{ $blueprint->user->name }}</p>
                                      <h4 class="list-group-item-heading">자신 소개</h4>
                                      <p class="list-group-item-text">{{ $blueprint->user_introduction }}</p>
                                      <h4 class="list-group-item-heading">공연 종류</h4>
                                      <p class="list-group-item-text">{{ $blueprint->project_introduction }}</p>
                                      <h4 class="list-group-item-heading">공연 스토리</h4>
                                      <p class="list-group-item-text">{{ $blueprint->story }}</p>
                                      <h4 class="list-group-item-heading">예상 공연 비용</h4>
                                      <p class="list-group-item-text">{{ $blueprint->estimated_amount }}</p>
                                      <h4 class="list-group-item-heading">연락처</h4>
                                      <p class="list-group-item-text">{{ $blueprint->contact }}</p>
                                      <h4 class="list-group-item-heading">요청 날짜</h4>
                                      <p class="list-group-item-text">{{ $blueprint->created_at }}</p>
                                      <p class="list-group-item-text">프로젝트 생성 주소 : {{ url('/projects/form/' . $blueprint->code) }}</p>
                                      <button type="submit" class="btn btn-primary">승인하기</button>
                                      <input type="hidden" name="_method" value="PUT">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  </form>
                              </li>
                          @endif
                      @endforeach
                  </ul>
                  <ul id="blueprint-approved" role="tabpanel" class="tab-pane list-group">
                      @foreach ($blueprints as $blueprint)
                          @if ($blueprint->hasApproved())
                              @if (!$blueprint->hasProjectCreated())
                                  <li class="list-group-item">
                                      <p class="list-group-item-text">아이디 : {{ $blueprint->user->id }}, 이메일
                                          : {{ $blueprint->user->email }}, 이름 : {{ $blueprint->user->name }}</p>
                                      <h4 class="list-group-item-heading">자신 소개</h4>
                                      <p class="list-group-item-text">{{ $blueprint->user_introduction }}</p>
                                      <h4 class="list-group-item-heading">공연 종류</h4>
                                      <p class="list-group-item-text">{{ $blueprint->project_introduction }}</p>
                                      <h4 class="list-group-item-heading">공연 스토리</h4>
                                      <p class="list-group-item-text">{{ $blueprint->story }}</p>
                                      <h4 class="list-group-item-heading">예상 공연 비용</h4>
                                      <p class="list-group-item-text">{{ $blueprint->estimated_amount }}</p>
                                      <h4 class="list-group-item-heading">연락처</h4>
                                      <p class="list-group-item-text">{{ $blueprint->contact }}</p>
                                      <h4 class="list-group-item-heading">요청 날짜</h4>
                                      <p class="list-group-item-text">{{ $blueprint->created_at }}</p>
                                      <p class="list-group-item-text">프로젝트 생성 주소 : {{ url('/projects/form/' . $blueprint->code) }}</p>
                                      <span class="label label-success">승인완료</span>
                                  </li>
                              @endif
                          @endif
                      @endforeach
                  </ul>
                  <ul id="blueprint-project-created" role="tabpanel" class="tab-pane list-group">
                      @foreach ($blueprints as $blueprint)
                          @if ($blueprint->hasProjectCreated())
                              <li class="list-group-item">
                                  <p class="list-group-item-text">아이디 : {{ $blueprint->user->id }}, 이메일
                                      : {{ $blueprint->user->email }}, 이름 : {{ $blueprint->user->name }}</p>
                                  <h4 class="list-group-item-heading">자신 소개</h4>
                                  <p class="list-group-item-text">{{ $blueprint->user_introduction }}</p>
                                  <h4 class="list-group-item-heading">공연 종류</h4>
                                  <p class="list-group-item-text">{{ $blueprint->project_introduction }}</p>
                                  <h4 class="list-group-item-heading">공연 스토리</h4>
                                  <p class="list-group-item-text">{{ $blueprint->story }}</p>
                                  <h4 class="list-group-item-heading">예상 공연 비용</h4>
                                  <p class="list-group-item-text">{{ $blueprint->estimated_amount }}</p>
                                  <h4 class="list-group-item-heading">연락처</h4>
                                  <p class="list-group-item-text">{{ $blueprint->contact }}</p>
                                  <h4 class="list-group-item-heading">요청 날짜</h4>
                                  <p class="list-group-item-text">{{ $blueprint->created_at }}</p>
                                  <p class="list-group-item-text">프로젝트 생성 주소 : {{ url('/projects/form/' . $blueprint->code) }}</p>
                                  <span class="label label-success">공연 생성됨!</span>
                              </li>
                          @endif
                      @endforeach
                  </ul>
                  <ul id="project" role="tabpanel" class="tab-pane">
                      @foreach ($investigation_projects as $project)
                          <li class="list-group-item">
                              <a href="{{ url('/projects/') }}/{{ $project->id }}" target="_blank"><p
                                          class="list-group-item-text">{{ $project->title }}</p></a>
                              <form action="{{ url('/admin/projects/') }}/{{ $project->id }}/approval" method="post">
                                  <button type="submit" class="btn btn-primary">승인하기</button>
                                  <input type="hidden" name="_method" value="PUT">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              </form>
                              <form action="{{ url('/admin/projects/') }}/{{ $project->id }}/rejection" method="post">
                                  <button type="submit" class="btn btn-primary">반려하기</button>
                                  <input type="hidden" name="_method" value="PUT">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              </form>
                          </li>
                      @endforeach
                  </ul>
                  <ul id="order" role="tabpanel" class="tab-pane">
                      @foreach($funding_projects as $project)
                        @if($project->getTotalFundingAmount() > 0)
                          @if($project->getTotalFundingAmount() < $project->pledged_amount)
                            <li class="list-group-item">
                                {{ $project->title }} <br>
                                @if($project->project_target == "people")
                                  모인인원 : {{ $project->getTotalFundingAmount() }} 명<br>
                                  목표인원 : {{ $project->pledged_amount }} 명
                                @else
                                  모인금액 : {{ $project->getTotalFundingAmount() }} 원<br>
                                  목표금액 : {{ $project->pledged_amount }} 원
                                @endif
                                <form action="{{ url(sprintf('/admin/projects/%d/cancel', $project->id)) }}" method="post">
                                    <button type="submit" class="btn btn-danger">주문 취소</button>
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </li>
                          @endif
                        @endif
                      @endforeach
                  </ul>
                  <ul id="email" role="tabpanel" class="tab-pane">
                      @foreach($funding_end_projects as $project)
                          <li class="list-group-item">
                              {{ $project->title }} <br>
                              @if($project->project_target == "people")
                                모인인원 : {{ $project->getTotalFundingAmount() }} 명<br>
                                목표인원 : {{ $project->pledged_amount }} 명
                              @else
                                모인금액 : {{ $project->getTotalFundingAmount() }} 원<br>
                                목표금액 : {{ $project->pledged_amount }} 원
                              @endif
                              <br>
                              @if($project->getTotalFundingAmount() > $project->pledged_amount)
                                <form id="form_send_mail_success" class="form_send_mail_success_{{$project->id}}" action="{{ url(sprintf('/admin/projects/%d/funding/mail/success', $project->id)) }}" method="post">
                                    <button type="button" disabled="disable" class="btn btn-danger">실패 메일 보내기</button>
                                    <button id="form_send_mail_success_btn" project_id="{{$project->id}}" type="button" class="form_send_mail_success_btn btn btn-danger">성공 메일 보내기</button>
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                                <br>
                                <form id="form_send_sms_success" class="form_send_sms_success_{{$project->id}}" action="{{ url(sprintf('/admin/projects/%d/funding/sms/success', $project->id)) }}" method="post">
                                    <button type="button" disabled="disable" class="btn btn-danger">실패 문자 보내기</button>
                                    <button id="form_send_sms_success_btn" project_id="{{$project->id}}" type="button" class="form_send_sms_success_btn btn btn-danger">성공 문자 보내기</button>
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                              @elseif($project->getTotalFundingAmount() == 0)
                                <button type="button" disabled="disable" class="btn btn-danger">구매없음</button>
                              @else
                                <form id="form_send_mail_fail" class="form_send_mail_fail_{{$project->id}}" action="{{ url(sprintf('/admin/projects/%d/funding/mail/fail', $project->id)) }}" method="post">
                                    <button id="form_send_mail_fail_btn" project_id="{{$project->id}}" type="button" class="form_send_mail_fail_btn btn btn-danger">실패 메일 보내기</button>
                                    <button type="button" disabled="disable" class="btn btn-danger">성공 메일 보내기</button>
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                                <br>
                                <form action="{{ url(sprintf('/admin/projects/%d/funding/sms/fail', $project->id)) }}" method="post">
                                    <button type="submit" disabled="disable" class="btn btn-danger">실패 문자 보내기</button>
                                    <button type="button" disabled="disable" class="btn btn-danger">성공 문자 보내기</button>
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                              @endif
                          </li>
                      @endforeach
                  </ul>

                  <ul id="emailevent" role="tabpanel" class="tab-pane">
                          <li class="list-group-item">
                            @if($eventProject)
                              {{ $eventProject->title }} <br>
                                <form id="form_send_mail_fail_event" action="{{ url(sprintf('/admin/projects/%d/event/mail/fail', $eventProject->id)) }}" method="post">
                                    <button id="form_send_mail_fail_event_btn" type="button" class="btn btn-danger">당첨실패메일 보내기</button>
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            @endif
                          </li>
                  </ul>

                  <ul id="ordercheck" role="tabpanel" class="tab-pane">
                    @foreach($allprojects as $project)
                      <li class="list-group-item">
                          <b>{{ $project->title }}</b> <br>
                            <form id="form_admin_order_check{{$project->id}}" action="{{ url(sprintf('/admin/projects/%d/ordercheck', $project->id)) }}" method="get">
                              <br>
                              <p>유저 아이디 범위(시작)</p>
                              <input type="number" name="startUID" />
                              <p>유저 아이디 범위(끝)</p>
                              <input type="number" name="endUID" />
                                <button id="form_admin_order_check_button" class="form_admin_order_check_button" project_id="{{$project->id}}" type="button" class="btn btn-danger">주문비교하기(범위))</button>
                                <input type="hidden" name="_method" value="GET">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                      </li>
                    @endforeach
                  </ul>

              </div>
          </div>
      </div>
  </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
  $('.form_send_mail_fail_btn').click(function(){
    showLoadPage();
    var projectId = $(this).attr('project_id');
    var formName = ".form_send_mail_fail_"+projectId;
    $(formName).submit();
  });

  $('.form_send_mail_success_btn').click(function(){
    showLoadPage();

    var projectId = $(this).attr('project_id');
    var formName = ".form_send_mail_success_"+projectId;
    $(formName).submit();
    //$('.form_send_mail_success').submit();
  });

  $('.form_send_sms_success_btn').click(function(){
    showLoadPage();

    var projectId = $(this).attr('project_id');
    var formName = ".form_send_sms_success_"+projectId;
    $(formName).submit();
    //$('.form_send_sms_success').submit();
  });

  $('.form_send_mail_fail_event_btn').click(function(){
    showLoadPage();

    var projectId = $(this).attr('project_id');
    var formName = ".form_send_mail_fail_event_"+projectId;
    $(formName).submit();
    //$('.form_send_mail_fail_event').submit();
  });

  $('.form_admin_order_check_button').click(function(){
    showLoadPage();

    var projectId = $(this).attr('project_id');
    var formName = "#form_admin_order_check"+projectId;
    $(formName).submit();
    //$('.form_send_mail_fail_event').submit();
  });


  var showLoadPage = function(){
    document.getElementById("loader").style.display = "block";
    document.getElementById("bodyDiv").style.display = "none";
  };
});

</script>
@endsection
