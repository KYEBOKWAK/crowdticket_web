<script type="text/template" id="template_goods_list_item">
  @if($isForm == 'true')
  <div data-goods-id="<%= goods.id %>" class="goods-item project-form-goods-container-grid">
  @else
  <div data-goods-id="<%= goods.id %>" class="goods-item project-detail-goods-container-grid <% if(!goods.img_url){ %> project-detail-goods-container-grid-no-img <% } %>">
  @endif
    <!-- 1단 -->
      <% if(goods.img_url) { %>
      <img class="project-form-goods-img-wrapper" src="<%= goods.img_url %>"/>
      <% } %>
      <!-- 2단 -->
      <div class="project-form-goods-item-content">
        <h4><%= goods.title %></h4>
        <h3> <%= addComma(goods.price) %>원</h3>
        <p><%= goods.content %></p>
      </div>
      <!-- form일때 3단 -->
    @if($isForm == 'true')
      <div class="project-form-goods-item-btn-container">
        <button class="btn btn-primary modify-goods">수정</button>
        <button class="btn btn-primary delete-goods">삭제</button>
      </div>
    @endif
  </div>
</script>
