<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //


    protected $fillable = [
    'category_id',
    'name',
    'slug',
    'description',
    'price',
    'stock_quantity',
    'image_path',
    'status',
    'discount_percent'
];
    public function getFinalPriceAttribute()
{
    return $this->price * (1 - $this->discount_percent / 100);
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
