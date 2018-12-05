<div id="discountItem" class="ticket_time_item order_ticket_discount_item_wrapper">
  <button type="button" discount-id="{{ $discount->id }}" discount-amount="{{ $project->getAmountDiscount($discount->id) }}" discount-value="{{ $discount->percent_value }}" id="ticket_time_btn" class="order_ticket_discount_item_btn">
    <div class="flex_layer">
      <div class="order_ticket_discount_title_text">
        {{ $discount->content }}
      </div>
      <div class="order_ticket_discount_content_wrapper">
        <p class="order_ticket_discount_percent_text"> 할인율:{{ $discount->percent_value }}%</p>
        <p class="order_ticket_discount_submit_text" >{{ $discount->submit_check }}</p>
      </div>
    </div>
  </button>
</div>
