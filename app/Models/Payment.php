<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'service_order_id',
        'payment_method',
        'payable_amount',
        'payment_datetime',
        'transaction_reference'
    ];
    protected $casts = [
        'payment_datetime' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }
}