<?php

namespace App\Http\Controllers\Admin;

use App\Progress;
use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   public function index()
   {
       $transaksi = Transaksi::whereIn('status',['SUDAH DP','LUNAS'])->where('is_approve','P')->get();
       $progress = Progress::where('is_approve','P')->get();
       return view('Admin.dashboard', compact('transaksi','progress'));
   }
}
