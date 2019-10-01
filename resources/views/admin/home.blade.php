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
          border-top: 16px solid #43c9f0;
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
                  <li role="presentation"><a href="#orderfail" aria-controls="orderfail" role="tab" data-toggle="tab">오더 실패 정보(예약결제 진행 후 해야함)</a>
                  </li>
                  <li role="presentation"><a href="#ordersync" aria-controls="eventtype" role="tab" data-toggle="tab">오더 싱크(98 state 체크)</a>
                  </li>
              </ul>
              <div class="tab-content">
                  <ul id="blueprint" role="tabpanel" class="tab-pane active list-group">
                      
                  </ul>
                  <ul id="blueprint-approved" role="tabpanel" class="tab-pane list-group">
                      
                  </ul>
                  <ul id="blueprint-project-created" role="tabpanel" class="tab-pane list-group">
                      
                  </ul>
                  <ul id="project" role="tabpanel" class="tab-pane">
                      
                  </ul>
                  <ul id="order" role="tabpanel" class="tab-pane">
                      
                  </ul>
                  <ul id="email" role="tabpanel" class="tab-pane">
                      
                  </ul>

                  <ul id="emailevent" role="tabpanel" class="tab-pane">
                          
                  </ul>

                  <ul id="ordercheck" role="tabpanel" class="tab-pane">
                    
                  </ul>

                  <!-- 오더 실패 정보  -->
                  <ul id="orderfail" role="tabpanel" class="tab-pane">
                    @foreach($allprojects as $project)
                      <li class="list-group-item">
                          <b>{{ $project->title }}</b> <br>
                            <form id="form_admin_order_fail_check{{$project->id}}" action="{{ url(sprintf('/admin/projects/%d/orderfailcheck', $project->id)) }}" method="get">
                              <button id="form_admin_order_fail_check_button" class="form_admin_order_fail_check_button" project_id="{{$project->id}}" type="button" class="btn btn-danger">예약결제상태체크 및 셋팅</button>
                              <input type="hidden" name="_method" value="GET">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                      </li>
                    @endforeach
                  </ul>

                  <!-- 이벤트타입 설정 -->
                  <ul id="ordersync" role="tabpanel" class="tab-pane">
                    @foreach($allprojects as $project)
                      <li class="list-group-item">
                          <b>{{ $project->title }}</b> | {{$project->id}} <br>
                            <form id="form_admin_order_init_check{{$project->id}}" action="{{ url(sprintf('/admin/projects/%d/orderinitstatecheck', $project->id)) }}" method="get">
                              <button id="form_admin_order_init_check_button" class="form_admin_order_init_check_button" project_id="{{$project->id}}" type="button" class="btn btn-danger">오더state 98 체크</button>
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

  $('.form_admin_order_fail_check_button').click(function(){
    showLoadPage();

    var projectId = $(this).attr('project_id');
    var formName = "#form_admin_order_fail_check"+projectId;
    $(formName).submit();
  });

  $('.form_admin_order_init_check_button').click(function(){
    showLoadPage();

    var projectId = $(this).attr('project_id');
    var formName = "#form_admin_order_init_check"+projectId;
    $(formName).submit();
  });


  var showLoadPage = function(){
    document.getElementById("loader").style.display = "block";
    document.getElementById("bodyDiv").style.display = "none";
  };
});

</script>
@endsection
