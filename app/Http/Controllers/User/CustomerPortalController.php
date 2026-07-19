<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerPortalController extends Controller
{
    public function createOrder() { return view('user.buat-pesanan'); }
    public function trackOrder() { return view('user.lacak-pesanan'); }
    public function orderHistory() { return view('user.riwayat-pesanan'); }
}
