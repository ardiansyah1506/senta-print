<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'm_sizes';
    protected $guarded = [];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'pivot_category_size', 'size_id', 'category_id')
                    ->withPivot('display_order')
                    ->withTimestamps();
    }
}
