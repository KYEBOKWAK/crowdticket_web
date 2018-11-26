<?php namespace App\Models;

class Goods extends Model
{

    protected $table = 'goods';

    protected $fillable = ['limit_count', 'price', 'ticket_discount', 'img_cache', 'title', 'content', 'img_url'];

    protected static $typeRules = [
        'limit_count' => 'integer|min:0',
        'price' => 'integer|min:0',
        'ticket_discount' => 'integer|min:0',
        'img_cache' => 'integer|min:0',
        'title' => 'string|min:0',
        'content' => 'string|min:0',
        'img_url' => 'string|min:0'
        //'real_ticket_count' => 'integer|min:0',
      //  'reward' => 'string|min:1',
      //  'question' => 'string|max:100',
      //  'audiences_limit' => 'integer|min:0',
      //  'delivery_date' => 'date_format:Y-m-d H:i:s',
      //  'shipping_charge' => 'integer',
      //  'category' => 'string|min:0',
      //  'show_date' => 'date_format:Y-m-d H:i:s'
    ];

    protected $casts = [
        'limit_count' => 'integer',
        'price' => 'integer',
        'img_cache' => 'integer'
        //'audiences_count' => 'integer',
        //'real_ticket_count' => 'integer',
    ];

    /*
    protected static $creationRules = [
        'title' => 'required'
    ];
    */

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    //굿즈의 구매 수량
    public function getOrderGoodsCount()
    {
      $orders = $this->project->orders;

      $orderCount = 0;
      foreach($orders as $order)
      {
        $goodsOrders = json_decode($order->goods_meta, true);
        foreach($goodsOrders as $goodsOrder)
        {
          if($this->id == $goodsOrder['id'])
          {
            $orderCount += $goodsOrder['count'];
          }
        }
      }

      return $orderCount;
    }

    //굿즈 남은 수량
    public function getAmountGoodsCount()
    {
      $amountGoodsCount = $this->limit_count - $this->getOrderGoodsCount();

      if($amountGoodsCount < 0)
      {
        $amountGoodsCount = "굿즈 수량 오류";
      }

      if($this->isUnLimited())
      {
        //무한일때 수량 빈값
        $amountGoodsCount = '';
      }

      return $amountGoodsCount;
    }

    public function isUnLimited()
    {
      if($this->limit_count == 0)
      {
        return true;
      }

      return false;
    }
}
