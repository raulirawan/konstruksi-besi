<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
   {
       $transaksi = Transaksi::whereIn('status',['SUDAH DP','LUNAS'])->where('is_approve','P')->get();
       return view('Admin.dashboard', compact('transaksi'));
   }
}
