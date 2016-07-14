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
        
        $project = $this->getProject();
        $dday = 0;
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
        return $dday - time() > 0;
    }

    public function hasCancellationFees()
    {
        $project = $this->getProject();
        if ($project->isSaleType()) {
            $ticket = $this->getTicket();
            if ($ticket->delivery_date) {
                $before = strtotime('-9 days', strtotime($ticket->delivery_date));
                return strtotime(date('Y-m-d', $before) . ' 00:00:00') - time() < 0;
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
