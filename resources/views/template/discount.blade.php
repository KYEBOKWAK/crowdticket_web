<script type="text/template" id="template_discount">
  <div data-discount-id="<%= discount.id %>" class="discount project-form-discount-list-container-grid">
    <p class="text-primary ticket-delivery-date"><%= discount.content %></p>
    <p class="text-primary ticket-delivery-date">할인률 <%= discount.percent_value %> %</p>
    <p class="text-primary ticket-delivery-date"><%= discount.submit_check %></p>
    <p class="text-primary ticket-delivery-date"><%= addComma(discount.limite_count) %> 매 제한</p>
    <button class="btn btn-primary modify-discount">수정</button>
    <button class="btn btn-primary delete-discount">삭제</button>
	</div>
</script>
