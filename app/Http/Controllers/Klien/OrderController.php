<?php

namespace App\Http\Controllers\Klien;

use Exception;
use App\Portfolio;
use App\Transaksi;
use Midtrans\Snap;
use App\Pembayaran;
use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $portfolio = Portfolio::all();
        return view('Klien.order.index', compact('portfolio'));
    }

    public function orderForm($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        return view('Klien.order.form', compact('portfolio'));
    }

    public function orderStore(Request $request)
    {
        // create Ketua Kelompok
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $kode_transaksi = 'RM-'.mt_rand(0000,9999);
        $kode_pembayaran = 'BYR-'.mt_rand(0000,9999);

        // buat transaksi
        $transaksi = new Transaksi();

        $transaksi->user_id = Auth::user()->id;
        $transaksi->portfolio_id = $request->portfolio_id;
        $transaksi->kode_transaksi = $kode_transaksi;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->tipe_transaksi = $request->tipe_transaksi;
        $transaksi->status = 'PENDING';
        $transaksi->is_approve = 'P';
        $transaksi->save();

        if($request->tipe_transaksi == 'BELI + PASANG') {
            $keterangan = 'Pembayaran Tahap 1';
            $totalBayar = $request->total_harga/2;
        } else {
            $keterangan = 'Pembayaran Beli Barang';
            $totalBayar = $request->total_harga;
        }
        // buat pembayaran
        $pembayaran = new Pembayaran();
        $pembayaran->transaksi_id = $transaksi->id;
        $pembayaran->kode_pembayaran = $kode_pembayaran;
        $pembayaran->total_bayar = $totalBayar;
        $pembayaran->keterangan = $keterangan;
        $pembayaran->status = 'PENDING';

         // kirim ke midtrans
         $midtrans_params = [
            'transaction_details' => [
                'order_id' => $kode_pembayaran,
                'gross_amount' => (int) $request->total_harga,
            ],

            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enable_payments' => ['bca_va','permata_va','bni_va','bri_va','gopay'],
            'vtweb' => [],
        ];

        try {
            //ambil halaman payment midtrans

            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;


            $pembayaran->link_pembayaran = $paymentUrl;
            $pembayaran->save();

            return redirect($paymentUrl);
            //reditect halaman midtrans
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
