<?php

namespace App\Http\Controllers\Mandor;

use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Progress;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pekerjaan = Transaksi::with(['klien','portfolio','mandor'])->where('mandor_id', Auth::user()->id)->get();
        return view('Mandor.dashboard', compact('pekerjaan'));
    }

    public function detailPekerjaan($id)
    {
        $progress = Progress::where('mandor_id', Auth::user()->id)->where('transaksi_id', $id)->get();

        return view('Mandor.detail-progress', compact('progress'));
    }
}
