<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $fillable = [
        'customer_id', 
        'status', 
        'total_amount', 
        'payment_status', 
        'order_datetime', 
        'scheduled_datetime'
    ];

    protected $casts = [
        'order_datetime' => 'datetime',
        'scheduled_datetime' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s'); // Avoid UTC (Z) append so the frontend doesn't shift the timezone automatically!
    }
}