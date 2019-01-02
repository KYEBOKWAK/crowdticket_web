@extends('app')

@section('css')
    <style>
      .attend_container{
        margin: 0 auto;
        width: 420px;
      }
      .attend_container_custom{
        border-left: 5px solid #ea535a;
        border-right: 1px solid black;
      }

      #container #input-form {text-align: center;}
      #user-table {margin: 0 auto; text-align: center;}
      #input-form {margin-top: 10px; margin-bottom: 10px;}

      #user-table {border-collapse: collapse;}
      #user-table > thead > tr { background-color: #333; color:#fff; }
      #user-table > thead > tr > th { padding: 8px; width: 150px; }
      #user-table > tbody > tr > td { border-bottom: 1px solid gray; padding:8px; }

      .attendButton{
        border: 1px solid #EF4D5D;
        width: 50%;
        background-color: white;

        box-shadow: 4px 4px 0 0 rgba(0, 0, 0, 0.16);
        border-radius: 10px;
      }

      .attend_popup_count{
        margin-left: auto;
      }

      .isAttendedButton{
        background-color: #EF4D5D;
        color: white;
      }

      .attend_popup_wrapper{
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
        background-color: #ffffff;
        text-align: left;
        padding: 10px;
        border-left: 5px solid #ea535a;
      }

      .attend_popup_title{
          font-size: 20px;
          font-weight: 900;
      }

      .attend_popup_content{
        font-size: 18px;
      }

      .attend_popup_dot_line{
        border-top: 1px solid #707070;
        height: 0px;
        margin-top: 5px;
        margin-bottom: 10px;
      }

      .attend_popup_goods_line{
        border-top: 1px solid #e7e7e7;
        height: 0px;
      }

      #keyword{
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
        border: solid 1px #707070;
      }

      .attend_ticket_category{
        margin-top: 10px;
        margin-bottom: 10px;
        margin-left: auto;

        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
        border: solid 1px #707070;
        background-color: white;
      }

      @media (max-width: 440px) {
        .attend_container{
          width: 100%;
        }
      }
    </style>
@endsection

@section('content')
<input id="tickets_json_category_info" type="hidden" value="{{ $categories_ticket }}"/>
<input id="projectid" type="hidden" value="{{ $project->id }}">

<div class="attend_container">
  <div class="flex_layer">
    <div id="input-form">
          이름/번호 : <input type="text" id="keyword" />
    </div>
    <select id="attend_ticket_category" name="attend_ticket_category" class="attend_ticket_category" project-id="{{$project->id}}">
        @foreach ($ticketTimeList as $ticketTime)
          <option value="{{ $ticketTime['show_date_unix'] }}" @if($selectShowUnixDateTicket === $ticketTime['show_date_unix']) selected @endif>{{ $ticketTime['show_date'] }}</option>
        @endforeach
    </select>
  </div>
</div>

  <div class="attend_container attend_container_custom">
      <table id="user-table" class="table">
          <thead>
          <tr>
              <td>id(test)</td>
              <td>이름</td>
              <td>전화번호</td>
              <td>출석체크</td>
          </tr>
          </thead>
          <tbody class="attend_list_tbody">
          </tbody>
      </table>
  </div>

@endsection

@section('js')
<script>
      $(document).ready(function() {

        var ticketsCategoryJson = $('#tickets_json_category_info').val();
      	var ticketsCategory = '';
      	if (ticketsCategoryJson) {
      		//alert(ticketsCategoryJson);
      		 ticketsCategory = $.parseJSON(ticketsCategoryJson);
      	}

          $("#keyword").keyup(function() {
              var k = $(this).val();
              $("#user-table > tbody > tr").hide();
              //var temp = $("#user-table > tbody > tr > td:nth-child(5n+1):contains('" + k + "')");
              var temp = $("#user-table > tbody > tr > td:nth-child(n):contains('" + k + "')");

              $(temp).parent().show();
          });

          var createAttendPopup = function(attendElement, goodsInfoList){
            if(attendElement.attr("attend-button-order-id"))
            {
              var projectId = attendElement.attr("project-id");
              var orderId = attendElement.attr("attend-button-order-id");
              var name = attendElement.attr("order-name");
              var email = attendElement.attr("order-email");
              var phone = attendElement.attr("order-phone");

              var isAttended = attendElement.attr("isattended");

              var ticketElement = "";
              var ticketShowDate = attendElement.attr("order-ticket-show-date");
              if(ticketShowDate)
              {
                var orderTicketCategory = attendElement.attr("order-ticket-category");
                var ticketCount = attendElement.attr("order-ticket-count");
                ticketShowDate = getTicketDateFullInfo(ticketShowDate, orderTicketCategory, ticketsCategory);

                ticketElement = "<div class='attend_popup_title'>티켓</div>"+
                                "<div class='flex_layer'><div class='attend_popup_content'>"+ticketShowDate+"</div><div class='attend_popup_count'>"+ticketCount+"매</div></div>"+
                                "<div class='attend_popup_dot_line'></div>";
              }

              var discountElement = "";
              var discountContent = attendElement.attr("order-discount");
              if(discountContent)
              {
                discountElement = "<div class='attend_popup_title'>할인내용</div>"+
                "<div class='attend_popup_content'>"+discountContent+"</div>"+
                "<div class='attend_popup_dot_line'></div>";
              }

              var goodsElement = "";
              if(goodsInfoList)
              {
                goodsInfoList = $.parseJSON(goodsInfoList);
                var goodsInfoElement = "";
                for(var i = 0 ; i < goodsInfoList.length ; i++)
                {
                  goodsInfoElement+="<div class='flex_layer'><div class='attend_popup_content'>"+goodsInfoList[i].info.title+"</div><div class='attend_popup_count'>"+goodsInfoList[i].count+"개"+"</div></div><div class='attend_popup_goods_line'></div>";
                }

                //alert(goodsInfoElement);

                goodsElement = "<div class='attend_popup_title'>굿즈</div>"+
                                goodsInfoElement+
                                "<div class='attend_popup_dot_line'></div>";
              }

              var elementPopup = document.createElement("div");
              elementPopup.innerHTML =
              "<div class='attend_popup_wrapper'>"+

              "<div class='attend_popup_title'>id(test)</div>"+
              "<div class='attend_popup_content'>"+orderId+"</div>"+
              "<div class='attend_popup_dot_line'></div>"+

              "<div class='attend_popup_title'>이름</div>"+
              "<div class='attend_popup_content'>"+name+"</div>"+
              "<div class='attend_popup_dot_line'></div>"+

              "<div class='attend_popup_title'>번호</div>"+
              "<div class='attend_popup_content'>"+phone+"</div>"+
              "<div class='attend_popup_dot_line'></div>"+

              ticketElement+

              discountElement+

              goodsElement+

              "</div>";

              var attendButtonText = "출석완료";
              if(isAttended)
              {
                attendButtonText = "출석 취소";
              }

              swal({
                  title: "출석체크",
                  content: elementPopup,
                  confirmButtonText: "V redu",
                  allowOutsideClick: "true",

                  buttons: {
    						    attend: {
    						      text: attendButtonText,
    						      value: "attend",
    						    },
    								close: {
    						      text: "닫기",
    						      value: "close",
    						    },
    						  },

              }).then(function(value){
  							switch (value) {
  						    case "attend":
  								{
                    var url = '/projects/' + projectId + '/order/' + orderId  + '/attended';
                    var method = 'put';

                    if(isAttended)
                    {
                      //이미 출석함
                      url = '/projects/' + projectId + '/order/' + orderId  + '/unattended';
                    }

                    var success = function(result) {
                      if(isAttended)
                      {
                        attendElement.text("출석 체크");
                        attendElement.removeClass('isAttendedButton');
                        attendElement.attr("isattended", "");
                      }
                      else
                      {
                        attendElement.text("출석 완료!");
                        attendElement.addClass('isAttendedButton');
                        attendElement.attr("isattended", "attended");
                      }

                      var attendedTitleText = "출석 완료!";
                      if(isAttended)
                      {
                        attendedTitleText = "출석 취소 완료!";
                      }

  										swal(attendedTitleText, {
  										  buttons: {
  										    save: {
  										      text: "확인",
  										      value: "save",
  										    },
  										  },

  											icon: "success",
  										}).then(function(){
                      });
  									};

  									var error = function(request, status) {
  										swal("출석 실패", "", "error");
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
            }
          };

          var createAttendPopupWithGoodsInfo = function(attendElement){

            var projectId = attendElement.attr("project-id");
            var orderId = attendElement.attr("attend-button-order-id");

            var url = '/projects/' + projectId + '/order/' + orderId  + '/getgoodsinfo';
            var method = 'get';

            var success = function(result) {
              createAttendPopup(attendElement, result);
            };

            var error = function(request, status) {
              swal("굿즈 정보 가져오기 실패", "", "error");
            };

            $.ajax({
              'url': url,
              'method': method,
              'success': success,
              'error': error
            });
          };

          var setClickAttendButton = function(){
            $('.attendButton').click(function(){
              //var name = $(this).attr("order-discount");
              var attendElement = $(this);

              var goodsListJson = attendElement.attr("order-goods");
              var goodsList = $.parseJSON(goodsListJson);
              if(goodsList.length > 0)
              {
                createAttendPopupWithGoodsInfo(attendElement);
              }
              else
              {
                createAttendPopup(attendElement, "");
              }
            });
          };

          var setAttendList = function(attendOrders){
            var projectId = $("#projectid").val();

            var attendListtBody = $('.attend_list_tbody');

            attendListtBody.children().remove();

            for(var i = 0 ; i < attendOrders.length ; ++i)
            {
              var order = attendOrders[i];

              var attendButtonElement =
              "<button class='attendButton' attend-button-order-id='"+order.id+"'>"+
              "</button>";


              var elementPopup = document.createElement("tr");
              elementPopup.innerHTML =
              "<td>"+order.id+"</td>" +
              "<td>"+order.name+"</td>" +
              "<td>"+order.contact+"</td>" +
              "<td>"+ attendButtonElement +"</td>";

              attendListtBody.append(elementPopup);

              //버튼 attr 셋팅

              var attendButton = $("[attend-button-order-id="+order.id+"]");

              attendButton.text("출석 체크");
              if(order.attended)
              {
                attendButton.addClass("isAttendedButton");
                attendButton.attr("isattended", order.attended);

                attendButton.text("출석 완료!");
              }

              attendButton.attr("project-id", projectId);

              attendButton.attr("order-name", order.name);
              attendButton.attr("order-email", order.email);
              attendButton.attr("order-phone", order.contact);
              attendButton.attr("order-suppoert", order.suppoert);
              attendButton.attr("order-discount", order.discount);
              if(order.ticket)
              {
                attendButton.attr("order-ticket-show-date", order.ticket.show_date);
                attendButton.attr("order-ticket-category", order.ticket.category);
              }

              attendButton.attr("order-ticket-count", order.count);
              attendButton.attr("order-goods", order.goods_meta);
            }

            setClickAttendButton();
          };

          var getAttendList = function(ticketShowDateUnix)
          {
            var ticketTime = ticketShowDateUnix;
            var projectId = $("#projectid").val();
            var url = '/projects/' + projectId + '/attend/' + ticketTime;
            var method = 'get';

            var success = function(result) {
              setAttendList(result);
            };

            var error = function(request, status) {
              swal("조회 실패", "", "error");
            };

            $.ajax({
              'url': url,
              'method': method,
              'success': success,
              'error': error
            });
          }

          $('#attend_ticket_category').change(function(){
            getAttendList($(this).val());
          });

          $('#attend_ticket_category').ready(function(){
            var ticketTimeUnix = $('#attend_ticket_category').val();
            if(ticketTimeUnix)
            {
              getAttendList(ticketTimeUnix);
            }
          });
        })
</script>
@endsection
