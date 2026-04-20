<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    protected $fillable = ['service_name', 'description', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}