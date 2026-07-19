<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function indexCategory() { return view('admin.master-kategori'); }
    public function showCategory() { return view('admin.show-master-kategori'); }
    public function indexMaster() { return view('admin.data-master'); }
}
