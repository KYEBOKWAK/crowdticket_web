@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/lib/table/tabulator.css') }}">
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

    <?php
    $goodsList = $project->goods;

    //$testa = $test;
    //$testa = json_decode($testa, false);
    ?>
<input id="orderList" type="hidden" value="{{$orderList}}"/>
<input id="pickingOldList" type="hidden" value="{{$pickingOldList}}"/>
<input id="isPickComplete" type="hidden" value="{{$project->isPickedComplete()}}">

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

        <p id="pick_list_counter" pick-count='' projectid='{{$project->id}}'>추첨된 인원수 : 0명</p>
      </div>
      <div id="pick_list_container">
      </div>

      @if(!$project->isPickedComplete())
        <div id="orders_container">
        </div>
      @endif

      @if (\Auth::check() && \Auth::user()->isAdmin())
        <input id="pickingYList" type="hidden" value="{{$pickingYList}}"/>
        <div id="orders_container_fire_N">
        </div>
        <div id="orders_container_fire">
        </div>
      @endif
    </div>

@endsection

@section('js')

<script type="text/javascript" src="{{ asset('/js/lib/table/tabulator.min.js') }}"></script>

<script>
  $(document).ready(function () {
    var g_isPickComplete = $('#isPickComplete').val();
    var orders_json = $('#orderList').val();
    var orders = null;
    if(orders_json)
    {
      orders = $.parseJSON(orders_json);
    }

    var picking_old_json = $('#pickingOldList').val();
    var picking_old_list = null;
    if(picking_old_json)
    {
      picking_old_list = $.parseJSON(picking_old_json);
    }

    //console.error(picking_old_list);

    var isWorkedCollapse = false;
    var isWorkedCollapsePick = false;

    var pickIcon = function(cell, formatterParams, onRendered){ //plain text value
        return "<button class='pickButton'>추첨하기</button>";
    };

    var unpickIcon = function(cell, formatterParams, onRendered){ //plain text value
      if(g_isPickComplete)
      {
        return "<div>추첨완료</div>";
      }

      return "<button class='pickButton'>추첨빼기</button>";
    };

    var columnsInfo = [
        {formatter:"responsiveCollapse", field:"plus", width:30, minWidth:30, align:"center", resizable:false, headerSort:false, cellClick:function(e, cell){
          isWorkedCollapse = true;
        }},

        {title:"추첨하기", field:"pick", align:"center",formatter:pickIcon, width:103},
        {title:"이름", field:"name", align:"center", width:103},
        {title:"티켓매수", field:"count", align:"right", width:88, sorter:"number"},
        {title:"이메일", field:"email", align:"center", width:221},
        {title:"전화번호", field:"contact", align:"center", width:151},
        {title:"사연", field:"order_story", align:"center", width:151},
    ];

    var unpickTitle = "추첨빼기";
    if(g_isPickComplete)
    {
      unpickTitle = "추첨완료";
    }

    var columnsPickInfo = [
        {formatter:"responsiveCollapse", field:"plus", width:30, minWidth:30, align:"center", resizable:false, headerSort:false, cellClick:function(e, cell){
          isWorkedCollapsePick = true;
        }},

        {title:unpickTitle, field:"unpick", align:"center",formatter:unpickIcon, width:103},
        {title:"이름", field:"name", align:"center", width:103},
        {title:"티켓매수", field:"count", align:"right", width:88, sorter:"number"},
        {title:"이메일", field:"email", align:"center", width:221},
        {title:"전화번호", field:"contact", align:"center", width:151},
        {title:"사연", field:"order_story", align:"center", width:151},
    ];

    ///////////table 값 셋팅
    var tableDataArray = new Array();
    var tablePickDataArray = new Array();

    for(var i = 0 ; i < orders.length ; i++)
    {
      var order = orders[i];

      var orderObject = new Object();
      orderObject = order;

      orderObject.order_id = order.id;
      //orderObject.id = i + 1;

      tableDataArray.push(orderObject);
    }

    for(var i = 0 ; i < picking_old_list.length ; i++)
    {
      var order = picking_old_list[i];

      var orderObject = new Object();
      orderObject = order;

      orderObject.order_id = order.id;
      //orderObject.id = i + 1;

      tablePickDataArray.push(orderObject);
    }

    var orders_container = $('#orders_container');

    var pick_list_container = $('#pick_list_container');

    var parentElement = document.createElement("div");
    parentElement.setAttribute('class', 'order_supervise_list');
    orders_container.append(parentElement);

    var pickListparentElement = document.createElement("div");
    pickListparentElement.setAttribute('class', 'order_supervise_list');
    pick_list_container.append(pickListparentElement);

    var isPickClick = false;
    var isUnPickClick = false;

    var table = null;
    var table_list = null;

    //데이터 셋팅
    var addPicker = function(orderTableData, orderTableIndex){
      var projectId = orderTableData.project_id;
      var orderId = orderTableData.order_id;

  		var url = '/projects/' + projectId+ '/addpicking/' + orderId;
  		var method = 'post';

  		var success = function(result) {
        if(table_list)
        {
          table_list.addRow(orderTableData);
        }

        if(table)
        {
          table.deleteRow(orderTableIndex);
        }
  		};
  		var error = function(request) {
  			swal("추첨 실패", "", "error");
  		};

  		$.ajax({
  			'url': url,
  			'method': method,
  			'success': success,
  			'error': error
  		});
    };

    var deletePicker = function(pickerTableData, pickerTableIndex){
      var projectId = pickerTableData.project_id;
      var orderId = pickerTableData.order_id;

  		var url = '/projects/' + projectId+ '/deletepicking/' + orderId;
  		var method = 'delete';

  		var success = function(result) {
        if(table)
        {
          table.addRow(pickerTableData);
        }

        if(table_list)
        {
          table_list.deleteRow(pickerTableIndex);
        }
  		};
  		var error = function(request) {
  			swal("추첨 빼기 실패", "", "error");
  		};

  		$.ajax({
  			'url': url,
  			'method': method,
  			'success': success,
  			'error': error
  		});
    };

    var getTableOutElement = function(data){

      var list = document.createElement("ul");
      list.className = "order_collapse_ul";

      for(var key in data)
      {
        if(data[key] === 0 || data[key] === '')
        {
          continue;
        }

        //console.error(data);
        if(key == '사연')
        {
          data[key] = getConverterEnterString(data[key]);
        }

        let item = document.createElement("li");
        //item.innerHTML = "<div class='flex_layer order_collapse_rows'>" + "<p><strong>" + key + "</strong></p>" + "<div class='order_collapse_value'>" + data[key] + "</div>" + "</div>";
        item.innerHTML = "<div class='order_collapse_rows'>" + "<p class='order_collapse_title'><strong>" + key + "</strong></p>" + "<div class='order_collapse_value'>" + data[key] + "</div>" + "</div>";
        list.appendChild(item);
      }

      return list;
    };

    table = new Tabulator(parentElement, {
        layout:"fitDataFill",
        responsiveLayout:"collapse",
        columns:columnsInfo,
        data:tableDataArray,
        responsiveLayoutCollapseStartOpen:false,

        dataEdited:function(data){
          //data - the updated table data
          //console.error("order count : "+ Object.keys(data).length);
        },

        rowClick:function(e, row){

          if(isPickClick)
          {
            addPicker(row.getData(), row.getIndex());
            //console.error(tableDataArray.length);
          }

          if(!isWorkedCollapse)
          {
            var collapseNode = row._row.element.children[0].children[0];
            $(collapseNode).trigger("click");
          }

          isWorkedCollapse = false;
          isPickClick = false;

        },
        cellClick:function(e, cell){
          if(cell._cell.column.field == 'pick')
          {
            isWorkedCollapse = true;
            isPickClick = true;
          }
        },
        responsiveLayoutCollapseFormatter:function(data){
          //console.error(data);

            var list = getTableOutElement(data);


            return Object.keys(data).length ? list : "";
        }
    });

    var setPickCounter = function(data){
      $("#pick_list_counter").text("추첨된 인원수 : " + Object.keys(data).length + "명");
      $("#pick_list_counter").attr('pick-count', Object.keys(data).length);
    };

    //pick list table
    table_list = new Tabulator(pickListparentElement, {
        layout:"fitDataFill",
        responsiveLayout:"collapse",
        columns:columnsPickInfo,
        data:tablePickDataArray,
        responsiveLayoutCollapseStartOpen:false,
        dataLoaded:function(data){
          //data - all data loaded into the table
          setPickCounter(data);
        },
        dataEdited:function(data){
          //data - the updated table data
          setPickCounter(data);
        },

        rowClick:function(e, row){
          if(isUnPickClick)
          {
            deletePicker(row.getData(), row.getIndex());
          }

          if(!isWorkedCollapsePick)
          {
            var collapseNode = row._row.element.children[0].children[0];
            $(collapseNode).trigger("click");
          }

          isWorkedCollapsePick = false;
          isUnPickClick = false;

        },
        cellClick:function(e, cell){
          if(cell._cell.column.field == 'unpick')
          {
            if(!g_isPickComplete)
            {
              isWorkedCollapsePick = true;
              isUnPickClick = true;
            }
          }
        },
        responsiveLayoutCollapseFormatter:function(data){

            var list = getTableOutElement(data);

            return Object.keys(data).length ? list : "";
        }
    });

    var sendSMSPickComplete = function(){
      showLoadingPopup("SMS 전송중..");
      var projectId = Number($("#pick_list_counter").attr('projectid'));

      var url = '/projects/' + projectId + '/pickingcomplete/sendsms';
      var method = 'post';

      var success = function(result) {
        stopLoadingPopup();
        if(result.state == "error")
        {
          swal(result.message, "", "error");
          return;
        }
        else
        {
          swal("추첨 완료 성공!", "", "success").then(function(){
            window.location.reload();
          });
        }
      };

      var error = function(request, status) {
        //console.error('request : ' + JSON.stringify(request) + ' status : ' + status);
        swal("SMS 전송 실패", "", "error");
      };

      $.ajax({
        'url': url,
        'method': method,
        'success': success,
        'error': error
      });
    }

    var sendEmailPickComplete = function(){
      showLoadingPopup("EMAIL 전송중..");
      var projectId = Number($("#pick_list_counter").attr('projectid'));

      var url = '/projects/' + projectId + '/pickingcomplete/sendmail';
      var method = 'post';

      var success = function(result) {
        stopLoadingPopup();
        if(result.state == "error")
        {
          swal(result.message, "", "error");
          return;
        }
        else
        {
          //console.error(JSON.stringify(result.message) + ' ' + result.test);
          sendSMSPickComplete();
        }
      };

      var error = function(request, status) {
        //console.error('request : ' + JSON.stringify(request) + ' status : ' + status);
        swal("이메일 전송 실패", "", "error");
      };

      $.ajax({
        'url': url,
        'method': method,
        'success': success,
        'error': error
      });
    }

    var pickCompletePopup = function(){
      var pickCounter = Number($("#pick_list_counter").attr('pick-count'));
      var projectId = Number($("#pick_list_counter").attr('projectid'));
      //alert(pickCounter);

      var elementPopup = document.createElement("div");
      elementPopup.innerHTML =
      "<div class=''>확정 하시면 더 이상 추첨이 불가능 합니다.<br> - 추첨된 인원수 : " + pickCounter + "명<br><br>"+
      "추첨 확정시,<br>1. 당첨 문자, 메일 발송<br>2. 미당첨 메일 발송<br> 이 진행 됩니다."

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
            showLoadingPopup('미당첨 취소 진행중..');
            var url = '/projects/' + projectId + '/pickingcomplete';
            var method = 'post';

            var success = function(result) {
              stopLoadingPopup();
              if(result.state == "error")
              {
                swal(result.message, "", "error");
                return;
              }
              else
              {
                sendEmailPickComplete();
              }
            };

            var error = function(request, status) {
              swal("추첨 완료 실패", "", "error");
            };

            $.ajax({
              'url': url,
              'method': method,
              'success': success,
              'error': error
            });
          }
          break;
        }
      });
    };

    $("#pick_submit").click(function(){
      pickCompletePopup();
    });

    window.addEventListener('resize', function(){
      if(table_list)
      {
        table_list.redraw();
      }

      if(table)
      {
        table.redraw();
      }
    });




    //임시코드 START
    /*
    var picking_y_old_json = $('#pickingYList').val();
    var picking_y_old_list = null;
    if(picking_y_old_json)
    {
      picking_y_old_list = $.parseJSON(picking_y_old_json);
    }
    */
    if($('#pickingYList'))
    {
      var tableNDataArray = new Array();
      var tableYDataArray = new Array();

      for(var i = 0 ; i < orders.length ; i++)
      {
        var order = orders[i];

        var orderObject = new Object();
        orderObject = order;

        orderObject.order_id = order.id;
        //orderObject.id = i + 1;

        if(order.is_pick == 'Y')
        {
          tableNDataArray.push(orderObject);
        }
        else
        {
          tableYDataArray.push(orderObject);
        }
      }

      var tableY = null;
      var tableN = null;

      var isPickY = false;
      var isPickN = false;


      var parentElementY = document.createElement("div");
      parentElementY.setAttribute('class', 'order_supervise_list');
      $('#orders_container_fire').append(parentElementY);

      var parentElementN = document.createElement("div");
      parentElementN.setAttribute('class', 'order_supervise_list');
      $('#orders_container_fire_N').append(parentElementN);

      var addPickY = function(orderTableData, orderTableIndex){
        var projectId = orderTableData.project_id;
        var orderId = orderTableData.order_id;

    		var url = '/projects/' + projectId+ '/addy/' + orderId;
    		var method = 'post';

    		var success = function(result) {

          if(tableN)
          {
            tableN.addRow(orderTableData);
          }

          if(tableY)
          {
            tableY.deleteRow(orderTableIndex);
          }

    		};
    		var error = function(request) {
    			swal("추첨 실패", "", "error");
    		};

    		$.ajax({
    			'url': url,
    			'method': method,
    			'success': success,
    			'error': error
    		});
      };

      var deletePickN = function(pickerTableData, pickerTableIndex){
        var projectId = pickerTableData.project_id;
        var orderId = pickerTableData.order_id;

    		var url = '/projects/' + projectId+ '/deletey/' + orderId;
    		var method = 'delete';

    		var success = function(result) {
          if(tableY)
          {
            tableY.addRow(pickerTableData);
          }

          if(tableN)
          {
            tableN.deleteRow(pickerTableIndex);
          }
    		};
    		var error = function(request) {
    			swal("추첨 빼기 실패", "", "error");
    		};

    		$.ajax({
    			'url': url,
    			'method': method,
    			'success': success,
    			'error': error
    		});
      };

      var IconY = function(cell, formatterParams, onRendered){ //plain text value
          return "<button class='pickButton'>Y</button>";
      };

      var IconN = function(cell, formatterParams, onRendered){ //plain text value
          return "<button class='pickButton'>N</button>";
      };

      var columnsYInfo = [
          {formatter:"responsiveCollapse", field:"plus", width:30, minWidth:30, align:"center", resizable:false, headerSort:false, cellClick:function(e, cell){
            //isWorkedCollapse = true;
          }},

          {title:"Y", field:"pickY", align:"center",formatter:IconY, width:103},
          //{title:"이름", field:"name", align:"center", width:103},
          //{title:"티켓매수", field:"count", align:"right", width:88, sorter:"number"},

          {title:"사연 앞부분", field:"order_story", align:"center", width:200},
          {title:"이메일", field:"email", align:"center", width:221},
          {title:"사연", field:"order_story", align:"center", width:600},
      ];

      var columnsNInfo = [
          {formatter:"responsiveCollapse", field:"plus", width:30, minWidth:30, align:"center", resizable:false, headerSort:false, cellClick:function(e, cell){
            //isWorkedCollapse = true;
          }},

          {title:"N", field:"pickN", align:"center",formatter:IconN, width:103},
          //{title:"이름", field:"name", align:"center", width:103},
          //{title:"티켓매수", field:"count", align:"right", width:88, sorter:"number"},
          {title:"사연 앞부분", field:"order_story", align:"center", width:200},
          {title:"이메일", field:"email", align:"center", width:221},
          {title:"사연", field:"order_story", align:"center", width:600},
      ];

      tableY = new Tabulator(parentElementY, {
          layout:"fitDataFill",
          responsiveLayout:"collapse",
          columns:columnsYInfo,
          data:tableYDataArray,
          responsiveLayoutCollapseStartOpen:false,

          dataEdited:function(data){

          },

          rowClick:function(e, row){

            if(isPickY)
            {
              addPickY(row.getData(), row.getIndex());
              //console.error(tableDataArray.length);
            }

            if(!isWorkedCollapse)
            {
              var collapseNode = row._row.element.children[0].children[0];
              $(collapseNode).trigger("click");
            }

            isWorkedCollapse = false;
            isPickY = false;

          },
          cellClick:function(e, cell){
            if(cell._cell.column.field == 'pickY')
            {
              isWorkedCollapse = true;
              isPickY = true;
            }
          },
          responsiveLayoutCollapseFormatter:function(data){
            //console.error(data);

              var list = getTableOutElement(data);


              return Object.keys(data).length ? list : "";
          }
      });

      tableN = new Tabulator(parentElementN, {
          layout:"fitDataFill",
          responsiveLayout:"collapse",
          columns:columnsNInfo,
          data:tableNDataArray,
          responsiveLayoutCollapseStartOpen:false,

          dataEdited:function(data){

          },

          rowClick:function(e, row){

            if(isPickN)
            {
              deletePickN(row.getData(), row.getIndex());
              //console.error(tableDataArray.length);
            }

            if(!isWorkedCollapse)
            {
              var collapseNode = row._row.element.children[0].children[0];
              $(collapseNode).trigger("click");
            }

            isWorkedCollapse = false;
            isPickN = false;

          },
          cellClick:function(e, cell){
            if(cell._cell.column.field == 'pickN')
            {
              isWorkedCollapse = true;
              isPickN = true;
            }
          },
          responsiveLayoutCollapseFormatter:function(data){
            //console.error(data);

              var list = getTableOutElement(data);


              return Object.keys(data).length ? list : "";
          }
      });
    }

    //임시코드 END
  });

</script>
@endsection
