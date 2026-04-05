<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function getFinalPriceAttribute()
{
    return $this->price * (1 - $this->discount_percent / 100);
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
