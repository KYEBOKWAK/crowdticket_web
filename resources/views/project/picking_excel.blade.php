@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/lib/table/tabulator.css?version=1') }}">
    <style>
        #picking_container{
          width: 605px;
          padding-left: 5px;
          padding-right: 5px;
          margin-left: auto;
          margin-right: auto;
        }

        .order_collapse_ul{
          padding-left: 5px;
          padding-right: 5px;
          width: 580px;

          word-break: break-all;
          white-space: normal;
        }

        @media (max-width: 605px)
        {
          #picking_container{
            width: 100%;
          }

          .order_collapse_ul{
            width: 100%;
          }
          /*
          body{
            width: 900px;
          }
          */
        }

        #order_supervise_container{
          width: 900px;
          /*width: 100%;*/
          margin-left: auto;
          margin-right: auto;
        }

        #orders_container{
          /*width: 80%;*/
          /*width: 605px;*/
          width: 100%;
          margin-left: auto;
          margin-right: auto;
          margin-top: 20px;
        }

        #pick_list_container{
          /*width: 80%;*/
          /*width: 605px;*/
          width: 100%;
          margin-left: auto;
          margin-right: auto;
        }

        #pick_list_counter{
          width: 100%;
          text-align: right;
          margin-top: auto;
          margin-bottom: auto;
        }

        .first-container .row {
            padding: 30px;
        }

        .ps-ticket-order {
            margin-bottom: 60px;
        }

        .table thead {
            font-weight: bold;
        }

        .order_supervise_list{
          margin-bottom: 30px;
          background-color: white;
        }
/*
        .order_supervise_all_list{
          max-height: 300px;
        }
  */

        .order_collapse_rows{
          width: 100%;
          margin-bottom: 10px;
          padding-bottom: 5px;
          border-bottom: 1px dashed;
        }

        .order_collapse_value{
          margin-bottom: 5px;

        }

        .order_collapse_title{
          margin-bottom: 5px;
        }

        .order_supervise_list_event_start{
          font-size: 15px;
          font-weight: 900;
          margin-bottom: 5px;
        }

        #download_excel{
          height: 21px;
          font-size: 12px;
          background-color: white;
        }

        #export_table{
          display: none;
        }

        .pickButton{
          border: 1px solid #EF4D5D;
          width: 100%;
          background-color: white;

          box-shadow: 4px 4px 0 0 rgba(0, 0, 0, 0.16);
          border-radius: 10px;
        }
    </style>
@endsection

@section('content')

<input id='project_id' type='hidden' value='{{$project->id}}'/>
    @include('helper.btn_admin', ['project' => $project])

    <div class="first-container container">
        <div class="row">
            <h2 class="text-center text-important">
              @if($project->isPickedComplete())
                추첨 완료
              @else
                추첨 하기
              @endif
            </h2>

        </div>
    </div>

    <div id="picking_container">
      <div class="flex_layer">
        @if($project->isPickedComplete())
          <div style="width: 50%; margin-bottom: 10px;">추첨이 완료되었습니다.</div>
        @else
          <button id="pick_submit" class="pickButton" style="width: 50%; margin-bottom: 10px;" type="button">추첨 완료 하기</button>
        @endif
      </div>
      @if(!$project->isPickedComplete())
      <button id='pick_cancel_excel' class='pickButton' data-project-id='{{$project->id}}'>추첨 리스트 취소 하기(완료 아님)</button>
      @endif
      <div class='flex_layer'>
        <p style='margin-top: 10px; font-size: 20px; font-weight: bold; width: 100%'>추첨된 리스트</p>
        <p id="pick_list_counter" pick-count='{{$pickcount}}' projectid='{{$project->id}}'>추첨된 인원수 : {{$pickcount}}명</p>
      </div>
      <div id="pick_list_container">
      </div>

      @if(!$project->isPickedComplete())
        <p>테이블 형식에 맞춰서 복사 붙여넣기 하세요.</p>
        <button id='pick_excel' class='pickButton' data-project-id='{{$project->id}}'>추첨하기(완료 아님)</button>
        <div id="orders_container">
        </div>
      @endif
    </div>

@endsection

@section('js')

<script type="text/javascript" src="{{ asset('/js/lib/table/tabulator.min.js') }}"></script>

<script>

$(document).ready(function () {
  const excel_once_call_counter = 10;
  var call_delay_time = 100;
  var call_once_order_count = 50;

  var orders_container = $('#orders_container');
  var pick_list_container = $('#pick_list_container');


  var parentElement = document.createElement("div");
  parentElement.setAttribute('class', 'order_supervise_list');
  orders_container.append(parentElement);

  var pickListparentElement = document.createElement("div");
  pickListparentElement.setAttribute('class', 'order_supervise_list');
  pick_list_container.append(pickListparentElement);

  //var tableDataArray = new Array();
  var tabledata = [
    {"email":'클릭 후 붙여넣기 하세요', "name":"", "contact":""},
  ]

  var table = new Tabulator(parentElement, {
     height:"311px",
     data:tabledata,
     clipboard:true,
     clipboardPasteAction:"replace",
     columns:[
         {title:"이메일", field:"email", width: 180},
         {title:"이름", field:"name", width: 180},
         {title:"전화번호", field:"contact", width: 180},
     ],
 });

var projectId = $('#project_id').val();
var url_pick = '/picking/' + projectId + '/excel/picked';

 var table_pick = new Tabulator(pickListparentElement, {
      height:"311px",
      //data:tabledata,
      placeholder:"No Data Set",
      layout:"fitDataFill",
      ajaxURL : url_pick, // ajax URL 
      ajaxProgressiveLoad : "load",
      ajaxProgressiveLoadDelay : call_delay_time, // 각 요청 사이에 200 밀리 초 대기
      paginationSize:call_once_order_count,

      columns:[
          {title:"이메일", field:"email", headerFilter:"input", width: 180},
          {title:"이름", field:"name", headerFilter:"input", width: 180},
          {title:"전화번호", field:"contact", headerFilter:"input", width: 180}
      ],
 });

 var requestPickWithExcel = function(index){
  //var projectId = $('#pick_excel').attr('data-project-id');
  var url = '/picking/' + projectId + '/excel';
  var method = 'post';

  var index = Number(index);

  var isLast = 'FALSE';
  var dataArray = new Array();
  for(var i = 0 ; i < excel_once_call_counter ; i++)
  {
    if(index >= table.getData().length)
    {
      console.error('out!');
      isLast = 'TRUE';
      break;
    }

    var _object = table.getData()[index];
    
    var object = new Object();

    object.email = _object.email;
    object.name = _object.name;
    object.contact = _object.contact;

    dataArray.push(object);

    index++;
  }

  var jsonString = JSON.stringify(dataArray);
  //var data = JSON.parse(jsonString);
  var data = {
    list : JSON.parse(jsonString),
    islast : isLast,
    nextindex : index,
    alllength : table.getData().length
  }

  var success = function(result) {
    //console.error(result.data);
    if(result.state === 'error')
    {
      stopLoadingPopup();
      swal(result.message, '', 'error');
      return;
    }

    if(result.islast === 'FALSE')
    {
      if($("#loading_options"))
      {
        //팝업에 로딩 옵션이 있다면 옵션 셋팅
        var optionText = result.nextindex + " / " + result.alllength;

        $("#loading_options").text(optionText);
      }

      requestPickWithExcel(result.nextindex);
    }
    else
    {
      //stopLoadingPopup();
      window.location.reload();
    }
  };
  var error = function(request) {
    console.error('error!!');
    stopLoadingPopup();
    swal('에러!', '', 'error');
  };

  $.ajax({
    'url': url,
    'method': method,
    'data': data,
    'success': success,
    'error': error
  });
 }

 var callPickPopup = function(){
  var elementPopup = document.createElement("div");
  elementPopup.innerHTML =
  "<div class=''><br> - 추가된 인원 수 : " + table.getData().length + "명<br><br>"+
  "</div>";

  swal({
      title: "추첨 하시겠습니까?(완료 아님)",
      content: elementPopup,
      confirmButtonText: "V redu",
      allowOutsideClick: "true",

      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "save",
        },
      },

  }).then(function(value){
    switch (value) {
      case "save":
      {
        showLoadingPopup("추첨중...");
        requestPickWithExcel(0);
      }
      break;
    }
  });
 }

 var checkPickList = function(){
  showLoadingPopup("확인중...");
  var url = '/picking/' + projectId + '/excel/check';
  var method = 'post';

  var success = function(result) {
    if(result.state === 'success')
    {
      callPickPopup();
    }
    else
    {
      stopLoadingPopup();
      swal(result.message, '', 'error');
    }
  };
  var error = function(request) {
    console.error('error!!');
    stopLoadingPopup();
    swal('에러!', '', 'error');
  };

  $.ajax({
    'url': url,
    'method': method,
    'success': success,
    'error': error
  });
 };

 $('#pick_excel').click(function(){
  checkPickList();
 });

 var requestPickCancel = function(){
  var projectId = $('#pick_cancel_excel').attr('data-project-id');
  var url = '/picking/' + projectId + '/excel/cancel';
  var method = 'post';

  var success = function(result) {
    //stopLoadingPopup();
    window.location.reload();
  };
  var error = function(request) {
    console.error('error!!');
    stopLoadingPopup();
    swal('에러!', '', 'error');
  };

  $.ajax({
    'url': url,
    'method': method,
    'success': success,
    'error': error
  });
 };

 $('#pick_cancel_excel').click(function(){
  showLoadingPopup("취소중...");
  requestPickCancel();
 });

var sendSMSPickComplete = function(){
  showLoadingPopup("SMS 전송중..");
  var projectId = Number($("#pick_list_counter").attr('projectid'));

  var url = '/projects/' + projectId + '/pickingcomplete/sendsms';
  var method = 'post';
  var data = {
    "startindex": 0
  };

  var success = function(result) {
    stopLoadingPopup();
    swal("추첨 완료 성공!", "", "success").then(function(){
        window.location.reload();
      });
  };

  var error = function(request, status) {
    //console.error('request : ' + JSON.stringify(request) + ' status : ' + status);
    swal("SMS 전송 실패", "", "error");
  };

  requsetAjaxPartition(url, method, data, 0, success, error);
}

var sendEmailCancelPickComplete = function(){
  showLoadingPopup("미당첨 EMAIL 전송중..");
  var projectId = Number($("#pick_list_counter").attr('projectid'));

  var url = '/projects/' + projectId + '/pickingcomplete/sendcancelmail';
  var method = 'post';
  var data = {
    "startindex": 0
  };

  var success = function(result) {
    stopLoadingPopup();
    sendSMSPickComplete();
  };

  var error = function(request, status) {
    swal("미당첨 이메일 전송 실패", "", "error");
  };

  requsetAjaxPartition(url, method, data, 0, success, error);
}

var sendEmailPickComplete = function(){
  showLoadingPopup("당첨 EMAIL 전송중..");
  var projectId = Number($("#pick_list_counter").attr('projectid'));

  var url = '/projects/' + projectId + '/pickingcomplete/sendmail';
  var method = 'post';
  var data = {
    "startindex": 0
  };

  var success = function(result) {
    stopLoadingPopup();
    //sendSMSPickComplete();
    sendEmailCancelPickComplete();
  };

  var error = function(request, status) {
    swal("당첨 이메일 전송 실패", "", "error");
  };

  requsetAjaxPartition(url, method, data, 0, success, error);
}

var requestPickComplete = function(){
  showLoadingPopup('미당첨 취소 진행중..');

  var projectId = Number($("#pick_list_counter").attr('projectid'));
  var url = '/projects/' + projectId + '/pickingcomplete';
  var method = 'post';
  var data = {
    "startindex": 0
  };

  var success = function(result) {
    stopLoadingPopup();
    sendEmailPickComplete();
  };

  var error = function(result) {
    swal("추첨 완료 실패", result.message, "error");
  };
  
  requsetAjaxPartition(url, method, data, 0, success, error);
};

var pickCompletePopup = function(){
  var pickCounter = Number($("#pick_list_counter").attr('pick-count'));
  var projectId = Number($("#pick_list_counter").attr('projectid'));
  //alert(pickCounter);

  var elementPopup = document.createElement("div");
  elementPopup.innerHTML =
  "<div class=''>확정 하시면 더 이상 추첨이 불가능 합니다.<br> - 추첨된 인원수 : " + pickCounter + "명<br><br>"+
  "추첨 확정시,<br><b>1. 당첨 문자, 메일 발송</b><br><b>2. 미당첨 메일 발송</b><br> <b>3. 당첨자 리스트 공개</b><br> 이 진행 됩니다.<br><b>*당첨 발표시간에 눌러주세요*</b>" +
  "</div>";

  swal({
      title: "추첨 확정 하시겠습니까?",
      content: elementPopup,
      confirmButtonText: "V redu",
      allowOutsideClick: "true",

      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "save",
        },
      },

  }).then(function(value){
    switch (value) {
      case "save":
      {
        //showLoadingPopup('미당첨 취소 진행중..');
        requestPickComplete();
      }
      break;
    }
  });
};

  $("#pick_submit").click(function(){
    pickCompletePopup();//해당 함수가 기능힘수
    //swal("기능 개선중..", "해당 기능을 사용하려면 크라우드티켓에 연락주세요.", 'info');
  });
});
</script>
@endsection
