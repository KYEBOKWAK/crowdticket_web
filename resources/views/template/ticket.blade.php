<script type="text/template" id="template_ticket">
  <div data-ticket-id="<%= ticket.id %>" class="ticket project-form-ticket-list-container-grid">
      <%
  					var rawDate = ticket.show_date.split(" ");
  					var d = rawDate[0].split("-");
  					var t = rawDate[1].split(":");
  					var date = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
  					var yyyy = date.getFullYear();
      			var mm = date.getMonth() + 1;
  					var dd = date.getDate();
      			var H = date.getHours();
      			var min = date.getMinutes();
            if(mm < 10){
              mm = "0" + mm;
            }
            if(dd < 10){
              dd = "0" + dd;
            }
            if(H < 10){
              H = "0" + H;
            }
      			if (min < 10) {
      				min = "0" + min;
      			}
            var week = ['일', '월', '화', '수', '목', '금', '토'];
            var dayOfWeek = week[date.getDay()];

    				var formatted = yyyy + "년 " + mm + "월 " + dd + "일("+dayOfWeek+") " + H + ":" + min;

            if(d[0] == 0000)
            {
              formatted = "장소/시간 미정";
            }

				%>
    <p class="text-primary ticket-delivery-date"><%= formatted %> | </p>
    <p class="text-primary ticket-delivery-date"><%= addComma(ticket.price) %> 원</p>
    <p class="text-primary ticket-delivery-date"><%= addComma(ticket.audiences_limit) %> 매</p>
    <p class="text-primary ticket-delivery-date"><%= ticketCategory %></p>
    <button class="btn btn-primary modify-ticket">수정</button>
    <button class="btn btn-primary delete-ticket">삭제</button>
	</div>

  <!-- <h5 class="ticket"><img src="ticket.png">2018.09.12 6PM <span>20,000</span>원 남은좌석 <span style="color:#EF4D5D;">41</span>개<button class="ticket-btn">티켓구매</button></h5> -->

</script>
