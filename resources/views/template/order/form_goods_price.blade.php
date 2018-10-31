<script type="text/template" id="template_order_goods_price_list_item">
  <% if(isLast) { %>
    <div class="flex_layer order_form_text" style="border-bottom: 0px; margin-bottom: 0px;">
  <% } else { %>
    <div class="flex_layer order_form_text" style="border-bottom: 0.5px solid #707070; margin-bottom: 10px;">
  <% } %>

    <div class="order_md_container">
      <div class="order_md_content">
        <%= goods.content %>
      </div>
      <div class="<% if (isTicketDiscount === 'false') { %> order_md_ticket_no_discount <% } %>">
        티켓 추가 할인
      </div>
    </div>
    <div class="order_md_container" style="margin-left: auto;">
      <div class="goods_price" style="text-align: right">
        <%= addComma(goodsPrice) %> x <%= goodsCount %>개 : <%= addComma(goodsTotalPrice) %>원
      </div>

      <div class="goods_ticket_discount <% if (isTicketDiscount === 'false') { %> order_md_ticket_no_discount <% } %>" style="text-align: right">
        - <%= goodsTotalDiscount %>원
      </div>
    </div>
  </div>

  <input type="hidden" name="goods_count<%= goods.id %>" value="<%= goodsCount %>"/>
</script>
