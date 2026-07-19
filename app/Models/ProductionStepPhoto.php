<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionStepPhoto extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function log() { return $this->belongsTo(ProductionStepLog::class, 'production_step_log_id'); }
}
