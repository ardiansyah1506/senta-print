<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['type', 'start_date', 'end_date', 'target_amount'];
}
