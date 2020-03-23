<div class="ticket_goods_item order_ticket_goods_item_container">
  <div id="goodsItem" class="order_ticket_goods_item_info_wrapper">
    <div class="flex_layer">
      @if($goods->img_url)
      <div class="order_ticket_goods_img_wrapper">
        <img class="order_ticket_goods_img_wrapper" src="{{ $goods->img_url }}">
      </div>
      @endif
      <div class="order_ticket_goods_info_container">
        <div class="order_ticket_goods_info">
          <p><span class="order_ticket_goods_info_title">{{ $goods->title }}</span> <span class="order_ticket_goods_info_price">{{ $goods->price }}원</span></p>
          @if( $goods->ticket_discount > 0 )
            <p class="order_ticket_goods_content">티켓 {{ $goods->ticket_discount }}원 추가 할인</p>
          @endif
        </div>
      </div>
    </div>
    <div class="order_ticket_goods_counter_container">
      <div class="flex_layer">
        <p class="goods_amount_text order_ticket_discount_limite_text">
          @if($goods->getAmountGoodsCount())
            남은수량 {{ $goods->getAmountGoodsCount() }} 개
          @endif
        </p>
        <button class="goods_count_up" goods-id="{{ $goods->id }}" goods-amount="{{ $goods->getAmountGoodsCount() }}" goods-buy-limit="{{$goods->buy_limit}}" type="button"></button>
        <button class="goods_count_down" goods-id="{{ $goods->id }}" goods-amount="{{ $goods->getAmountGoodsCount() }}" type="button"></button>
        <span class="goods_count_text goods_count_text{{ $goods->id }}">0개</span>
        <input id="goods_count_input{{ $goods->id }}" type="hidden" goods-id="{{ $goods->id }}" goods-price="{{ $goods->price }}" goods-ticket-discount-price="{{ $goods->ticket_discount }}" name="goods_count{{ $goods->id }}" type="number" class="ticket_goods_count_input form-control"
                                                       value="0" min="0"/>
     </div>
    </div>
  </div>
</div>
