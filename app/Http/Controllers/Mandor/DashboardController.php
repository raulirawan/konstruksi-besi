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
        $pekerjaan = Transaksi::with(['klien','portfolio','mandor'])
                                ->where('mandor_id', Auth::user()->id)
                                ->whereIn('status',['SUDAH DP','LUNAS'])
                                ->where('is_approve','Y')
                                ->get();
        return view('Mandor.dashboard', compact('pekerjaan'));
    }

    public function detailPekerjaan($id)
    {
        $progress = Progress::where('mandor_id', Auth::user()->id)->where('transaksi_id', $id)->get();
        $transaksi = Transaksi::findOrFail($id);

        return view('Mandor.detail-progress', compact('progress','transaksi'));
    }

    public function addProgress(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $progress = new Progress();
        $progress->mandor_id = Auth::user()->id;
        $progress->transaksi_id = $id;
        $progress->portfolio_id = $transaksi->portfolio_id;
        $progress->jenis_pekerjaan = $request->jenis_pekerjaan;
        $progress->keterangan = $request->progress;
        $progress->is_approve = 'P';

        if($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/progress/';
            $nama_file = time()."_".$file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            $file->move($tujuan_upload,$nama_file);

            $progress->gambar = $tujuan_upload.$nama_file;
        }
        $progress->save();

        if($progress != null) {
            return redirect()->route('mandor.detail.pekerjaan.index', $id)->with('success','Data Berhasil di Tambah');
        } else {
            return redirect()->route('mandor.detail.pekerjaan.index', $id)->with('error','Data Gagal di Tambah');
        }
    }

    public function updateProgress(Request $request, $id)
    {
        $progress = Progress::findOrFail($id);
        $progress->jenis_pekerjaan = $request->jenis_pekerjaan;
        $progress->keterangan = $request->progress;

        if($progress->is_approve == 'N') {
            $progress->is_approve = 'P';
        }

        if($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/progress/';
            $nama_file = time()."_".$file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            if(file_exists($progress->gambar)) {
                unlink($progress->gambar);
            }
            $file->move($tujuan_upload,$nama_file);
            $progress->gambar = $tujuan_upload.$nama_file;
        }

        $progress->save();

        if($progress != null) {
            return redirect()->route('mandor.detail.pekerjaan.index', $progress->transaksi_id)->with('success','Data Berhasil di Update');
        } else {
            return redirect()->route('mandor.detail.pekerjaan.index', $progress->transaksi_id)->with('error','Data Gagal di Update');
        }
    }

    public function deleteProgress($id)
    {
        $progress = Progress::findOrFail($id);

        if($progress != null) {
            if(file_exists($progress->gambar)) {
                unlink($progress->gambar);
            }
            $progress->delete();
            return redirect()->route('mandor.detail.pekerjaan.index', $progress->transaksi_id)->with('success','Data Berhasil di Hapus');
        } else {
            return redirect()->route('mandor.detail.pekerjaan.index', $progress->transaksi_id)->with('error','Data Gagal di Hapus');
        }
    }
}
