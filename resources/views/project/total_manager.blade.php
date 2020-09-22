@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/lib/table/tabulator.min.css?version=1') }}">
<link rel="stylesheet" href="{{ asset('/css/lib/table/tabulator_bootstrap4.min.css?version=1') }}">
    <style>
        
    </style>
@endsection

@section('content')

<div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
      
      <p>조회가 안될경우 주문자에게 [우측 상단 결제확인 -> 구매 영수증] 영수증 요청 후 주문번호로 조회하시면 됩니다.</p>
      <p>문제 발생할 경우 크티 문의 주세요. 070-8819-4308</p>
      <p>
        <div class="form-group">
            <label>이름</label>
            <input id='form_name' class="form-control">
        </div>
      </p>

      <p>
        <div class="form-group">
            <label>전화번호 뒤 네자리</label>
            <input id='form_phone_number' class="form-control">
        </div>
      </p>

      <div class="flex_layer" style="align-items: center;">
        <button type="button" id="button_user_join_out_name_data" class="btn btn-default btn-outline" style="padding: 3px 10px; margin-right: 10px">조회</button>
      </div>

      <p>
        <div class="form-group">
            <label>주문번호</label>
            <input id='form_merchant_uid' class="form-control">
        </div>
      </p>

      <div class="flex_layer" style="align-items: center;">
        <button type="button" id="button_order_merchant_uid_data" class="btn btn-default btn-outline" style="padding: 3px 10px; margin-right: 10px">주문번호로 조회</button>
      </div>
      
      <div style="margin-top: 20px;">
        <div id="table"></div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js')

<script type="text/javascript" src="{{ asset('/js/lib/table/tabulator.min.js') }}"></script>

<script>
  $(document).ready(function () {

    function stopLoading(){
      loadingProcessStopWithSize($('#button_user_join_out_name_data'));
      loadingProcessStopWithSize($('#button_order_merchant_uid_data'));
    }

    function getUserData(){
      const name = $('#form_name').val();
      const phoneNumber = $('#form_phone_number').val();
      const merchant_uid = $("#form_merchant_uid").val();

      var url="/orders/super/find";
      var method = 'post';
      var data =
      {
        name: name,
        phoneNumber: phoneNumber,
        merchant_uid: merchant_uid
      }
      var success = function(res) {
        stopLoading();
        
        if(res.state === 'success'){

          // $('.order_tickets_label').text('완료');
          // initTable(request.data_tickets, request.data_goods);

          if(res.orders.length === 0){
            alert('주문자 정보가 없습니다!');
            return;
          }

          table.clearData();
        
          for(var i = 0 ; i < res.orders.length ; i++){
            var order = res.orders[i];
            table.addRow(order);
          }

        }else{
          alert(res.message);
        }
      };
      
      var error = function(request) {
        stopLoading();
        // console.error('error');
        alert('error');
      };
      
      $.ajax({
      'url': url,
      'method': method,
      'data' : data,
      'success': success,
      'error': error
      });
    };

    function findUser() {
      loadingProcessWithSize($("#button_user_join_out_name_data"), 20, 20);

      const name = $('#form_name').val();
      const phoneNumber = $('#form_phone_number').val();

      if(name === ''){
        alert("이름을 입력해주세요. 이름과 전화번호로 조회가 가능합니다.");
        return;
      }else if(phoneNumber === ''){
        alert("전화번호 뒷자리 4자리를 입력해주세요. 이름과 전화번호로 조회가 가능합니다.");
        return;
      }

      $("#form_merchant_uid").val('');

      getUserData();
    }

    function findMerchant_uid(){
      loadingProcessWithSize($("#button_order_merchant_uid_data"), 20, 20);
      
      const merchant_uid = $("#form_merchant_uid").val();
      if(merchant_uid === ''){
        alert("주문번호를 입력해주세요");
        return;
      }

      $('#form_name').val('');
      $('#form_phone_number').val('');

      getUserData();
    }

    $("#form_name").keyup(function(){
      if (window.event.keyCode == 13) {
        $("#form_phone_number").focus();
      }
    })

    $("#form_phone_number").keyup(function(){
      if (window.event.keyCode == 13) {
        findUser();
      }
    })

    $("#form_merchant_uid").keyup(function(){
      if (window.event.keyCode == 13) {
        findMerchant_uid();
      }
    })

    $("#button_user_join_out_name_data").click(function(){
      findUser();
      // loadingProcessWithSize($("#button_user_join_out_name_data"), 20, 20);
    })

    $("#button_order_merchant_uid_data").click(function(){
      findMerchant_uid();
      // loadingProcessWithSize($("#button_order_merchant_uid_data"), 20, 20);
    })

    var attendButtonFormat = function(cell, formatterParams){
      var rowData = cell.getData();
      return "<button type='button' class='btn btn-primary btn-outline' style='width:100%'>"+rowData.attendedText+"</button>";
    };

    var showUserInfoPopup = function(e, cell){
      var rowData = cell.getData();
      
      var titleWord = "티켓을 발급하시겠습니까?";
      var buttonWord = "발급";
      if(rowData.attended === "ATTENDED"){
        titleWord = "티켓 발급을 취소하시겠습니까?";
        buttonWord = "발급취소";
      }
      var elementPopup = document.createElement("div");
      elementPopup.innerHTML =
      "<h3>"+ titleWord +"</h3>" +
      "<p>" + "유저 정보" + "</p>" +
      "<p> ID : "+ rowData.id +"</p>" +
      "<p> 이름 : "+ rowData.name +"</p>" +
      "<p> 매수 : "+ rowData.count +"</p>" +
      "<p> 전화번호 :"+ rowData.contact +"</p>";

      swal({
        content: elementPopup,
        buttons: {
          cancel: "닫기",
          catch: {
            text: buttonWord,
            value: "change",
          },
        },
        icon: "warning",
      })
      .then(function(value){
        switch (value) {
          case "change":
          {
            // requestOutUser(cell);
            requestAttend(cell.getData());
          }
          break;
        }
      });
    };

    function requestAttend(data){
      // const name = $('#form_name').val();
      // const phoneNumber = $('#form_phone_number').val();

      var isAttended = false;
      const projectId = data.project.id;
      const orderId = data.id

      if(data.attended === "ATTENDED"){
        isAttended = true;
      }

      var url = '/projects/' + projectId + '/order/' + orderId  + '/attended';
      var method = 'put';

      if(isAttended)
      {
        //이미 출석함
        url = '/projects/' + projectId + '/order/' + orderId  + '/unattended';
      }

      var success = function(res) {
        getUserData();
        alert("변경완료");
      };
      
      var error = function(request) {
        alert('error');
      };
      
      $.ajax({
      'url': url,
      'method': method,
      'success': success,
      'error': error
      });
    }

    //참여한 이벤트 title
    //이름, 전화번호, 주문번호, 구매 매수, 상태 -> 발급완료 (변경 가능쓰)
    var tableColumns =
    [
      {title:"발급변경", field:"projectDetail", width: 102, align:"center", sorter:"string", formatter: attendButtonFormat, cellClick: showUserInfoPopup},
      // {title:"이메일", field:"email", width:250, align:"center", sorter:"string", headerFilter:"input"},
      {title:"주문번호", field:"merchant_uid", align:"center", sorter:"string", headerFilter:"input"},
      {title:"참여한 이벤트", field:"title", align:"center", sorter:"string", headerFilter:"input"},
      {title:"이름", field:"name", align:"center", sorter:"string", headerFilter:"input"},
      {title:"전화번호", field:"contact", align:"center", sorter:"string", headerFilter:"input"},
      {title:"구매매수", field:"count", align:"center", sorter:"string", headerFilter:"input"},
      {title:"상태", field:"state", align:"center", sorter:"string", headerFilter:"input"},

      {title:"발급 상태", field:"attendedText", align:"center", sorter:"string", headerFilter:"input"},
      {title:"ID", field:"id", align:"center", sorter:"string", headerFilter:"input"},
      // {title:"닉네임", field:"nick_name", align:"center", sorter:"string"},
      // {title:"페이스북ID", field:"facebook_id", align:"center", sorter:"string", headerFilter:"input"},
      // {title:"구글ID", field:"google_id", align:"center", sorter:"string", headerFilter:"input"},
      
    ];

    var table = new Tabulator("#table", {
        // height:"500px",
        //layout:"fitColumns",
        layout:"fitDataFill",
        //ajaxURL:"/project/list/" + $("#project_get_type").val(),
        //ajaxProgressiveLoad:"scroll",
        //paginationSize:10,
        placeholder:"No Data Set",
        columns:tableColumns,
    });

  });

</script>
@endsection
