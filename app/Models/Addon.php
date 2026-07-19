<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;
    protected $table = 'm_addons';
    protected $fillable = ['name', 'type', 'description'];
}
