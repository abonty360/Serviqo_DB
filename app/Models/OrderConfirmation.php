<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderConfirmation extends Model
{
    public $timestamps = false; // No created_at and updated_at in the table schema

    protected $fillable = [
        'service_order_id', 
        'confirmation_status', 
        'final_amount', 
        'confirmed_at', 
        'notes'
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }
}