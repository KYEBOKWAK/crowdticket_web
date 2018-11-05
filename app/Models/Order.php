<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    // 10%
    const CANCELLATION_FEES_RATE = 0.1;

    protected $guarded = ['id', 'project_id', 'ticket_id', 'user_id', 'confirmed', 'created_at', 'updated_at', 'deleted_at'];
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

    public function canCancel()
    {
        if ($this->deleted_at) {
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

    public function getStateStringAttribute()
    {
        if (isset($this->deleted_at) && $this->deleted_at) {
            return '취소됨';
        }

        $project = $this->getProject();
        if ($project->isFundingType() && !$project->isFinished()) {
            return '결제예약';
        }
        return '결제완료';
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
    public function getGoodsTotalText()
    {
      //$goods = $this->project->goods;
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

    public function getTotalPriceWithoutCommission()
    {
      $totalPrice = $this->total_price;
      $commission = $this->count * 500;

      return $totalPrice - $commission;
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
