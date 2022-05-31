<?php

namespace App\Http\Controllers\Klien;

use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('user_id', Auth::user()->id)->where('is_approve','Y')->get();
        return view('Klien.dashboard', compact('transaksi'));
    }
}
