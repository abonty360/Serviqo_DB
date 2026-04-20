<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'service_order_id', 
        'service_provider_offering_id', 
        'quantity', 
        'item_price', 
        'item_status'
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function offering()
    {
        return $this->belongsTo(ServiceProviderOffering::class, 'service_provider_offering_id');
    }
}