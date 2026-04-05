<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $fillable = [
        'fname',
        'lname',
        'dob',
        'email',
        'phone',
        'password',
        'address',
        'city',
        'region',
        'preferred_payment_method',
        'role'
    ];

    protected $hidden = [
        'password'
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function serviceOrders()
    {
        return $this->hasMany('App\Models\ServiceOrder', 'customer_id')->orderBy('created_at', 'desc')->orderBy('scheduled_datetime', 'desc');
    }
      public function reviews()
    {
        return $this->hasMany(\App\Models\RatingsReview::class, 'customer_id');
    }
}
