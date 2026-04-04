<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $fillable = ['full_name', 'email', 'phone', 'address', 'city', 'rating', 'nid', 'service_area_id'];

    public function serviceArea()
    {
        return $this->belongsTo(ServiceArea::class);
    }
}