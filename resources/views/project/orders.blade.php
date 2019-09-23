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

        #order_supervise_container{
          /*width: 900px;
          margin-left: auto;
          margin-right: auto;*/
        }

        .order_container{
          width: 900px;
          /*width: 100%;*/
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
/*
        .order_supervise_all_list{
          max-height: 300px;
        }
  */

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

      var eventStartElement = document.createElement("div");
      eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
      $(eventStartElement).text(getTicketDateFullInfoWithCategoryText(ticketInfo.show_date, ticketInfo.ticket_name));
      order_supervise_container.append(eventStartElement);

      var parentElement = document.createElement("div");
      parentElement.setAttribute('class', 'order_supervise_list');
      order_supervise_container.append(parentElement);

      var loadingNameID = 'loading_ticket_id_' + ticketInfo.id;
      var loadingWordID = 'loading_word_ticket_id_' + ticketInfo.id;

      var loadingElement = document.createElement("div");
      loadingElement.setAttribute('class', 'order_state_container');
      loadingElement.innerHTML = "<div class='flex_layer'>" +
                                    "<div class='state_ticket_info_wrapper state_ticket_margin_top'>" +
                                      "<p>"+getTicketDateFullInfoWithCategoryText(ticketInfo.show_date, ticketInfo.ticket_name)+"</p>" +
                                    "</div>" +
                                    "<div class='state_ticket_info_loading_word_wrapper state_ticket_margin_top'>" +
                                      "<p id='"+loadingWordID+"'>데이터 가져오는 중</p>" + 
                                    "</div>" +
                                    "<div class='state_ticket_info_loading_wrapper'>" +
                                      "<p id='"+loadingNameID+"' class='loading order_loading'></p>" +
                                    "</div>" +
                                  "</div>";

      order_supervise_container.append(loadingElement);

      var ajaxURL = '/orders/project/'+$('#project_id').val()+'/objects/' + ticketInfo.id;
      var table = new Tabulator(parentElement, {
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
    var url="/orders/project/tickets";
    var method = 'get';
    var data =
    {
      'project_id' : $('#project_id').val()
    }
    var success = function(request) {
      if(request.state === 'success'){
        initTable(request.data_tickets, request.data_goods);
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

    var eventStartElement = document.createElement("div");
    eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
    
    $(eventStartElement).text('티켓 구매 안하신 분(굿즈, 후원)');
    order_no_ticket_supervise_container.append(eventStartElement);

    var parentElement = document.createElement("div");
    parentElement.setAttribute('class', 'order_supervise_list');
    order_no_ticket_supervise_container.append(parentElement);

    var loadingNameID = 'loading_no_ticket_order';
    var loadingWordID = 'loading_word_no_ticket_order';

    var loadingElement = document.createElement("div");
    loadingElement.setAttribute('class', 'order_state_container');
    loadingElement.innerHTML = "<div class='flex_layer'>" +
                                    "<div class='state_ticket_info_wrapper state_ticket_margin_top'>" +
                                      "<p>"+'티켓 구매 안하신 분(굿즈, 후원)'+"</p>" +
                                    "</div>" +
                                    "<div class='state_ticket_info_loading_word_wrapper state_ticket_margin_top'>" +
                                      "<p id='"+loadingWordID+"'>데이터 가져오는 중</p>" + 
                                    "</div>" +
                                    "<div class='state_ticket_info_loading_wrapper'>" +
                                      "<p id='"+loadingNameID+"' class='loading order_loading'></p>" +
                                    "</div>" +
                                  "</div>";

    order_no_ticket_supervise_container.append(loadingElement);

    var ajaxURL = '/orders/project/'+$('#project_id').val()+'/notickets';
    var table = new Tabulator(parentElement, {
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
          //티켓 미구매인데 주문이 있을때 초기화 해준다.
          initNoTicketTable(request.data_goods);
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

    var eventStartElement = document.createElement("div");
    eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
    //$(eventStartElement).text(getTicketDateFullInfoWithCategoryText(ticketInfo.show_date, ticketInfo.ticket_name));
    $(eventStartElement).text('후원만 하신분');
    order_no_ticket_supervise_container.append(eventStartElement);

    var parentElement = document.createElement("div");
    parentElement.setAttribute('class', 'order_supervise_list');
    order_no_ticket_supervise_container.append(parentElement);

    //var loadingNameID = 'loading_order_id_' + orderInfo.id;
    //var loadingWordID = 'loading_word_order_id_' + orderInfo.id;
    var loadingNameID = 'loading_support_order';
    var loadingWordID = 'loading_word_support_order';

    var loadingElement = document.createElement("div");
    loadingElement.setAttribute('class', 'order_state_container');
    loadingElement.innerHTML = "<div class='flex_layer'>" +
                                    "<div class='state_ticket_info_wrapper state_ticket_margin_top'>" +
                                      "<p>"+'후원만 하신분'+"</p>" +
                                    "</div>" +
                                    "<div class='state_ticket_info_loading_word_wrapper state_ticket_margin_top'>" +
                                      "<p id='"+loadingWordID+"'>데이터 가져오는 중</p>" + 
                                    "</div>" +
                                    "<div class='state_ticket_info_loading_wrapper'>" +
                                      "<p id='"+loadingNameID+"' class='loading order_loading'></p>" +
                                    "</div>" +
                                  "</div>";
    order_no_ticket_supervise_container.append(loadingElement);

    var ajaxURL = '/orders/project/'+$('#project_id').val()+'/supports';
    var table = new Tabulator(parentElement, {
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
          initSupportsTable();
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
    var g_question_object = '';
    if(question_object_json)
    {
      g_question_object = $.parseJSON(question_object_json);
    }

    //컬럼 셋팅 start//
    var columnsArray = new Array();
    //columnsArray.push(formatterObject);
    var tableHeight = "375px";
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
      tableHeight = "100%";
    }

    //컬럼 셋팅 end//

    var eventStartElement = document.createElement("div");
    eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
    //$(eventStartElement).text("");
    eventStartElement.innerHTML = "전체 리스트 <button id='download_excel' type='button'><img style='height: 100%;' src='https://img.icons8.com/color/96/2980b9/ms-excel.png'>엑셀 다운로드</button><button id='down_all_button'>다운로드</button>"
    order_all_supervise_container.append(eventStartElement);

    var parentElement = document.createElement("div");
    //parentElement.setAttribute('id', 'order_supervise_list_'+i);
    parentElement.setAttribute('class', 'order_supervise_list order_supervise_all_list');
    order_all_supervise_container.append(parentElement);

    var loadingNameID = 'loading_all_order';
    var loadingWordID = 'loading_word_all_order';

    var loadingElement = document.createElement("div");
    loadingElement.setAttribute('class', 'order_state_container');
    loadingElement.innerHTML = "<div class='flex_layer'>" +
                                    "<div class='state_ticket_info_wrapper state_ticket_margin_top'>" +
                                      "<p>"+'전체 리스트'+"</p>" +
                                    "</div>" +
                                    "<div class='state_ticket_info_loading_word_wrapper state_ticket_margin_top'>" +
                                      "<p id='"+loadingWordID+"'>데이터 가져오기를 눌러주세요</p>" + 
                                    "</div>" +
                                    "<div class='state_ticket_info_loading_wrapper'>" +
                                      "<p id='"+loadingNameID+"' class='loading order_loading'></p>" +
                                    "</div>" +
                                  "</div>";
    order_all_supervise_container.append(loadingElement);

    var ajaxURL = '/orders/project/'+$('#project_id').val()+'/all';

    var export_table = new Tabulator(parentElement, {
      height: tableHeight,
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

    //$('#down_all_button').click(function(){
    //  export_table.setData('/orders/project/'+$('#project_id').val()+'/all')
    //});

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
    var url="/orders/project/all";
    var method = 'get';
    var data =
    {
      'project_id' : $('#project_id').val()
    }
    var success = function(request) {
      if(request.state === 'success'){
        if(request.data_orders_count > 0)
        {
          initAllTable(request.data_goods, request.data_orders_count);
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

  requestOrdersAll();

});

</script>
@endsection
