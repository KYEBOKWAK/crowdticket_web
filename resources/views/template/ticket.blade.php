<script type="text/template" id="template_ticket">
  <div data-ticket-id="<%= ticket.id %>" class="ticket">
    <div class="flex_layer">
      <img src="{{ asset('/img/app/ticket.png') }}" class="project_form_ticket_image"/>
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
                formatted = "시간 미정";
              }

  				%>
      <p class="text-primary ticket-delivery-date ticket_date_wrapper"><%= formatted %></p>


      <p class="text-primary ticket-delivery-date ticket_slash_wrapper">/</p>
      <p class="text-primary ticket-delivery-date ticket_limit_wrapper"><%= addComma(ticket.audiences_limit) %> 매</p>
      <p class="text-primary ticket-delivery-date ticket_slash_wrapper">/</p>
      <p class="text-primary ticket-delivery-date ticket_price_wrapper"><%= addComma(ticket.price) %> 원</p>
      <p class="text-primary ticket-delivery-date ticket_slash_wrapper">/</p>
      <p class="text-primary ticket-delivery-date ticket_category_wrapper"><%= ticketCategory %></p>

      <a style="cursor:pointer" class="modify-ticket"><img src="https://img.icons8.com/windows/50/333333/pencil.png" class="ticket_tickets_button_wrapper"/></a>
      <a style="cursor:pointer" class="delete-ticket"><img src="https://img.icons8.com/windows/50/EF4D5D/trash.png" class="ticket_tickets_button_wrapper"/></a>
      </div>
	</div>

</script>
