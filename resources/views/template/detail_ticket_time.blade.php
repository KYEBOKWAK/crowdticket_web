<script type="text/template" id="template_ticket_time">
  <div id="ticketTime" class="ticket_time_item ticket_time_wrapper">
    <button type="button" id="ticket_time_btn<%=hour%>_<%=min%>" class="ticket_time_btn <% if(isDetail == 'FALSE') { %> ticket_time_btn_order <% } %>">
      <span class="ticket_time_text <% if(isDetail == 'FALSE') { %> ticket_time_text_order <% } %>"><%= time %></span>
    </button>
	</div>
</script>
