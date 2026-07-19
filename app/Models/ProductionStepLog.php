<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionStepLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function production() { return $this->belongsTo(Production::class); }
    public function step() { return $this->belongsTo(ProductionStep::class, 'production_step_id'); }
    public function photos() { return $this->hasMany(ProductionStepPhoto::class); }
    public function user() { return $this->belongsTo(User::class, 'created_by'); }
}
