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

        #pick_list_counter_pop{
          width: 100%;
          text-align: right;
          margin-top: 10px;
          margin-bottom: 5px;
          font-size: 13px;
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

        .swal-modal{
          /*background-image: url("https://data.whicdn.com/images/245762463/original.gif");*/
        }

        .order_pick_list_in_popup_wrapper{
          /*margin-top: 20px;*/
        }

        .slot-machine{
          border-left: 4px solid #EF4D5D;
        }

        #picking_btn{
          background-color: #EF4D5D;
          color: white;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/css/firecelebrations.css?version=1') }}">
    <link rel="stylesheet" href="{{ asset('/css/slotmachine.css?version=1') }}">
@endsection

@section('content')

    <?php
    $goodsList = $project->goods;

    //$testa = $test;
    //$testa = json_decode($testa, false);
    ?>
<input id="orderList" type="hidden" value="{{$orderList}}"/>
<input id="pickingOldList" type="hidden" value="{{$pickingOldList}}"/>
<input id="isPickComplete" type="hidden" value="{{$project->isPickedComplete()}}"/>
<input id="projectId_picking_random" type="hidden" value="{{$project->id}}"/>

    @include('helper.btn_admin', ['project' => $project])

    <div class="first-container container">
        <div class="row">
            <h2 class="text-center text-important">
              @if($project->isPickedComplete())
                랜덤 추첨 완료
              @else
                랜덤 추첨 하기
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

      <button id="pick_random" class="pickButton" style="width: 50%; margin-bottom: 10px;" type="button">랜덤 추첨 하기!</button>

      @if(!$project->isPickedComplete())
        <div id="orders_container">
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

    var resetOrders = function(reOrders){
      orders = reOrders;
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

        {title:"이름", field:"name", align:"center", width:103},
        //{title:"이름", field:"id", align:"center", width:103},
        {title:"티켓매수", field:"count", align:"right", width:88, sorter:"number"},
        {title:"이메일", field:"email", align:"center", width:310},
        //{title:"전화번호", field:"contact", align:"center", width:151},
        //{title:"사연", field:"order_story", align:"center", width:151},
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

        //{title:unpickTitle, field:"unpick", align:"center",formatter:unpickIcon, width:103},

        {title:"이름", field:"name", align:"center", width:103},
        //{title:"이름", field:"id", align:"center", width:103},
        {title:"티켓매수", field:"count", align:"right", width:88, sorter:"number"},
        {title:"이메일", field:"email", align:"center", width:310},
    ];

    var columnsPickRandPopInfo = [
        {title:unpickTitle, field:"unpick", align:"center",formatter:unpickIcon, width:103},

        {title:"이름", field:"name", align:"center", width:103},
        //{title:"이름", field:"id", align:"center", width:103},
        {title:"이메일", field:"email", align:"center", width:221},
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

      orderObject.name = replaceName(order.name);
      orderObject.email = replaceEmail(order.email);

      tableDataArray.push(orderObject);
    }

    for(var i = 0 ; i < picking_old_list.length ; i++)
    {
      var order = picking_old_list[i];

      var orderObject = new Object();
      orderObject = order;

      orderObject.order_id = order.id;

      orderObject.name = replaceName(order.name);
      orderObject.email = replaceEmail(order.email);

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
    var table_Rand_Pop_list = null;

    //데이터 셋팅
    var addPicker = function(orderTableData){
      if(table_Rand_Pop_list)
      {
        orderTableData.order_id = orderTableData.id;
        orderTableData.name = replaceName(orderTableData.name);
        orderTableData.email = replaceEmail(orderTableData.email);
        table_Rand_Pop_list.addRow(orderTableData);
      }
    };

    var deletePicker = function(pickerTableData, pickerTableIndex){
      var projectId = pickerTableData.project_id;
      var orderId = pickerTableData.order_id;

  		var url = '/projects/' + projectId+ '/deletepicking/' + orderId;
  		var method = 'delete';

  		var success = function(result) {
        if(table_Rand_Pop_list)
        {
          table_Rand_Pop_list.deleteRow(pickerTableIndex);
        }

        if(result.state == 'success')
        {
          resetOrders(result.orders);
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
    });

    var setPickCounter = function(data){
      $("#pick_list_counter").text("추첨된 인원수 : " + Object.keys(data).length + "명");
      $("#pick_list_counter").attr('pick-count', Object.keys(data).length);

      $("#pick_list_counter_pop").text("추첨된 인원수 : " + Object.keys(data).length + "명");
      $("#pick_list_counter_pop").attr('pick-count', Object.keys(data).length);
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
        }
    });

    var pickCompletePopup = function(){
      var pickCounter = Number($("#pick_list_counter").attr('pick-count'));
      var projectId = Number($("#projectId_picking_random").val());
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
            showLoadingPopup('');
            var url = '/projects/' + projectId + '/pickingcomplete';
            var method = 'get';

            var success = function(result) {
              stopLoadingPopup();
              if(result.state == "error")
              {
                swal(result.message, "", "error");
                return;
              }
              else
              {
                swal("추첨 성공!", "", "success").then(function(){
                  window.location.reload();
                });
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

    var isClosePickRandom = false;
    var isBoomFire = false;

    var getPickingRandList = function(){

      var pickRandomList = new Array();

      if(!orders)
      {
        return pickRandomList;
      }

      for(var i = 0 ; i < orders.length ; i++)
      {
        var order = orders[i];
        var orderObject = new Object();

        orderObject.id = order.id;
        orderObject.email = replaceEmail(order.email);

        pickRandomList.push(orderObject);
      }

      return pickRandomList;
    };

    var setPickingLoading = function(isPicking){
      if(isPicking == true)
      {
        $("#picking_btn").hide();
        $(".loadingtext").show();
      }
      else
      {
        $("#picking_btn").show();
        $(".loadingtext").hide();
      }

    };

    var initSlotMachine = function(){
      var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

      function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

      var SlotMachine = function () {
        function SlotMachine(data, completeCallback) {
          _classCallCheck(this, SlotMachine);

          this.data = data, this.height = data.length * 40;
          this.completeCallback = completeCallback;
          this.speed = 1;
          this.duration = 10000;
          this.reel;
          this.start;
          this.init();
        }

        _createClass(SlotMachine, [{
          key: 'init',
          value: function init() {
            this.reel = document.querySelector('.reel');
            this.reel.innerHTML = '\n      <span>' + this.data.map(function (_ref) {
              var email = _ref.email;
              return email;
            }).join('</span><span>') + '</span>\n      <span>' + this.data[0].email + '</span>\n    ';
          }
        }, {
          key: 'spin',
          value: function spin(winnerObj) {
            if (this.start !== undefined) return;

            var count = this.data.length;
            var winnerIdx = this.data.indexOf(winnerObj);
            var winner = winnerIdx !== -1 ? winnerIdx : 0;
            this.offset = winner * this.height / count;

            this.animate();
          }
        }, {
          key: 'animate',
          value: function animate(now) {
            if (!this.start) this.start = now;
            var t = now - this.start || 0;

            var offset = (this.speed / this.duration / 2 * (this.duration - t) * (this.duration - t) + this.offset) % this.height | 0;

            this.reel.style.transform = 'translateY(' + -offset + 'px)';

            if (t < this.duration) requestAnimationFrame(this.animate.bind(this));else {
              this.start = undefined;
              this.completeCallback();
            }
          }
        }]);

        return SlotMachine;
      }();


      var g_orderListdata = null;
      var pickData = null;
      var completeCallback = function completeCallback() {
        setPickingLoading(false);

        if(pickData)
        {
          addPicker(pickData);
        }
        //return console.error(JSON.stringify(winner));
      };

      var runSpin = function runSpin(order, orders) {
        g_orderListdata = getPickingRandList();
        if(g_orderListdata.length == 0)
        {
          alert("주문자 정보가 없습니다.");
          return;
        }

        //선택된 order idx 를 찾는다.
        var pickIdx = -1;
        for(var i = 0 ; i < g_orderListdata.length ; i++)
        {
          if(Number(g_orderListdata[i].id) == Number(order.id))
          {
            pickIdx = i;
            break;
          }
        }

        if(pickIdx < 0)
        {
          alert("이메일 매칭 에러. 새로고침해서 데이터 동기화를 해주세요.");
          return;
        }

        pickData = order;

        var winner = g_orderListdata[pickIdx];
        var sm = new SlotMachine(g_orderListdata, completeCallback);
        sm.spin(winner);

        resetOrders(orders);
      };

      var setOrderInfoRandomPopup = function(order, orders){
        runSpin(order, orders);
      };

      $('#picking_btn').click(function(){
        if(Number($('.pick_limite_count').val()) <= 0)
        {
          $('.pick_random_pop_state').text("최대값을 지정해야 추첨을 진행할 수 있습니다.");

          return;
        }

        var pickCount = Number($("#pick_list_counter_pop").attr('pick-count'));

        if(Number($('.pick_limite_count').val()) <= pickCount)
        {
          $('.pick_random_pop_state').text("뽑아야 할 횟수를 초과했습니다.");

          return;
        }

        $('.pick_random_pop_state').text("");

        setPickingLoading(true);

        //requestRandomPickup();
        //spin();

        var projectId = $('#projectId_picking_random').val();

        var url = '/projects/' + projectId+ '/pickingrequestrandom';
    		var method = 'get';

    		var success = function(result) {
          if(result.state == 'success')
          {
            setOrderInfoRandomPopup(result.order, result.orders);
          }
          else
          {
            setPickingLoading(false);
            alert(result.message);
          }
    		};
    		var error = function(request) {
          setPickingLoading(false);
    			//swal("추첨 실패", "", "error");
          alert("추첨 실패");
    		};

    		$.ajax({
    			'url': url,
    			'method': method,
    			'success': success,
    			'error': error
    		});

      });
      //var button = document.querySelector('button');
      //button.addEventListener('click', spin);
    };

    var setRandPickPopupTable = function(){
      table_Rand_Pop_list = null;

      var pickListPopupparentElement = document.createElement("div");
      pickListPopupparentElement.setAttribute('class', 'order_supervise_list');
      $('.order_pick_list_in_popup_wrapper').append(pickListPopupparentElement);

      table_Rand_Pop_list = new Tabulator(pickListPopupparentElement, {
          layout:"fitDataFill",
          responsiveLayout:"collapse",
          columns:columnsPickRandPopInfo,
          data:tablePickDataArray,
          pagination:"local",
          paginationSize:5,

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

            isUnPickClick = false;

          },
          cellClick:function(e, cell){
            if(cell._cell.column.field == 'unpick')
            {
              if(!g_isPickComplete)
              {
                isUnPickClick = true;
              }
            }
          }
      });
    };

    var pickingRandomLoadingPopup = function(){
      var elementPopup = document.createElement("div");
      elementPopup.innerHTML =
      "<div class='pick_limite_wrapper'>" + "최대 추첨 매수 : " +
        //"<input class='pick_limite_count' type='number'/> 한번에 추첨하기 <input class='pick_all_check' type='checkbox'/>" +
        "<input class='pick_limite_count' type='number'/>" +
        "<p class='pick_random_pop_state'></p>" +
      "</div>" +
      "<div class='slot-machine'>" +
        "<div class='slot'>" +
          "<div class='reel'>" +
            "<span>추첨 버튼을 눌러주세요!!</span>" +
          "</div>" +
        "</div>" +
        "<button id='picking_btn'>추첨하기</button>" +
        "<div class='loadingtext'>" +
          "<div class='l1'>추</div>" +
          "<div class='l2'>첨</div>" +
          "<div class='l3'>중</div>" +
          "<div class='l4'>.</div>" +
          "<div class='l5'>.</div>" +
          "<div class='l6'>.</div>" +
        "</div>" +
      "</div>" +
      "<p id='pick_list_counter_pop' pick-count='' projectid='{{$project->id}}'>추첨된 인원수 : 0명</p>" +
      "<div class='order_pick_list_in_popup_wrapper'></div>";

      swal({
          title: "랜덤 추첨기!",
          content: elementPopup,
          confirmButtonText: "V redu",
          allowOutsideClick: "true",
          closeOnClickOutside: false,
          closeOnEsc: false,

      }).then(function(value){
        $('.swal-modal').attr("style","background-image: ''");
        switch (value) {
          case "save":
          {
          }
          break;
        }

        window.location.reload();
      });

      $('.swal-modal').attr("style","background-image: url('https://data.whicdn.com/images/245762463/original.gif');");

      setRandPickPopupTable();
    };

    $("#pick_random").click(function(){
      pickingRandomLoadingPopup();
      initSlotMachine();
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
  });

</script>
@endsection
