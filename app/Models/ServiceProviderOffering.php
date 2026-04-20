<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderOffering extends Model
{
    protected $fillable = ['service_provider_id', 'sub_service_id', 'price_charged', 'rating'];

    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function subService()
    {
        return $this->belongsTo(SubService::class);
    }
}