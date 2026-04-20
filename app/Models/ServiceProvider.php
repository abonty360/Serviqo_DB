<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $fillable = ['full_name', 'email', 'phone', 'address', 'city', 'rating', 'nid', 'service_area_id','region'];

    public function serviceArea()
    {
        return $this->belongsTo(ServiceArea::class);
    }

    public function offerings()
    {
        return $this->hasMany(ServiceProviderOffering::class, 'service_provider_id');
    }
}