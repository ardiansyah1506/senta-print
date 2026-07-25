<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function category() { return $this->belongsTo(Category::class)->withTrashed(); }
    public function prices() { return $this->hasMany(ProductPrice::class); }
    public function images(){ return $this->hasMany(ProductImage::class);}
    public function orderItems() { return $this->hasMany(OrderItem::class, 'product_id'); }
}
