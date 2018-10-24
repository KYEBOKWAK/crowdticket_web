<script type="text/template" id="template_ticket_seat">
  <div class="ticket_seat_item ticket_seat_wrapper">
    <button type="button" id="ticket_seat_btn<%=ticket.id%>" class="ticket_seat_btn <% if(isDetail == 'FALSE') { %> ticket_seat_btn_order <% } %>">
      <span class="ticket_time_text <% if(isDetail == 'FALSE') { %> ticket_time_text_order_category <% } %>"><%= ticketCategory %></span>
      <span class="ticket_time_text ticket_time_text_price <% if(isDetail == 'FALSE') { %> ticket_time_text_order_price <% } %>"><%= addComma(ticket.price) %> 원</span>
      <% if(amountTicketCount == 0){ %>
        <p style="margin: 0px;"> 매진 </p>
      <% }else{ %>
        <p style="margin: 0px;"> 구매 가능한 티켓 수량 <%= addComma(amountTicketCount) %> 매</p>
      <% } %>
    </button>
	</div>
</script>
