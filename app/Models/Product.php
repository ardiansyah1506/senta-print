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
    public function prices() { return $this->hasMany(ProductPrice::class)->orderBy('min_qty', 'asc'); }
    public function images(){ return $this->hasMany(ProductImage::class);}
    public function orderItems() { return $this->hasMany(OrderItem::class, 'product_id'); }

    /**
     * Get unit price for a given quantity based on tiered pricing.
     */
    public function getPriceForQty(int $qty = 1): float
    {
        $prices = $this->prices;
        if ($prices->isEmpty()) {
            return 0;
        }

        foreach ($prices as $priceTier) {
            $min = $priceTier->min_qty;
            $max = $priceTier->max_qty;

            if ($qty >= $min && ($max === null || $qty <= $max)) {
                return (float) $priceTier->price;
            }
        }

        if ($qty < $prices->first()->min_qty) {
            return (float) $prices->first()->price;
        }

        return (float) $prices->last()->price;
    }
}
