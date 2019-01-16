@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/lib/table/tabulator.css') }}">
    <style>
        @media (max-width: 900px)
        {
          body{
            width: 900px;
          }
        }

        #order_supervise_container{
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
          margin-bottom: 30px;
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
    </style>
@endsection

@section('content')

    <?php
    $goodsList = $project->goods;

    //$testa = $test;
    //$testa = json_decode($testa, false);
    ?>
<input id="supervise_orders" type="hidden" value="{{$ordersWithTimeJson}}"/>
<input id="supervise_orders_no_ticket" type="hidden" value="{{$ordersNoTicketJson}}"/>
<input id="supervise_orders_all_ticket" type="hidden" value="{{$ordersAllWithTimeJson}}"/>
<input id="supervise_goods_list_json" type="hidden" value="{{$project->goods}}"/>
<input id="project_title" type="hidden" value="{{$project->title}}"/>

    @include('helper.btn_admin', ['project' => $project])

    <div class="first-container container">
        <div class="row">
            <h2 class="text-center text-important">주문 관리</h2>
            <p class="text-center">조회수 {{ $project->view_count }}</p>
            <p class="text-center">** pc에 최적화 되어있습니다. **</p>
        </div>

    </div>
    <div id="order_supervise_container">
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
    //var columnsInfo = [{"이름", "bbb"}, "티켓수량", "추가후원", "GOODSOBJECT", "할인내용", "결제금액", "상태", "결제일", "이메일", "전화번호", "굿즈수령주소", "기타사항"];
    var columnsInfo = [
        //{title:"아이디(test)", field:"id", align:"center", width:103},
        {title:"이름", field:"name", align:"center", width:103},
        {title:"티켓종류", field:"ticket_category", align:"center"},
        {title:"티켓매수", field:"count", align:"right", width:88, sorter:"number", bottomCalc: "sum"},
        {title:"결제금액", field:"totalPriceWithoutCommission", align:"right", bottomCalc: "sum"},
        {title:"상태", field:"state_string", align:"center"},
        {title:"이메일", field:"email", align:"center", width:221},
        {title:"전화번호", field:"contact", align:"center", width:151},
        {title:"출석", field:"attended", align:"center", formatter:"tickCross", sorter:"boolean"},
        {title:"GOODSOBJECT", field:"GOODSOBJECT", align:"center", width:80, bottomCalc: "sum"},//반드시 title과 filed 는 GOODSOBJECT 이어야 함.
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
        //{title:"아이디(test)", field:"name", align:"center", width:103},
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
    ];

    var project_title = $('#project_title').val();

    var supervise_orders_json = $('#supervise_orders').val();
    var supervise_orders = $.parseJSON(supervise_orders_json);
    if(supervise_orders.length > 0)
    {
      supervise_orders = sortByKey(supervise_orders, 'show_date_unix');
    }

    var supervise_orders_no_ticket_json = $('#supervise_orders_no_ticket').val();
    var supervise_orders_no_ticket = $.parseJSON(supervise_orders_no_ticket_json);

    //supervise_orders_all_ticket
    var supervise_orders_all_ticket_json = $('#supervise_orders_all_ticket').val();
    var supervise_orders_all_ticket = $.parseJSON(supervise_orders_all_ticket_json);
    if(supervise_orders_all_ticket[0]['orders'].length > 0)
    {
      supervise_orders_all_ticket[0]['orders'] = sortByKey(supervise_orders_all_ticket[0]['orders'], 'show_date_unix');
    }

    var supervise_goods_list_json = $('#supervise_goods_list_json').val();
    var supervise_goods_list = $.parseJSON(supervise_goods_list_json);
    //alert(supervise_goods_list.length);

    var order_supervise_container = $('#order_supervise_container');

    var columnsArray = new Array();

    //앞단 플러스
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
    columnsArray.push(formatterObject);
    //columnsNoTicketArray.push(formatterObject);

//주문자 컬럼 셋팅
    for(var i = 0 ; i < columnsInfo.length ; i++)
    {
      var columnsInfoRow = columnsInfo[i];
      if(columnsInfoRow.title === 'GOODSOBJECT')
      {
        for(var j = 0 ; j < supervise_goods_list.length ; j++)
        {
          var columnsGoods = new Object();
          columnsGoods.title = supervise_goods_list[j].title;
          columnsGoods.field = 'goods'+supervise_goods_list[j].id;
          columnsGoods.width = 80;
          columnsGoods.align = 'center';
          columnsGoods.sorter = "number";

          columnsArray.push(columnsGoods);
        }

        continue;
      }

      var columnsObject = new Object();

      if(columnsInfoRow.title)
      {
        columnsObject.title = columnsInfoRow.title;
      }

      if(columnsInfoRow.field)
      {
        columnsObject.field = columnsInfoRow.field;
      }
      if(columnsInfoRow.align)
      {
        columnsObject.align = columnsInfoRow.align;
      }
      if(columnsInfoRow.width)
      {
        columnsObject.width = columnsInfoRow.width;
      }

      if(columnsInfoRow.sorter)
      {
        columnsObject.sorter = columnsInfoRow.sorter;
      }

      if(columnsInfoRow.formatter)
      {
        columnsObject.formatter = columnsInfoRow.formatter;
      }

      if(columnsInfoRow.sorter)
      {
        columnsObject.sorter = columnsInfoRow.sorter;
      }

      //bottomCalc
      if(columnsInfoRow.bottomCalc)
      {
        columnsObject.bottomCalc = columnsInfoRow.bottomCalc;
      }

      columnsArray.push(columnsObject);
    }

    for(var i = 0 ; i < supervise_orders.length ; i++)
    {
      var eventStartElement = document.createElement("div");
      eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
      $(eventStartElement).text(getTicketDateFullInfoWithCategoryText(supervise_orders[i]['show_date'], supervise_orders[i]['ticket_category']));
      order_supervise_container.append(eventStartElement);

      var parentElement = document.createElement("div");
      //parentElement.setAttribute('id', 'order_supervise_list_'+i);
      parentElement.setAttribute('class', 'order_supervise_list');
      order_supervise_container.append(parentElement);

      var tableDataArray = new Array();

      for(var j = 0 ; j < supervise_orders[i]['orders'].length ; j++)
      {
        var order = supervise_orders[i]['orders'][j];

        var orderGoodsList = '';
        if(order.goods_meta)
        {
          orderGoodsList = $.parseJSON(order.goods_meta);
        }

        //alert(order['id']);
        var orderObject = new Object();
        for(var k = 0 ; k < columnsArray.length ; k++)
        {
          var fieldName = columnsArray[k].field;
          var orderValue = order[fieldName];

          var valueBackWord = '';
          switch(fieldName)
          {
            case 'count':
              valueBackWord = "매";

          }
          orderObject[fieldName] = orderValue;
        }

        tableDataArray.push(orderObject);
      }

      var table = new Tabulator(parentElement, {
          layout:"fitDataFill",
          responsiveLayout:"collapse",
          columns:columnsArray,
          data:tableDataArray,
          responsiveLayoutCollapseStartOpen:false,
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



    //티켓 미구매 컬럼
    var columnsNoTicketArray = new Array();
    columnsNoTicketArray.push(formatterObject);
    for(var i = 0 ; i < columnsNoTicketInfo.length ; i++)
    {
      var columnsInfoRow = columnsNoTicketInfo[i];
      if(columnsInfoRow.title === 'GOODSOBJECT')
      {
        for(var j = 0 ; j < supervise_goods_list.length ; j++)
        {
          var columnsGoods = new Object();
          columnsGoods.title = supervise_goods_list[j].title;
          columnsGoods.field = 'goods'+supervise_goods_list[j].id;
          columnsGoods.width = 80;
          columnsGoods.align = 'center';
          columnsGoods.sorter = "number";

          columnsNoTicketArray.push(columnsGoods);
        }

        continue;
      }

      var columnsObject = new Object();

      if(columnsInfoRow.title)
      {
        columnsObject.title = columnsInfoRow.title;
      }

      if(columnsInfoRow.field)
      {
        columnsObject.field = columnsInfoRow.field;
      }
      if(columnsInfoRow.align)
      {
        columnsObject.align = columnsInfoRow.align;
      }
      if(columnsInfoRow.width)
      {
        columnsObject.width = columnsInfoRow.width;
      }

      if(columnsInfoRow.sorter)
      {
        columnsObject.sorter = columnsInfoRow.sorter;
      }

      if(columnsInfoRow.formatter)
      {
        columnsObject.formatter = columnsInfoRow.formatter;
      }

      if(columnsInfoRow.sorter)
      {
        columnsObject.sorter = columnsInfoRow.sorter;
      }

      //bottomCalc
      if(columnsInfoRow.bottomCalc)
      {
        columnsObject.bottomCalc = columnsInfoRow.bottomCalc;
      }

      columnsNoTicketArray.push(columnsObject);
    }

    //티켓 미구매 테이블 셋팅
    for(var i = 0 ; i < supervise_orders_no_ticket.length ; i++)
    {
      //후원자가 있는지 우선 체크
      var isBuyGoods = false;
      for(var j = 0 ; j < supervise_orders_no_ticket[i]['orders'].length ; j++)
      {
        var order = supervise_orders_no_ticket[i]['orders'][j];
        var orderGoodsList = '';
        if(order.goods_meta)
        {
          orderGoodsList = $.parseJSON(order.goods_meta);
        }

        var orderGoodsCount = Object.keys(orderGoodsList).length;

        if(orderGoodsCount > 0)
        {

          isBuyGoods = true;
          break;
        }
      }

      if(!isBuyGoods)
      {
        break;
      }

      var eventStartElement = document.createElement("div");
      eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
      $(eventStartElement).text("굿즈 및 후원(티켓 미구매)");
      order_supervise_container.append(eventStartElement);

      var parentElement = document.createElement("div");
      //parentElement.setAttribute('id', 'order_supervise_list_'+i);
      parentElement.setAttribute('class', 'order_supervise_list');
      order_supervise_container.append(parentElement);

      var tableDataArray = new Array();

      for(var j = 0 ; j < supervise_orders_no_ticket[i]['orders'].length ; j++)
      {
        var order = supervise_orders_no_ticket[i]['orders'][j];

        var orderGoodsList = '';
        if(order.goods_meta)
        {
          orderGoodsList = $.parseJSON(order.goods_meta);
        }

        var orderGoodsCount = Object.keys(orderGoodsList).length;
        if(orderGoodsCount > 0)
        {
          var orderObject = new Object();
          for(var k = 0 ; k < columnsNoTicketArray.length ; k++)
          {
            var fieldName = columnsNoTicketArray[k].field;
            var orderValue = order[fieldName];
            orderObject[fieldName] = orderValue;
          }

          tableDataArray.push(orderObject);
        }
      }

      var table = new Tabulator(parentElement, {
          layout:"fitDataFill",
          responsiveLayout:"collapse",
          columns:columnsNoTicketArray,
          data:tableDataArray,
          responsiveLayoutCollapseStartOpen:false,
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

    //후원만 하신분

    var columnsOnlySupportArray = new Array();
    columnsOnlySupportArray.push(formatterObject);
    for(var i = 0 ; i < columnsOnlySupportInfo.length ; i++)
    {
      var columnsInfoRow = columnsOnlySupportInfo[i];

      var columnsObject = new Object();

      if(columnsInfoRow.title)
      {
        columnsObject.title = columnsInfoRow.title;
      }

      if(columnsInfoRow.field)
      {
        columnsObject.field = columnsInfoRow.field;
      }
      if(columnsInfoRow.align)
      {
        columnsObject.align = columnsInfoRow.align;
      }
      if(columnsInfoRow.width)
      {
        columnsObject.width = columnsInfoRow.width;
      }

      if(columnsInfoRow.sorter)
      {
        columnsObject.sorter = columnsInfoRow.sorter;
      }

      if(columnsInfoRow.formatter)
      {
        columnsObject.formatter = columnsInfoRow.formatter;
      }

      if(columnsInfoRow.sorter)
      {
        columnsObject.sorter = columnsInfoRow.sorter;
      }

      //bottomCalc
      if(columnsInfoRow.bottomCalc)
      {
        columnsObject.bottomCalc = columnsInfoRow.bottomCalc;
      }

      columnsOnlySupportArray.push(columnsObject);
    }

    //후원자 테이블 셋팅
    for(var i = 0 ; i < supervise_orders_no_ticket.length ; i++)
    {
      //후원자가 있는지 우선 체크
      var isSupporter = false;
      for(var j = 0 ; j < supervise_orders_no_ticket[i]['orders'].length ; j++)
      {
        var order = supervise_orders_no_ticket[i]['orders'][j];
        var orderGoodsList = '';
        if(order.goods_meta)
        {
          orderGoodsList = $.parseJSON(order.goods_meta);
        }

        var orderGoodsCount = Object.keys(orderGoodsList).length;

        if(order.supporterPrice != 0 && orderGoodsCount === 0)
        {

          isSupporter = true;
          break;
        }
      }

      if(!isSupporter)
      {
        break;
      }

      var eventStartElement = document.createElement("div");
      eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
      $(eventStartElement).text("후원만 하신분");
      order_supervise_container.append(eventStartElement);

      var parentElement = document.createElement("div");
      //parentElement.setAttribute('id', 'order_supervise_list_'+i);
      parentElement.setAttribute('class', 'order_supervise_list');
      order_supervise_container.append(parentElement);

      var tableDataArray = new Array();

      for(var j = 0 ; j < supervise_orders_no_ticket[i]['orders'].length ; j++)
      {
        var order = supervise_orders_no_ticket[i]['orders'][j];
        var orderGoodsList = '';
        if(order.goods_meta)
        {
          orderGoodsList = $.parseJSON(order.goods_meta);
        }

        var orderGoodsCount = Object.keys(orderGoodsList).length;

        if(order.supporterPrice != 0 && orderGoodsCount === 0)
        {
          var orderObject = new Object();
          for(var k = 0 ; k < columnsOnlySupportArray.length ; k++)
          {
            var fieldName = columnsOnlySupportArray[k].field;
            var orderValue = order[fieldName];
            orderObject[fieldName] = orderValue;
          }

          tableDataArray.push(orderObject);
        }
      }

      var table = new Tabulator(parentElement, {
          layout:"fitDataFill",
          responsiveLayout:"collapse",
          columns:columnsOnlySupportArray,
          data:tableDataArray,
          responsiveLayoutCollapseStartOpen:false,
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


    //전체보기 셋팅 _ 컬럼 셋팅
    var columnsAllArray = new Array();
    //columnsAllArray.push(formatterObject);
    for(var i = 0 ; i < columnsAllInfo.length ; i++)
    {
      var columnsInfoRow = columnsAllInfo[i];
      if(columnsInfoRow.title === 'GOODSOBJECT')
      {
        for(var j = 0 ; j < supervise_goods_list.length ; j++)
        {
          var columnsGoods = new Object();
          columnsGoods.title = supervise_goods_list[j].title;
          columnsGoods.field = 'goods'+supervise_goods_list[j].id;
          columnsGoods.width = 80;
          columnsGoods.align = 'center';
          columnsGoods.sorter = "number";
          columnsGoods.bottomCalc = "sum";

          columnsAllArray.push(columnsGoods);
        }

        continue;
      }

      var columnsObject = new Object();

      if(columnsInfoRow.title)
      {
        columnsObject.title = columnsInfoRow.title;
      }

      if(columnsInfoRow.field)
      {
        columnsObject.field = columnsInfoRow.field;
      }
      if(columnsInfoRow.align)
      {
        columnsObject.align = columnsInfoRow.align;
      }
      if(columnsInfoRow.width)
      {
        columnsObject.width = columnsInfoRow.width;
      }

      if(columnsInfoRow.sorter)
      {
        columnsObject.sorter = columnsInfoRow.sorter;
      }

      if(columnsInfoRow.formatter)
      {
        columnsObject.formatter = columnsInfoRow.formatter;
      }

      if(columnsInfoRow.sorter)
      {
        columnsObject.sorter = columnsInfoRow.sorter;
      }

      if(columnsInfoRow.headerFilter)
      {
        columnsObject.headerFilter = columnsInfoRow.headerFilter;
      }

      if(columnsInfoRow.bottomCalc)
      {
        columnsObject.bottomCalc = columnsInfoRow.bottomCalc;
      }

      columnsAllArray.push(columnsObject);
    }

    //전체보기 값 셋팅
    var tableAllDataArray = new Array();
    var tableHeight = "375px";
    for(var i = 0 ; i < supervise_orders_all_ticket.length ; i++)
    {
      var eventStartElement = document.createElement("div");
      eventStartElement.setAttribute('class', 'order_supervise_list_event_start');
      //$(eventStartElement).text("");
      eventStartElement.innerHTML = "전체 리스트 <button id='download_excel' type='button'><img style='height: 100%;' src='https://img.icons8.com/color/96/2980b9/ms-excel.png'>엑셀 다운로드</button>"
      order_supervise_container.append(eventStartElement);

      var parentElement = document.createElement("div");
      //parentElement.setAttribute('id', 'order_supervise_list_'+i);
      parentElement.setAttribute('class', 'order_supervise_list order_supervise_all_list');
      order_supervise_container.append(parentElement);


      for(var j = 0 ; j < supervise_orders_all_ticket[i]['orders'].length ; j++)
      {
        var order = supervise_orders_all_ticket[i]['orders'][j];

        var orderGoodsList = '';
        if(order.goods_meta)
        {
          orderGoodsList = $.parseJSON(order.goods_meta);
        }

        var orderObject = new Object();
        for(var k = 0 ; k < columnsAllArray.length ; k++)
        {
          var fieldName = columnsAllArray[k].field;
          var orderValue = order[fieldName];

          orderObject[fieldName] = orderValue;

          //날짜 미정인지 체크
          if(fieldName === "show_date")
          {
            var rawDate = orderValue.split(" ");
            var d = rawDate[0].split("-");
            var t = rawDate[1].split(":");

            if(d[0] == 0000){
              //날짜 미정
              orderObject[fieldName] = "날짜 미정";
            }
          }
        }

        tableAllDataArray.push(orderObject);
      }

      if(supervise_orders_all_ticket[i]['orders'].length == 0)
      {
        var orderObject = new Object();
        orderObject['id'] = "구매 내역 없음";
        tableAllDataArray.push(orderObject);
      }

      if(supervise_orders_all_ticket[i]['orders'].length <= 13)
      {
        tableHeight = "100%";
      }
    }
    var table = new Tabulator(parentElement, {
        height: tableHeight,
        layout:"fitDataFill",
        selectable:true,
        movableColumns:true,
        columns:columnsAllArray,
        data:tableAllDataArray,
    });
/*
    $("#download_excel").click(function(){
        table.download("xlsx", "data.xlsx", {sheetName:"My Data"});
    });
*/

    //테이블 테스트
    //다운로드 테이블 데이터 셋팅
    //데이터 셋팅 컬럼 만들기

    for(var i = 0 ; i < columnsAllArray.length ; i++)
    {
      var columTitle = columnsAllArray[i].title;
      var columElement = document.createElement("th");
      columElement.innerHTML = columTitle;
      //columElement.innerHTML = "<th>" + columTitle + "</th>";
      $('#export_table_head_tr').append(columElement);
    }

    //데이터 셋팅
    var export_table_body = $('#export_table_body');
    var tableValueArray = [];
    for(var i = 0 ; i < supervise_orders_all_ticket.length ; i++)
    {

      for(var j = 0 ; j < supervise_orders_all_ticket[i]['orders'].length ; j++)
      {
        var order = supervise_orders_all_ticket[i]['orders'][j];

        var orderGoodsList = '';
        if(order.goods_meta)
        {
          orderGoodsList = $.parseJSON(order.goods_meta);
        }

        var orderTableElement = document.createElement("tr");

        //var orderObject = new Object();
        for(var k = 0 ; k < columnsAllArray.length ; k++)
        {
          var fieldName = columnsAllArray[k].field;

          var fieldNameCheck = fieldName;
          if(fieldName.indexOf('goods') >= 0)
          {
            fieldNameCheck = "GOODSOBJECT";
          }
          //order value 값
          switch(fieldNameCheck)
          {
              case 'count':
              case 'totalPriceWithoutCommission':
              case 'supporterPrice':
              case 'GOODSOBJECT':
              {
                var isHaveData = false;
                var orderValue = Number(order[fieldName]);

                for(var m = 0 ; m < tableValueArray.length ; m++)
                {
                  if(fieldName === tableValueArray[m].fieldName)
                  {
                    //var arrayValue = tableValueArray[m].value;
                    tableValueArray[m].value = tableValueArray[m].value + orderValue;
                    isHaveData = true;
                    break;
                  }
                }

                if(!isHaveData)
                {
                  tableValueArray.push({'fieldName' : fieldName,
                                        'value' : orderValue});
                }
              }

          }

          var orderValue = "<td field-name='"+ fieldName +"'>" + order[fieldName] + '</td>';

          orderTableElement.innerHTML = orderTableElement.innerHTML + orderValue;
        }

        export_table_body.append(orderTableElement);
      }
    }


    //최종 합계 셋팅
    var sumTableElement = document.createElement("tr");
    for(var i = 0 ; i < columnsAllArray.length ; i++)
    {
      var columfieldName = columnsAllArray[i].field;
      var columTitleName = columnsAllArray[i].title;

      //var orderValue = "<td class='order_export_table_list' field-name='"+ fieldName +"'>" + order[fieldName] + '</td>';
      var arrayValue = '';
      if(i === 0)
      {
        arrayValue = "합계";
      }
      for(var j = 0 ; j < tableValueArray.length ; j++)
      {

        var arrayFieldName = tableValueArray[j].fieldName;

        if(columfieldName === arrayFieldName)
        {
          arrayValue = tableValueArray[j].value;
          break;
        }
      }

      var tdElement = "<td field-name='"+ columfieldName +"'>" + arrayValue + '</td>';
      sumTableElement.innerHTML = sumTableElement.innerHTML + tdElement;
    }

    export_table_body.append(sumTableElement);

    //합계
    var export_table = new Tabulator("#export_table", {});
    $("#download_excel").click(function(){
        export_table.download("xlsx", project_title + "_주문관리.xlsx", {sheetName:"주문관리"});
    });

  });

</script>
@endsection
