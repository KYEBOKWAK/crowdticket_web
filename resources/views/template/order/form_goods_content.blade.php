<script type="text/template" id="template_order_goods_content_list_item">
  <div class="order_md_container" style="border-bottom: 0px; margin-bottom: 5px;">
    <div class="order_md_content">
      <%= goods.content %>
    </div>
    <div class="<% if (isTicketDiscount === 'false') { %> order_md_ticket_no_discount <% } %>">
      티켓 추가 할인
    </div>
  </div>

  <input type="hidden" name="goods_count<%= goods.id %>" value="<%= goodsCount %>"/>
</script>
