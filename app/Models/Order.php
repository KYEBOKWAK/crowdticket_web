<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    // 10%
    const CANCELLATION_FEES_RATE = 0.1;

    const ORDER_STATE_STAY = 0; //결제 대기 상태
    const ORDER_STATE_PAY = 1;   //결제 혹은 결제대기
    const ORDER_STATE_PAY_NO_PAYMENT = 2;   //order 는 들어갔지만, 결제 프로세를 안탐
    const ORDER_STATE_PAY_SCHEDULE = 3;
    const ORDER_STATE_PAY_END = 99;
    //const ORDER_STATE_SCHEDULE_PAY = 2; //예약결제 //결제 상태는 하나로 통합. 프로젝트의 타입에 따라서 구분한다.

    const ORDER_STATE_CANCEL_START = 100; //취소사유는 100~200
    const ORDER_STATE_PROJECT_CANCEL = 102;   //프로젝트 중도 취소
    const ORDER_STATE_CANCEL = 199;//고객취소는 맨 마지막

    const ORDER_STATE_HOST_SHOW_ORDER_END = 200;

    const ORDER_STATE_ERROR_START = 500;
    const ORDER_STATE_ERROR_PAY = 501;
    const ORDER_STATE_ERROR_END = 600;

    protected $guarded = ['id', 'project_id', 'ticket_id', 'user_id','state', 'confirmed', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    protected static $creationRules = [
        'contact' => 'required|numeric'
    ];

    protected static $updateRules = [
        'contact' => 'numeric'
    ];

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function discount()
    {
      return $this->belongsTo('App\Models\Discount');
    }

    public function supporter()
    {
      return $this->belongsTo('App\Models\Supporter');
    }

    public function getAmountWithoutCommission()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->price * $this->count;
    }

    public function isErrorOrder()
    {
      if($this->getState() >= self::ORDER_STATE_ERROR_START)
      {
        return true;
      }

      return false;
    }

    public function canCancel()
    {
        //if ($this->deleted_at) {
        if ($this->getIsCancel()) {
            return false;
        }
//poster_url
        $project = $this->getProject();
        $dday = 0;

        if($project->isOldProject())
        {
          //예전 코드
          if ($project->isFundingType()) {
              if ($project->funding_closing_at) {
                  $dday = strtotime('-1 days', strtotime($project->funding_closing_at));
              }
          } else {
              $ticket = $this->getTicket();
              if ($ticket->delivery_date) {
                  $before = strtotime('-1 days', strtotime($ticket->delivery_date));
                  $dday = strtotime(date('Y-m-d', $before) . ' 23:59:59');
              }
          }
        }
        else
        {
          $refundDay = 0;
          if ($project->isFundingType())
          {
            if ($project->funding_closing_at) {
                $refundDay = $project->funding_closing_at;
            }
          }
          else
          {
            $ticket = $this->getTicket();
            if($ticket)
            {
              //티켓정보가 있다면, 공연 시작날 기준으로 환불
              $refundDay = $ticket->getTicketReFundDate($project);
            }
            else
            {
              $refundDay = $project->funding_closing_at;
            }
          }

          $dday = strtotime('-1 days', strtotime($refundDay));
        }

        return $dday - time() > 0;
    }

    public function hasCancellationFees()
    {
        $project = $this->getProject();
        if ($project->isSaleType()) {
            $ticket = $this->getTicket();
            if($ticket)
            {
              $refundDay = $ticket->getTicketReFundDate($project);
              if ($refundDay) {
                  $before = strtotime('-9 days', strtotime($refundDay));
                  return strtotime(date('Y-m-d', $before) . ' 00:00:00') - time() < 0;
              }
            }
        }
        return false;
    }

    public function getCancellationFees()
    {
        if ($this->hasCancellationFees()) {
            return (int) ($this->total_price * self::CANCELLATION_FEES_RATE);
        }
        return 0;
    }

    public function getRefundAmount()
    {
        return $this->total_price - $this->getCancellationFees();
    }

    public function getFundedAmount()
    {
        return $this->price * $this->count;
    }

    public function getDeliveryAddress()
    {
      if($this->isDeliveryOrder())
      {
        return $this->postcode."&ensp;".$this->address_main."&ensp;".$this->address_detail;
      }

      return "현장수령";
    }

    public function isDeliveryOrder()
    {
      if($this->postcode)
      {
        return true;
      }

      return false;
    }

    public function getDiscountText()
    {
      if($this->discount)
      {
        return $this->discount->content;
      }

      return "할인없음";
    }
/*
    public function getGoodsInfoList()
    {
      return $this->project->goods;
    }
*/
    public function getGoodsTotalTextInEmail()
    {
      $goodsList = $this->project->goods;
      if(count($goodsList) == 0)
      {
        return "굿즈 없음";
      }

      $goodsOrderText = "굿즈 선택 없음";

      $orderCount = 0;

      $goodsOrders = json_decode($this->goods_meta, true);
      if(count($goodsOrders) > 0)
      {
        $goodsOrderText = '';
      }

      foreach($goodsOrders as $goodsOrder)
      {
        foreach($goodsList as $goods)
        {
          if($goodsOrder['id'] == $goods->id)
          {
            $goodsOrderText = $goodsOrderText.$goods->title.' '.$goodsOrder['count'].'개, ';
          }
        }
      }


      return $goodsOrderText;
    }

    public function isBuyGoodsCount($goodsId)
    {
      $goodsOrders = json_decode($this->goods_meta, true);
      foreach($goodsOrders as $goodsOrder)
      {
        if($goodsId == $goodsOrder['id'])
        {
          return $goodsOrder['count'];
        }
      }
    }

    //실제 구매한 굿즈가 있는지
    public function getIsGoodsCount()
    {
      $goodsOrders = json_decode($this->goods_meta, true);
      return count($goodsOrders);
    }

    public function getTotalPriceWithoutCommission()
    {
      $totalPrice = $this->total_price;
      $commission = 0;
      if($totalPrice >= 500)
      {
        $commission = $this->count * 500;
      }

      return $totalPrice - $commission;
    }

    public function getCommission()
    {
      $totalPrice = $this->total_price;
      $commission = 0;
      if($totalPrice >= 500)
      {
        $commission = $this->count * 500;
      }

      return $commission;
    }

    public function setState($state)
    {
      $this->state = (int)$state;
    }

    public function getState()
    {
      return $this->state;
    }

    public function getStateStringAttribute()
    {
      if (isset($this->deleted_at) && $this->deleted_at) {
          return '취소됨';
      }

      if($this->getState() == self::ORDER_STATE_CANCEL)
      {
        return '취소됨';
      }
      else if($this->getState() == self::ORDER_STATE_PROJECT_CANCEL)
      {
        return '목표 도달 실패';
      }
      else if($this->getState() == self::ORDER_STATE_PAY_SCHEDULE)
      {
        return '결제예약';
      }
      else if($this->getState() == self::ORDER_STATE_ERROR_PAY)
      {
        return '결제 에러';
      }


      $project = $this->getProject();
      if ($project->isFundingType() && !$project->isFinished()) {
          return '결제예약';
      }

      return '결제완료';
      /*
        if (isset($this->deleted_at) && $this->deleted_at) {
            return '취소됨';
        }

        $project = $this->getProject();
        if ($project->isFundingType() && !$project->isFinished()) {
            return '결제예약';
        }
        return '결제완료';
        */
    }

    public function getIsCancel()
    {
      if ($this->deleted_at) {
        return true;
      }

      if(
        $this->state == self::ORDER_STATE_CANCEL ||
        $this->state == self::ORDER_STATE_PROJECT_CANCEL)
      {
        return true;
      }

      return false;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->requiredGet('project');
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->requiredGet('ticket');
    }

}
