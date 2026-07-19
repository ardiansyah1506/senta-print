<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'm_categories';
    protected $guarded = [];
    public function sizes() { return $this->belongsToMany(Size::class, 'pivot_category_size'); }
    public function addons() { return $this->belongsToMany(Addon::class, 'pivot_category_addons')->withPivot('price', 'display_order'); }
    public function products() { return $this->hasMany(Product::class); }
}
