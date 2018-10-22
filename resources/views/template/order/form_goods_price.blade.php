<script type="text/template" id="template_order_goods_price_list_item">
  <div class="order_md_container">
    <div class="goods_price">
      <%= goodsTotalPrice %>원
    </div>

    <div class="goods_ticket_discount <% if (isTicketDiscount === 'false') { %> order_md_ticket_no_discount <% } %>">
      - <%= goodsTotalDiscount %>원
    </div>
  </div>
</script>
