<script type="text/template" id="template_goods_list_item">

  <div data-goods-id="<%= goods.id %>" class="goods-item">
    <div class="project_form_goods_container">
      <div class="flex_layer_column">
        <!-- 1단 -->
        <% if(goods.img_url) { %>
        <img class="project-form-goods-img-wrapper" src="<%= goods.img_url %>"/>
        <% } %>
        <!-- 2단 -->
        <div class="project-form-goods-item-content">
          <h4><%= goods.title %></h4>
          <h3> <%= addComma(goods.price) %>원</h3>
          <p><%= goods.content %></p>

          <% if(goods.ticket_discount > 0) { %>
            <p style="text-align: right; font-weight: bold; margin-top:10px;"> 티켓 <%= addComma(goods.ticket_discount) %>원 추가 할인</p>
          <% } %>
        </div>
        <!-- form일때 3단 -->
        @if($isForm == 'true')
          <div class="project-form-goods-item-btn-container">
            <a style="cursor:pointer" class="modify-goods"><img src="https://img.icons8.com/windows/50/333333/pencil.png" class="ticket_tickets_button_wrapper"/></a>
            <a style="cursor:pointer" class="delete-goods"><img src="https://img.icons8.com/windows/50/EF4D5D/trash.png" class="ticket_tickets_button_wrapper"/></a>
          </div>
        @endif
      </div>
    </div>
  </div>
</script>
