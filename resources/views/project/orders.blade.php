@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/lib/table/tabulator.css?version=1') }}">
    <style>
        @media (max-width: 900px)
        {
          body{
            width: 900px;
          }
        }

        p{
          margin-bottom: 0px;
        }

        #order_supervise_container{
          
        }

        #order_no_ticket_supervise_container{
          
        }

        .order_container{
          width: 900px;
          margin-left: auto;
          margin-right: auto;
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
          /*margin-bottom: 30px;*/
          background-color: white;
        }

        .order_collapse_rows{
          width: 50%;
          margin-bottom: 10px;
          padding-bottom: 5px;
          border-bottom: 1px dashed;
        }

        .order_collapse_value{
          text-align: right;
          margin-left: auto;
        }

        .order_supervise_list_event_start{
          font-size: 15px;
          font-weight: 900;
          margin-bottom: 5px;
          margin-top: 50px;
        }

        #download_excel{
          height: 21px;
          font-size: 12px;
          background-color: white;
        }

        #export_table{
          display: none;
        }

        .order_state_container{
          margin-bottom: 30px;
          font-size: 15px;
          font-weight: 900;
          margin-top: 5px;
        }

        .order_loading{
          margin-top: 0px;
          margin-bottom: 0px;
          width: 30px;
          height: 30px;
        }

        .state_ticket_info_loading_word_wrapper{
          margin-left: auto;
        }

        .state_ticket_margin_top{
          margin-top: 5px;
        }

        .state_ticket_info_loading_wrapper{
          margin-left: 5px;
        }

        .btn_order_info{
          width: 100px;
          padding: 15px;
          border-radius: 4px;
          font-size: 15px;
          background-color: #43c9f0;
          border: 1px solid #43c9f0;
          font-weight: 500;
        }

        .btn_order_info:hover,.btn_order_info:active,.btn_order_info:focus {
            background-color:#43c9f0;
            border:1px solid #43c9f0;
        }

        .info_label{
          font-size: 15px;
          margin-top: auto;
          margin-bottom: auto;
          margin-right: 20px;
          font-weight: bold;
        }

        .order_info_tickets_wrapper{
          margin-bottom: 20px;
        }

        .input_check_box{
          opacity: 0;
          position: relative;
          z-index: 100;
          bottom: 4px;
        }

        .input_check_box[type="checkbox"]{
          width: 13px;
          height: 100%;
          margin-right: 0px;
          margin-top: 0px;
        }

        .checkbox_img{
          display: none;
          position: absolute;
          width: 24px;
          height: 24px;
          top: 6px;
          left: 0px;
        }

        .checkbox_img_unselect{
          display: block;
        }

        .checkbox_wrapper{
          position: relative;
          margin-right: 12px;
        }

        .order_checkbox_bg{
          background-color: #f7f7f7;
          width: 100%;
          height: 124px;
          border-top: 1px solid #cccccc;
          margin-top: 20px;
          margin-bottom: 20px;
        }

        .checkbox_label{
          margin-top: 16px;
          margin-left: 16px;
          font-size: 14px;
          font-weight: normal;
          color: #4d4d4d;
          margin-bottom: 25px;
        }

        #input_check_box_tickets{
          margin-top: 6px;
        }

        #input_check_box_all_list{
          margin-top: 6px;
        }

        .loading_size_20{
          margin-top: 7px;
          margin-left: 7px;
        }

        .order_tickets_label{
          margin-top: 8px;
          margin-left: 4px;
          color: #43c9f0;
          font-size: 14px;
          font-weight: normal;
        }

        .order_all_info_label{
          margin-top: 8px;
          margin-left: 4px;
          color: #43c9f0;
          font-size: 14px;
          font-weight: normal;
        }

    </style>
@endsection

@section('content')

    <?php
    $goodsList = $project->goods;

    //$testa = $test;
    //$testa = json_decode($testa, false);
    ?>

<input id="question_object_json" type="hidden" value="{{$project->questions}}"/>
<input id="project_id" type="hidden" value="{{$project->id}}"/>
<input id="project_title" type="hidden" value="{{$project->title}}"/>

    @include('helper.btn_admin', ['project' => $project])

    <div class="first-container container">
        <div class="row">
            <h2 class="text-center text-important">주문 관리</h2>
            <p class="text-center">조회수 {{ $project->view_count }}</p>
            <p class="text-center">** pc에 최적화 되어있습니다. **</p>
        </div>
    </div>

    <div class='order_container'>
      <div id='order_info_word'>
        <div class='order_info_tickets_wrapper flex_layer'>
          <p id='order_light_info_label' class='info_label'>총 참여자수: 0명 / 총 티켓구매 : 0매 / 취소 수 : 0매 / 후원만한 금액 : 0원 / 총 티켓 판매 금액 : 0원</p>
        </div>
      </div>

      <div class='flex_layer'>
        <div class='checkbox_wrapper'>
          <input id='input_check_box_all' type='checkbox' class='input_check_box' value=''/>
          <img class='checkbox_img checkbox_img_select checkbox_img_select_all' src="{{ asset('/img/icons/svg/ic-checkbox-btn-s.svg') }}"/>
          <img class='checkbox_img checkbox_img_unselect checkbox_img_unselect_all' src="{{ asset('/img/icons/svg/ic-checkbox-btn-n.svg') }}"/>
        </div>
        <p style='font-size: 24px; font-weight: normal; margin-bottom: 0px;'>
          전체 불러오기
        </p>
      </div>

      <div class='order_checkbox_bg'>
        <p class='checkbox_label'>자세한 데이터 확인을 하고 싶으신 경우, 아래에서 확인할 데이터를 선택해주세요</p>
        <div class='order_checkbox_wrapper flex_layer'>
          <div class='flex_layer' style='margin-left: 32px;'>
            <div class='checkbox_wrapper'>
              <input id='input_check_box_tickets' type='checkbox' class='input_check_box' data-ischecked='' value=''/>
              <img class='checkbox_img checkbox_img_select checkbox_img_select_tickets' src="{{ asset('/img/icons/svg/ic-checkbox-btn-s.svg') }}"/>
              <img class='checkbox_img checkbox_img_unselect checkbox_img_unselect_tickets' src="{{ asset('/img/icons/svg/ic-checkbox-btn-n.svg') }}"/>
            </div>
            <p style='font-size: 14px; font-weight: normal; margin-bottom: 0px; margin-top: 7px;'>
              티켓 종류
            </p>
            <p class='order_tickets_label'>
            </p>
          </div>

          <div class='flex_layer' style='margin-left: 32px;'>
            <div class='checkbox_wrapper'>
              <input id='input_check_box_all_list' type='checkbox' class='input_check_box' data-ischecked='' value=''/>
              <img class='checkbox_img checkbox_img_select checkbox_img_select_all_list' src="{{ asset('/img/icons/svg/ic-checkbox-btn-s.svg') }}"/>
              <img class='checkbox_img checkbox_img_unselect checkbox_img_unselect_all_list' src="{{ asset('/img/icons/svg/ic-checkbox-btn-n.svg') }}"/>
            </div>
            <p style='font-size: 14px; font-weight: normal; margin-bottom: 0px; margin-top: 7px;'>
              전체 리스트
            </p>
            <p class='order_all_info_label'>
            </p>
          </div>
        </div>
      </div>

      <div id="order_supervise_container">
      </div>

      <div id="order_no_ticket_supervise_container">
      </div>

      <div id="order_all_supervise_container">
      </div>
    </div>
    

    <!-- 다운로드 할 테이블 -->
    <table id="export_table" class="table">
        <thead>
          <tr id="export_table_head_tr">
          </tr>
        </thead>
        <tbody id="export_table_body">
        </tbody>
    </table>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/lib/table/xlsx.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/lib/table/tabulator.min.js') }}"></script>

<script>
$(document).ready(function () {
  //var call_once_order_count = 40;
  var call_once_order_count = 100;
  var call_delay_time = 100;
  var tableHeight = "700px";
  var order_supervise_container = $('#order_supervise_container');
  var order_no_ticket_supervise_container = $('#order_no_ticket_supervise_container');
  var order_all_supervise_container = $('#order_all_supervise_container');

  var columnsInfo = [
      //{title:"아이디(test)", field:"id", align:"center", width:103},
      {title:"이름", field:"name", align:"center", width:103},
      {title:"티켓종류", field:"ticket_name", align:"center"},
      {title:"티켓매수", field:"count", align:"right", width:88, sorter:"number", bottomCalc: "sum"},
      {title:"결제금액", field:"totalPriceWithoutCommission", align:"right", bottomCalc: "sum"},
      {title:"상태", field:"state_string", align:"center"},
      {title:"이메일", field:"email", align:"center", width:221},
      {title:"전화번호", field:"contact", align:"center", width:151},
      {title:"출석", field:"attended", align:"center", formatter:"tickCross", sorter:"boolean"},
      {title:"GOODSOBJECT", field:"GOODSOBJECT", align:"center", width:80, bottomCalc: "sum"},//반드시 title과 filed 는 GOODSOBJECT 이어야 함.
      {title:"주문요청", field:"answer", align:"center"},
      {title:"추가후원", field:"supporterPrice", align:"center"},
      {title:"할인내용", field:"discountText", align:"center"},
      {title:"굿즈수령주소", field:"deliveryAddress", align:"center"},
      {title:"기타사항", field:"requirement", align:"center"},
      {title:"결제일", field:"created_at", align:"center"},
  ];

  var columnsNoTicketInfo = [
      //{title:"아이디(test)", field:"id", align:"center", width:103},
      {title:"이름", field:"name", align:"center", width:103},
      {title:"결제금액", field:"totalPriceWithoutCommission", align:"right", bottomCalc: "sum"},
      {title:"상태", field:"state_string", align:"center"},
      {title:"이메일", field:"email", align:"center", width:221},
      {title:"전화번호", field:"contact", align:"center", width:151},

      {title:"결제일", field:"created_at", align:"center", width:240},
      {title:"GOODSOBJECT", field:"GOODSOBJECT", align:"center", width:80},//반드시 title과 filed 는 GOODSOBJECT 이어야 함.
      {title:"주문요청", field:"answer", align:"center"},
      {title:"굿즈수령주소", field:"deliveryAddress", align:"center"},
      {title:"추가후원", field:"supporterPrice", align:"center"},
      {title:"기타사항", field:"requirement", align:"center"},
  ];

  var columnsOnlySupportInfo = [
      //{title:"아이디(test)", field:"id", align:"center", width:103},
      {title:"이름", field:"name", align:"center", width:103},
      {title:"결제금액", field:"totalPriceWithoutCommission", align:"right", bottomCalc: "sum"},
      {title:"상태", field:"state_string", align:"center"},
      {title:"이메일", field:"email", align:"center", width:221},
      {title:"전화번호", field:"contact", align:"center", width:151},
      {title:"후원금액", field:"supporterPrice", align:"center"},
      {title:"결제일", field:"created_at", align:"center", width: 152},
  ];

  var columnsAllInfo = [
      {title:"이름", field:"name", align:"center", width:103, headerFilter:true},
      {title:"일시", field:"show_date", align:"center", width: 150},
      {title:"티켓종류", field:"ticket_category", align:"center"},
      {title:"티켓매수", field:"count", align:"right", width:88, sorter:"number", bottomCalc:"sum"},
      {title:"GOODSOBJECT", field:"GOODSOBJECT", align:"center", width:80, bottomCalc:"sum"},//반드시 title과 filed 는 GOODSOBJECT 이어야 함.
      {title:"추가후원", field:"supporterPrice", align:"right", bottomCalc:"sum"},
      {title:"출석", field:"attended", align:"center", formatter:"tickCross", sorter:"boolean"},
      {title:"결제금액", field:"totalPriceWithoutCommission", align:"right", bottomCalc:"sum"},
      {title:"상태", field:"state_string", align:"center"},
      {title:"이메일", field:"email", align:"center", width:221},
      {title:"전화번호", field:"contact", align:"center", width:151},
      {title:"할인내용", field:"discountText", align:"center"},
      {title:"굿즈수령주소", field:"deliveryAddress", align:"center"},
      {title:"기타사항", field:"requirement", align:"center"},
      {title:"결제일", field:"created_at", align:"center"},
      {title:"QUESTIONOBJECT", field:"QUESTIONOBJECT", align:"center"},
  ];

  var isWorkedCollapse = false;
  var formatterObject = new Object();
  formatterObject.formatter = "responsiveCollapse";
  formatterObject.width = 30;
  formatterObject.minWidth = 30;
  formatterObject.align = "center";
  formatterObject.resizable = false;
  formatterObject.headerSort = false;
  formatterObject.cellClick = function(e, cell){
    isWorkedCollapse = true;
  };

  var initTable = function(data_tickets, data_goods){

    //컬럼 셋팅 start//
    var columnsArray = new Array();
    columnsArray.push(formatterObject);

    for(var i = 0 ; i < columnsInfo.length ; i++)
    {
      var columnsInfoRow = columnsInfo[i];
      var columnsObject = new Object();
      if(columnsInfoRow.title === 'GOODSOBJECT')
      {
        for(var j = 0 ; j < data_goods.length ; j++)
        {
          //var columnsGoods = new Object();
          columnsObject.title = data_goods[j].title;
          columnsObject.field = 'goods'+data_goods[j].id;
          columnsObject.width = 80;
          columnsObject.align = 'center';
          columnsObject.sorter = "number";

          columnsArray.push(columnsObject);
        }
      }
      else
      {
        columnsObject = columnsInfoRow;
        columnsArray.push(columnsObject);
      }
    }
    //컬럼 셋팅 end//

    for(var i = 0 ; i < data_tickets.length; i++)
    {
      var ticketInfo = data_tickets[i];

      var loadingWordID = 'loading_word_ticket_id_' + ticketInfo.id;
      var loadingNameID = 'loading_ticket_id_' + ticketInfo.id;

      var eventStartElement = document.createElement("div");
      eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
      eventStartElement.innerHTML = "<div class='flex_layer'>" +
                                      "<p style='margin-top: auto;'>" +
                                        getTicketDateFullInfoWithCategoryText(ticketInfo.show_date, ticketInfo.ticket_name)+
                                      "</p>" +

                                      "<div class='flex_layer' style='margin-left: auto;'>" +
                                        "<div class='state_ticket_info_loading_word_wrapper state_ticket_margin_top'>" +
                                          "<p id='"+loadingWordID+"'>데이터 가져오는 중</p>" + 
                                        "</div>" +
                                        "<div class='state_ticket_info_loading_wrapper'>" +
                                          "<p id='"+loadingNameID+"' class='loading order_loading'></p>" +
                                        "</div>" +
                                      "</div>" +
                                    "</div>";
      //$(eventStartElement).text(getTicketDateFullInfoWithCategoryText(ticketInfo.show_date, ticketInfo.ticket_name));
      order_supervise_container.append(eventStartElement);

      var parentElement = document.createElement("div");
      parentElement.setAttribute('class', 'order_supervise_list order_tickets_div');
      order_supervise_container.append(parentElement);

      var ajaxURL = '/orders/project/'+$('#project_id').val()+'/objects/' + ticketInfo.id;
      var table = new Tabulator(parentElement, {
        height: tableHeight,
        placeholder:"No Data Set",
        layout:"fitDataFill",
        responsiveLayout:"collapse",
        ajaxURL : ajaxURL, // ajax URL 
        ajaxProgressiveLoad : "load",
        ajaxProgressiveLoadDelay : call_delay_time, // 각 요청 사이에 200 밀리 초 대기
        paginationSize:call_once_order_count,
        columns:columnsArray,
        //data:tableDataArray,
        responsiveLayoutCollapseStartOpen:false,
        ajaxResponse:function(url, params, response){
        //url - the URL of the request
        //params - the parameters passed with the request
        //response - the JSON object returned in the body of the response.
          var callCount = response.data.length;
          if(callCount < call_once_order_count)
          {
            var removeURL = url.split('/');
            var ticketId = Number(removeURL[5]);

            $('#'+'loading_word_ticket_id_'+ticketId).text('데이터 모두 가져옴');
            $('#'+'loading_ticket_id_'+ticketId).hide();
          }

          return response; //return the response data to tabulator
        },
        rowClick:function(e, row){
          if(!isWorkedCollapse)
          {
            var collapseNode = row._row.element.children[0].children[0];
            $(collapseNode).trigger("click");
          }

          isWorkedCollapse = false;
        },
        responsiveLayoutCollapseFormatter:function(data){
            var list = document.createElement("ul");

            for(var key in data)
            {
              if(data[key] === 0 || data[key] === '')
              {
                continue;
              }

              let item = document.createElement("li");
              item.innerHTML = "<div class='flex_layer order_collapse_rows'>" + "<strong>" + key + "</strong> " + "<div class='order_collapse_value'>" + data[key] + "</div>" + "</div>";
              list.appendChild(item);
            }

            return Object.keys(data).length ? list : "";
        }
      });
    }
  }

  var requestTicketList = function(){
    loadingProcessWithSize($('.order_tickets_label'));
    var url="/orders/project/tickets";
    var method = 'get';
    var data =
    {
      'project_id' : $('#project_id').val()
    }
    var success = function(request) {
      loadingProcessStopWithSize($('.order_tickets_label'));
      if(request.state === 'success'){
        $('.order_tickets_label').text('완료');
        initTable(request.data_tickets, request.data_goods);
      }
    };
    
    var error = function(request) {
      loadingProcessStopWithSize($('.order_tickets_label'));
      console.error('error');
    };
    
    $.ajax({
    'url': url,
    'method': method,
    'data' : data,
    'success': success,
    'error': error
    });
  };

  //requestTicketList();

  var initNoTicketTable = function(data_goods){
    //컬럼 셋팅 start//
    var columnsArray = new Array();
    columnsArray.push(formatterObject);

    for(var i = 0 ; i < columnsNoTicketInfo.length ; i++)
    {
      var columnsInfoRow = columnsNoTicketInfo[i];
      var columnsObject = new Object();
      if(columnsInfoRow.title === 'GOODSOBJECT')
      {
        for(var j = 0 ; j < data_goods.length ; j++)
        {
          //var columnsGoods = new Object();
          columnsObject.title = data_goods[j].title;
          columnsObject.field = 'goods'+data_goods[j].id;
          columnsObject.width = 80;
          columnsObject.align = 'center';
          columnsObject.sorter = "number";

          columnsArray.push(columnsObject);
        }
      }
      else
      {
        columnsObject = columnsInfoRow;
        columnsArray.push(columnsObject);
      }
    }
    //컬럼 셋팅 end//

    var loadingNameID = 'loading_no_ticket_order';
    var loadingWordID = 'loading_word_no_ticket_order';

    var eventStartElement = document.createElement("div");
    eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
    eventStartElement.innerHTML = "<div class='flex_layer'>" +
                                      "<p style='margin-top: auto;'>" +
                                      '티켓 구매 안하신 분(굿즈, 후원)' +
                                      "</p>" +

                                      "<div class='flex_layer' style='margin-left: auto;'>" +
                                        "<div class='state_ticket_info_loading_word_wrapper state_ticket_margin_top'>" +
                                          "<p id='"+loadingWordID+"'>데이터 가져오는 중</p>" + 
                                        "</div>" +
                                        "<div class='state_ticket_info_loading_wrapper'>" +
                                          "<p id='"+loadingNameID+"' class='loading order_loading'></p>" +
                                        "</div>" +
                                      "</div>" +
                                    "</div>";

    order_no_ticket_supervise_container.append(eventStartElement);

    var parentElement = document.createElement("div");
    parentElement.setAttribute('class', 'order_supervise_list order_tickets_div');
    order_no_ticket_supervise_container.append(parentElement);

    var ajaxURL = '/orders/project/'+$('#project_id').val()+'/notickets';
    var table = new Tabulator(parentElement, {
      height: tableHeight,
      placeholder:"No Data Set",
      layout:"fitDataFill",
      responsiveLayout:"collapse",
      ajaxURL : ajaxURL, // ajax URL 
      ajaxProgressiveLoad : "load",
      ajaxProgressiveLoadDelay : call_delay_time, // 각 요청 사이에 200 밀리 초 대기
      paginationSize:call_once_order_count,
      columns:columnsArray,
      //data:tableDataArray,
      responsiveLayoutCollapseStartOpen:false,
      ajaxResponse:function(url, params, response){
      //url - the URL of the request
      //params - the parameters passed with the request
      //response - the JSON object returned in the body of the response.
        var callCount = response.data.length;
        if(callCount < call_once_order_count)
        {
          $('#'+'loading_word_no_ticket_order').text('데이터 모두 가져옴');
          $('#'+'loading_no_ticket_order').hide();
        }

        return response; //return the response data to tabulator
      },
      rowClick:function(e, row){
        if(!isWorkedCollapse)
        {
          var collapseNode = row._row.element.children[0].children[0];
          $(collapseNode).trigger("click");
        }

        isWorkedCollapse = false;
      },
      responsiveLayoutCollapseFormatter:function(data){
          var list = document.createElement("ul");

          for(var key in data)
          {
            if(data[key] === 0 || data[key] === '')
            {
              continue;
            }

            let item = document.createElement("li");
            item.innerHTML = "<div class='flex_layer order_collapse_rows'>" + "<strong>" + key + "</strong> " + "<div class='order_collapse_value'>" + data[key] + "</div>" + "</div>";
            list.appendChild(item);
          }

          return Object.keys(data).length ? list : "";
      }
    });
  }

  var requestNoTicketList = function(){
    var url="/orders/project/notickets";
    var method = 'get';
    var data =
    {
      'project_id' : $('#project_id').val()
    }
    var success = function(request) {
      if(request.state === 'success'){
        if(request.data_noticket_orders_count > 0)
        {
          $('.order_no_tickets_label').text('완료');
          //티켓 미구매인데 주문이 있을때 초기화 해준다.
          initNoTicketTable(request.data_goods);
        }
        else
        {
          $('.order_no_tickets_label').text('없음');
        }
      }
    };
    
    var error = function(request) {
      console.error('error');
    };
    
    $.ajax({
    'url': url,
    'method': method,
    'data' : data,
    'success': success,
    'error': error
    });
  };

  //requestNoTicketList();

  var initSupportsTable = function(){
    //컬럼 셋팅 start//
    var columnsArray = new Array();
    columnsArray.push(formatterObject);
    //컬럼 셋팅 end//

    var loadingNameID = 'loading_support_order';
    var loadingWordID = 'loading_word_support_order';

    var eventStartElement = document.createElement("div");
    eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
    eventStartElement.innerHTML = "<div class='flex_layer'>" +
                                      "<p style='margin-top: auto;'>" +
                                      '후원만 하신분' +
                                      "</p>" +

                                      "<div class='flex_layer' style='margin-left: auto;'>" +
                                        "<div class='state_ticket_info_loading_word_wrapper state_ticket_margin_top'>" +
                                          "<p id='"+loadingWordID+"'>데이터 가져오는 중</p>" + 
                                        "</div>" +
                                        "<div class='state_ticket_info_loading_wrapper'>" +
                                          "<p id='"+loadingNameID+"' class='loading order_loading'></p>" +
                                        "</div>" +
                                      "</div>" +
                                    "</div>";
    order_no_ticket_supervise_container.append(eventStartElement);

    var parentElement = document.createElement("div");
    parentElement.setAttribute('class', 'order_supervise_list order_tickets_div');
    order_no_ticket_supervise_container.append(parentElement);

    var ajaxURL = '/orders/project/'+$('#project_id').val()+'/supports';
    var table = new Tabulator(parentElement, {
      height: tableHeight,
      placeholder:"No Data Set",
      layout:"fitDataFill",
      responsiveLayout:"collapse",
      ajaxURL : ajaxURL, // ajax URL 
      ajaxProgressiveLoad : "load",
      ajaxProgressiveLoadDelay : call_delay_time, // 각 요청 사이에 200 밀리 초 대기
      paginationSize:call_once_order_count,
      columns:columnsOnlySupportInfo,
      //data:tableDataArray,
      responsiveLayoutCollapseStartOpen:false,
      ajaxResponse:function(url, params, response){
      //url - the URL of the request
      //params - the parameters passed with the request
      //response - the JSON object returned in the body of the response.
        var callCount = response.data.length;
        if(callCount < call_once_order_count)
        {
          $('#'+'loading_word_support_order').text('데이터 모두 가져옴');
          $('#'+'loading_support_order').hide();
        }

        return response; //return the response data to tabulator
      },
      rowClick:function(e, row){
        if(!isWorkedCollapse)
        {
          var collapseNode = row._row.element.children[0].children[0];
          $(collapseNode).trigger("click");
        }

        isWorkedCollapse = false;
      },
      responsiveLayoutCollapseFormatter:function(data){
          var list = document.createElement("ul");

          for(var key in data)
          {
            if(data[key] === 0 || data[key] === '')
            {
              continue;
            }

            let item = document.createElement("li");
            item.innerHTML = "<div class='flex_layer order_collapse_rows'>" + "<strong>" + key + "</strong> " + "<div class='order_collapse_value'>" + data[key] + "</div>" + "</div>";
            list.appendChild(item);
          }

          return Object.keys(data).length ? list : "";
      }
    });
  }

  var requestOnlySupportList = function(){
    var url="/orders/project/supports";
    var method = 'get';
    var data =
    {
      'project_id' : $('#project_id').val()
    }
    var success = function(request) {
      if(request.state === 'success'){
        if(request.data_support_orders_count > 0)
        {
          //티켓 미구매인데 주문이 있을때 초기화 해준다.
          $('.order_only_support_label').text('완료');
          initSupportsTable();
        }
        else
        {
          $('.order_only_support_label').text('없음');
        }
      }
    };
    
    var error = function(request) {
      console.error('error');
    };
    
    $.ajax({
    'url': url,
    'method': method,
    'data' : data,
    'success': success,
    'error': error
    });
  };

  //requestOnlySupportList();

  var initAllTable = function(data_goods, order_counter){
    var question_object_json = $("#question_object_json").val();
    var _tableHeight = tableHeight;
    var g_question_object = '';
    if(question_object_json)
    {
      g_question_object = $.parseJSON(question_object_json);
    }

    //컬럼 셋팅 start//
    var columnsArray = new Array();
    //columnsArray.push(formatterObject);
    
    for(var i = 0 ; i < columnsAllInfo.length ; i++)
    {
      var columnsInfoRow = columnsAllInfo[i];
      if(columnsInfoRow.title === 'GOODSOBJECT')
      {
        for(var j = 0 ; j < data_goods.length ; j++)
        {
          var columnsGoods = new Object();
          columnsGoods.title = data_goods[j].title;
          columnsGoods.field = 'goods'+data_goods[j].id;
          columnsGoods.width = 80;
          columnsGoods.align = 'center';
          columnsGoods.sorter = "number";
          columnsGoods.bottomCalc = "sum";

          columnsArray.push(columnsGoods);
        }

        //continue;
      }
      else if(columnsInfoRow.title === 'QUESTIONOBJECT'){
        for(var j = 0 ; j < g_question_object.length ; j++)
        {
          var columnsQuestion = new Object();
          columnsQuestion.title = g_question_object[j].question;
          columnsQuestion.field = 'table_question_'+g_question_object[j].id;
          columnsQuestion.optionName = 'question';
          columnsQuestion.option_key = g_question_object[j].id;
          columnsQuestion.width = 80;
          columnsQuestion.align = 'center';

          columnsArray.push(columnsQuestion);
        }

        //continue;
      }
      else
      {
        var columnsObject = new Object();
        columnsObject = columnsInfoRow;
        columnsArray.push(columnsObject);
      }
    }

    if(order_counter <= 13)
    {
      _tableHeight = "100%";
    }

    //컬럼 셋팅 end//

    var loadingNameID = 'loading_all_order';
    var loadingWordID = 'loading_word_all_order';

    var eventStartElement = document.createElement("div");
    eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
    //eventStartElement.innerHTML = "전체 리스트 <button id='download_excel' type='button'><img style='height: 100%;' src='https://img.icons8.com/color/96/2980b9/ms-excel.png'>엑셀 다운로드</button>"

    eventStartElement.innerHTML = "<div class='flex_layer'>" +
                                      "<p style='margin-top: auto;'>" +
                                      "전체 리스트 <button id='download_excel' type='button'><img style='height: 100%;' src='https://img.icons8.com/color/96/2980b9/ms-excel.png'>엑셀 다운로드</button>" +
                                      "</p>" +

                                      "<div class='flex_layer' style='margin-left: auto;'>" +
                                        "<div class='state_ticket_info_loading_word_wrapper state_ticket_margin_top'>" +
                                          "<p id='"+loadingWordID+"'>데이터 가져오는 중</p>" + 
                                        "</div>" +
                                        "<div class='state_ticket_info_loading_wrapper'>" +
                                          "<p id='"+loadingNameID+"' class='loading order_loading'></p>" +
                                        "</div>" +
                                      "</div>" +
                                    "</div>";
                                    
    order_all_supervise_container.append(eventStartElement);

    var parentElement = document.createElement("div");
    //parentElement.setAttribute('id', 'order_supervise_list_'+i);
    parentElement.setAttribute('class', 'order_supervise_list order_supervise_all_list');
    order_all_supervise_container.append(parentElement);

    var ajaxURL = '/orders/project/'+$('#project_id').val()+'/all';

    var export_table = new Tabulator(parentElement, {
      height: _tableHeight,
      placeholder:"No Data Set",
      layout:"fitDataFill",
      ajaxURL : ajaxURL, // ajax URL 
      ajaxProgressiveLoad : "load",
      ajaxProgressiveLoadDelay : call_delay_time, // 각 요청 사이에 200 밀리 초 대기
      paginationSize:call_once_order_count,
      selectable:true,
      movableColumns:true,
      columns:columnsArray,
      ajaxResponse:function(url, params, response){
      //url - the URL of the request
      //params - the parameters passed with the request
      //response - the JSON object returned in the body of the response.
        var callCount = response.data.length;
        if(callCount < call_once_order_count)
        {
          $('#'+'loading_word_all_order').text('데이터 모두 가져옴');
          $('#'+'loading_all_order').hide();
        }
        else
        {
          //if( $('#'+'loading_all_order').css("display") === "none" )
          //{
          //  $('#'+'loading_all_order').show();
          //}
        }

        return response; //return the response data to tabulator
      },
    });

    $("#download_excel").click(function(){
        if( $('#'+'loading_all_order').css("display") === "none" )
        {
          var project_title = $('#project_title').val();
          export_table.download("xlsx", project_title + "_주문관리.xlsx", {sheetName:"주문관리"}); 
        }
        else
        {
          //alert('데이터를 가져오는 중입니다. 잠시 후에 시도해주세요');
          swal('데이터를 가져오는 중입니다. 잠시 후에 시도해주세요', '', 'warning');
        }
    });
  }

  var requestOrdersAll = function(){
    loadingProcessWithSize($('.order_all_info_label'));
    var url="/orders/project/all";
    var method = 'get';
    var data =
    {
      'project_id' : $('#project_id').val()
    }
    var success = function(request) {
      loadingProcessStopWithSize($('.order_all_info_label'));
      if(request.state === 'success'){
        if(request.data_orders_count > 0)
        {
          $('.order_all_info_label').text('완료');
          initAllTable(request.data_goods, request.data_orders_count);
        }
        else
        {
          $('.order_all_info_label').text('없음');
        }
      }
    };
    
    var error = function(request) {
      loadingProcessStopWithSize($('.order_all_info_label'));
      console.error('error');
    };
    
    $.ajax({
    'url': url,
    'method': method,
    'data' : data,
    'success': success,
    'error': error
    });
  };

  var requestLightInfo = function(){
    var url="/orders/light/info";
    var method = 'get';
    var data =
    {
      'project_id' : $('#project_id').val()
    }
    var success = function(request) {
      if(request.state === 'success'){
        $('#order_light_info_label').text('총 참여자수: '+request.order_all_count+'명 / 총 티켓구매 : '+request.order_count+'매 / 취소 수 : '+request.order_cancel_count+'매 / 후원만한 금액 : '+request.order_support_total_price+'원 / 총 티켓 판매 금액 : '+request.order_total_price+'원');
      }
    };
    
    var error = function(request) {
      console.error('error');
    };
    
    $.ajax({
    'url': url,
    'method': method,
    'data' : data,
    'success': success,
    'error': error
    });
  };

  requestLightInfo();

  var checkboxImgToggle = function(isChecked, selectName, unselectName){
    if(isChecked){
      $("."+selectName).show();
      $("."+unselectName).hide();
    }
    else{
      $("."+selectName).hide();
      $("."+unselectName).show();
    }
  }

  var checkAllToggle = function(isAll){
    if(isAll)
    {
      document.getElementById("input_check_box_tickets").checked = isAll;
      checkboxImgToggle(isAll, 'checkbox_img_select_tickets', 'checkbox_img_unselect_tickets');

      document.getElementById("input_check_box_all_list").checked = isAll;
      checkboxImgToggle(isAll, 'checkbox_img_select_all_list', 'checkbox_img_unselect_all_list');

      if($('#input_check_box_tickets').attr('data-ischecked') === 'ischecked')
      {
        setToggleTicketsValue(true, false);
      }
      else
      {
        setToggleTicketsValue(true, true);
        setIsChecked($('#input_check_box_tickets'), 'ischecked');
      }

      if($('#input_check_box_all_list').attr('data-ischecked') === 'ischecked')
      {
        setToggleAllListValue(true, false);
      }
      else
      {
        setToggleAllListValue(true, true);
        setIsChecked($('#input_check_box_all_list'), 'ischecked');
      }
    }
    else
    {
      document.getElementById("input_check_box_tickets").checked = isAll;
      checkboxImgToggle(isAll, 'checkbox_img_select_tickets', 'checkbox_img_unselect_tickets');

      document.getElementById("input_check_box_all_list").checked = isAll;
      checkboxImgToggle(isAll, 'checkbox_img_select_all_list', 'checkbox_img_unselect_all_list');

      setToggleTicketsValue(false, false);
      setToggleAllListValue(false, false);
    }
  }

  var setToggleTicketsValue = function(isToggle, isFirst){
    if(isToggle)
    {
      if(isFirst)
      {
        requestTicketList();
        requestNoTicketList();
        requestOnlySupportList();
      }
      else
      {
        $('#order_supervise_container').show();
        $('#order_no_ticket_supervise_container').show();
      }
    }
    else
    {
      $('#order_supervise_container').hide();
      $('#order_no_ticket_supervise_container').hide();
    }
  };

  var setToggleAllListValue = function(isToggle, isFirst){
    if(isToggle)
    {
      if(isFirst)
      {
        requestOrdersAll();
      }
      else
      {
        $('#order_all_supervise_container').show();
      }
    }
    else
    {
      $('#order_all_supervise_container').hide();
    }
  };

  var setIsChecked = function(dom, isChecked){
    dom.attr('data-ischecked', isChecked);
  };

  $("#input_check_box_all").change(function(){
    if($(this).is(":checked")){
      //익명 체크하면
      checkboxImgToggle(true, 'checkbox_img_select_all', 'checkbox_img_unselect_all');
      checkAllToggle(true);
    }
    else{
      checkboxImgToggle(false, 'checkbox_img_select_all', 'checkbox_img_unselect_all');
      checkAllToggle(false);
    }
  });

  $("#input_check_box_tickets").change(function(){
    if($(this).is(":checked")){
      //체크하면
      checkboxImgToggle(true, 'checkbox_img_select_tickets', 'checkbox_img_unselect_tickets');

      if($(this).attr('data-ischecked') === 'ischecked')
      {
        setToggleTicketsValue(true, false);
      }
      else
      {
        setToggleTicketsValue(true, true);
        setIsChecked($(this), 'ischecked');
      }
    }
    else{
      checkboxImgToggle(false, 'checkbox_img_select_tickets', 'checkbox_img_unselect_tickets');
      setToggleTicketsValue(false, false);
    }
  });

  $("#input_check_box_all_list").change(function(){
    if($(this).is(":checked")){
      //체크하면
      checkboxImgToggle(true, 'checkbox_img_select_all_list', 'checkbox_img_unselect_all_list');

      if($(this).attr('data-ischecked') === 'ischecked')
      {
        setToggleAllListValue(true, false);
      }
      else
      {
        setToggleAllListValue(true, true);
        setIsChecked($(this), 'ischecked');
      }
    }
    else{
      checkboxImgToggle(false, 'checkbox_img_select_all_list', 'checkbox_img_unselect_all_list');
      setToggleAllListValue(false, false);
    }
  });
});

</script>
@endsection
