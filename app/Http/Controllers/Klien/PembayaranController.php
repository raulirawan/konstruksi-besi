<?php

namespace App\Http\Controllers\Klien;

use Exception;
use App\Transaksi;
use Midtrans\Snap;
use App\Pembayaran;
use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PembayaranController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('user_id', Auth::user()->id)->get();
        return view('Klien.pembayaran.index', compact('transaksi'));
    }

    public function detail($id)
    {
        $pembayaran = Pembayaran::where('transaksi_id', $id)->get();

        return view('Klien.pembayaran.detail', compact('pembayaran'));
    }

    public function bayar($id)
    {
        $pembayaran = Pembayaran::where('id', $id)->first();

        if($pembayaran->link_pembayaran != null) {
            return Redirect::to($pembayaran->link_pembayaran);
        }else {
             // create Ketua Kelompok
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

            // kirim ke midtrans
            $midtrans_params = [
                'transaction_details' => [
                    'order_id' => $pembayaran->kode_pembayaran,
                    'gross_amount' => (int) $pembayaran->total_bayar,
                ],

                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'callbacks' => [
                    'finish' => 'https://cvramajaya.my.id/pembayaran',
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

        return view('Klien.pembayaran.detail', compact('pembayaran'));
    }
}
