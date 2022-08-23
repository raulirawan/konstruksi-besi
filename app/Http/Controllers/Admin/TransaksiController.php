<?php

namespace App\Http\Controllers\Admin;

use App\Progress;
use App\Transaksi;
use App\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {

            if (!empty($request->from_date)) {
                if ($request->from_date === $request->to_date) {
                    $query  = Transaksi::query();
                    $query->with(['klien', 'portfolio'])
                        ->whereDate('created_at', $request->from_date);
                } else {
                    $query  = Transaksi::query();
                    $query->with(['klien', 'portfolio'])
                        ->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
                }
            } else {
                $today = date('Y-m-d');
                $query  = Transaksi::query();
                $query->with(['klien', 'portfolio'])
                    ->whereDate('created_at', $today);
            }

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '<a href="' . route('admin.transaksi.detail', $item->id) . '" class="btn-sm btn-info"><i class="fas fa-eye"></i>Detail</a>';
                })
                ->editColumn('status', function ($item) {
                    if ($item->status == 'SUDAH DP') {
                        return '<span class="badge badge-success">SUDAH DP</span>';
                    } elseif ($item->status == 'PENDING') {
                        return '<span class="badge badge-warning">PENDING</span>';
                    } elseif ($item->status == 'LUNAS') {
                        return '<span class="badge badge-success">LUNAS</span>';
                    } else {
                        return '<span class="badge badge-danger">BATAL</span>';
                    }
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at;
                })
                ->rawColumns(['action', 'status'])
                ->make();
        }
        return view('Admin.transaksi.index');
    }

    public function riwayatPekerjaan(Request $request)
    {
        if (request()->ajax()) {

            if (!empty($request->from_date)) {
                if ($request->from_date === $request->to_date) {
                    $query  = Transaksi::query();
                    $query->with(['klien', 'portfolio'])
                        ->where('status', 'LUNAS')
                        ->whereDate('created_at', $request->from_date);
                } else {
                    $query  = Transaksi::query();
                    $query->with(['klien', 'portfolio'])
                        ->where('status', 'LUNAS')
                        ->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
                }
            } else {
                $today = date('Y-m-d');
                $query  = Transaksi::query();
                $query->with(['klien', 'portfolio'])
                    ->where('status', 'LUNAS')
                    ->whereDate('created_at', $today);
            }

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '<a href="' . route('admin.transaksi.detail', $item->id) . '" class="btn-sm btn-info"><i class="fas fa-eye"></i>Detail</a>';
                })
                ->editColumn('status', function ($item) {
                    if ($item->status == 'SUDAH DP') {
                        return '<span class="badge badge-success">SUDAH DP</span>';
                    } elseif ($item->status == 'PENDING') {
                        return '<span class="badge badge-warning">PENDING</span>';
                    } elseif ($item->status == 'LUNAS') {
                        return '<span class="badge badge-success">LUNAS</span>';
                    } else {
                        return '<span class="badge badge-danger">BATAL</span>';
                    }
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at;
                })
                ->rawColumns(['action', 'status'])
                ->make();
        }
        return view('Admin.transaksi.riwayat-pekerjaan');
    }

    public function detail($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $pembayaran = Pembayaran::where('transaksi_id', $id)->get();

        return view('Admin.transaksi.detail', compact('transaksi', 'pembayaran'));
    }

    public function addPembayaran(Request $request, $id)
    {

        $kode = 'BYR-' . mt_rand(0000, 9999);

        $pembayaran = new Pembayaran();
        $pembayaran->transaksi_id = $id;
        $pembayaran->kode_pembayaran = $kode;
        $pembayaran->keterangan = $request->keterangan;
        $pembayaran->total_bayar = $request->total_bayar;
        $pembayaran->status = 'PENDING';
        $pembayaran->save();

        if ($pembayaran != null) {
            return redirect()->route('admin.transaksi.detail', $id)->with('success', 'Data Berhasil di Tambahkan');
        } else {
            return redirect()->route('admin.transaksi.detail', $id)->with('error', 'Data Gagal di Tambahkan');
        }
    }

    public function deletePembayaran($id)
    {
        $data = Pembayaran::findOrFail($id);

        if ($data != null) {
            $data->delete();
            return redirect()->route('admin.transaksi.detail', $data->transaksi_id)->with('success', 'Data Berhasil di Hapus');
        } else {
            return redirect()->route('admin.transaksi.detail', $data->transaksi_id)->with('error', 'Data Gagal di Hapus');
        }
    }

    public function accept(Request $request)
    {
        $transaksi = Transaksi::findOrFail($request->transaksi_id);

        $transaksi->mandor_id = $request->mandor_id;
        $transaksi->is_approve = 'Y';
        $transaksi->save();

        if ($transaksi != null) {
            return redirect()->route('admin.dashboard.index')->with('success', 'Data Berhasil di Approve');
        } else {
            return redirect()->route('admin.dashboard.index')->with('error', 'Data Gagal di Approve');
        }
    }

    public function reject($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->status = 'BATAL';
        $transaksi->is_approve = 'N';
        $transaksi->save();

        if ($transaksi != null) {
            return redirect()->route('admin.dashboard.index')->with('success', 'Data Berhasil di Reject');
        } else {
            return redirect()->route('admin.dashboard.index')->with('error', 'Data Gagal di Reject');
        }
    }

    public function acceptProgress($id)
    {
        $progress = Progress::findOrFail($id);

        $progress->is_approve = 'Y';
        $progress->save();

        if ($progress != null) {
            return redirect()->route('admin.dashboard.index')->with('success', 'Data Berhasil di Approve');
        } else {
            return redirect()->route('admin.dashboard.index')->with('error', 'Data Gagal di Approve');
        }
    }

    public function rejectProgress($id)
    {
        $progress = Progress::findOrFail($id);

        $progress->is_approve = 'N';
        $progress->save();

        if ($progress != null) {
            return redirect()->route('admin.dashboard.index')->with('success', 'Data Berhasil di Reject');
        } else {
            return redirect()->route('admin.dashboard.index')->with('error', 'Data Gagal di Reject');
        }
    }
}
