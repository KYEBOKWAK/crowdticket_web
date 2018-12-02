<script type="text/template" id="template_discount">
  <div data-discount-id="<%= discount.id %>" class="discount ticket_mobile_align_right">
    <div class="flex_layer_most_mobile">
      <p class="text-primary ticket-delivery-date discount_input_wrapper"><%= discount.content %></p>
      <p class="text-primary ticket-delivery-date"><%= discount.percent_value %>%</p>
      <p class="text-primary ticket-delivery-date ticket_slash_wrapper">/</p>
      <p class="text-primary ticket-delivery-date"><%= discount.submit_check %></p>

      <a style="cursor:pointer" class="modify-discount"><img src="https://img.icons8.com/windows/50/333333/pencil.png" class="ticket_tickets_button_wrapper"/></a>
      <a style="cursor:pointer" class="delete-discount"><img src="https://img.icons8.com/windows/50/EF4D5D/trash.png" class="ticket_tickets_button_wrapper"/></a>

    </div>
	</div>
</script>
