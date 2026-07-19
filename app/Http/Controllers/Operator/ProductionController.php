<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index() { return view('operator.kelolaproduksi'); }
    public function tracking() { return view('operator.tracking'); }
}
