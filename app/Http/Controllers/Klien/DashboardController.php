<?php

namespace App\Http\Controllers\Klien;

use App\Progress;
use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $countProgress = Progress::whereHas('transaksi', function($item) {
            $item->where('user_id', Auth::user()->id);
        })->count();
        $transaksi = Transaksi::where('user_id', Auth::user()->id)->where('is_approve','Y')->get();
        return view('Klien.dashboard', compact('transaksi','countProgress'));
    }

    public function detailPekerjaan($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $progress = Progress::where('transaksi_id', $id)->where('is_approve','Y')->get();

        return view('Klien.detail-pekerjaan', compact('progress','transaksi'));
    }
}
