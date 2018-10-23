<?php namespace App\Models;

use App\Exceptions\InvalidTicketStateException;

class Ticket extends Model
{
    protected $fillable = [
        'price', 'real_ticket_count', 'reward',
        'require_shipping', 'audiences_limit',
        'delivery_date', 'shipping_charge',
        'question', 'category', 'show_date'
    ];

    protected static $typeRules = [
        'price' => 'integer|min:0',
        'real_ticket_count' => 'integer|min:0',
        'reward' => 'string|min:1',
        'question' => 'string|max:100',
        'audiences_limit' => 'integer|min:0',
        'delivery_date' => 'date_format:Y-m-d H:i:s',
        'shipping_charge' => 'integer',
        'category' => 'string|min:0',
        'show_date' => 'date_format:Y-m-d H:i:s'
    ];

    protected static $creationRules = [
        'price' => 'required',
        'audiences_limit' => 'required',
    ];
/*
    protected static $creationRules = [
        'price' => 'required',
        'real_ticket_count' => 'required',
        'reward' => 'required',
        'require_shipping' => 'required',
        'audiences_limit' => 'required',
        'delivery_date' => 'required'
    ];
*/
    protected $casts = [
        'audiences_limit' => 'integer',
        'audiences_count' => 'integer',
        'real_ticket_count' => 'integer',
    ];

    public function update(array $attributes = array())
    {
        if ((int)$this->audiences_count === 0) {
            parent::update($attributes);
        } else {
            return new InvalidTicketStateException;
        }
    }

    public function delete()
    {
        if ((int)$this->audiences_count === 0) {
            parent::delete();
        } else {
            return new InvalidTicketStateException;
        }
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function getTicketLimitCount()
    {
      return $this->audiences_limit;
    }

    public function validateOrder($price, $count)
    {
      /*
        if (!$this->project()->first()->canOrder()) {
            throw new InvalidTicketStateException("Project is not valid state.");
        }
        if ($price < $this->price) {
            throw new InvalidTicketStateException("Order Price must greater than ticket's price.");
        }
        if ($count < 1) {
            throw new InvalidTicketStateException("Order count must greater than 1.");
        }
        $limit = $this->audiences_limit;
        if ($limit > 0) {
            $remain = $limit - $this->audiences_count;
            if ($count > $remain) {
                throw new InvalidTicketStateException("No available tickets.");
            }
        }
        */
    }
}
