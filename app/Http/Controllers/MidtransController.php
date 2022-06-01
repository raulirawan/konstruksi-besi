<?php

namespace App\Http\Controllers;

use App\Pembayaran;
use App\Transaksi;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        //set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //buat instance midtrans
        $notification = new Notification();

        //assign ke variable untuk memudahkan coding

        $status = $notification->transaction_status;


        $pembayaran = Pembayaran::where('kode_pembayaran', $notification->order_id)->first();



        $transaksi = Transaksi::where('id', $pembayaran->transaksi_id)->first();

        // handler notification status midtrans
        if ($status == "settlement") {


            $pembayaran->status = 'LUNAS';
            $pembayaran->save();
            $pembayaranCountLunas = Pembayaran::where('transaksi_id', $pembayaran->transaksi_id,'user_id')
            ->where('status',"LUNAS")
            ->count();

            if($transaksi->tipe_transaksi == 'BELI') {
                $transaksi->status = 'LUNAS';
                $transaksi->save();
            } else {
                if($pembayaranCountLunas == 2) {
                    $transaksi->status = 'LUNAS';
                    $transaksi->save();
                } else {
                    $transaksi->status = 'SUDAH DP';
                    $transaksi->save();
                }
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Payment Success'
                ]
            ]);
        } else if ($status == "pending") {
            $pembayaran->status = 'PENDING';
            $pembayaran->save();
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Payment Pending'
                ]
            ]);
        } else if ($status == 'deny') {
            $pembayaran->status = 'GAGAL';
            $pembayaran->save();
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Payment Deny'
                ]
            ]);
        } else if ($status == 'expired') {
            $pembayaran->status = 'GAGAL';
            $pembayaran->save();
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Payment Expired'
                ]
            ]);
        } else if ($status == 'cancel') {
            $pembayaran->status = 'GAGAL';
            $pembayaran->save();
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Payment Cancel'
                ]
            ]);
        } else {
            $pembayaran->status = 'GAGAL';
            $pembayaran->save();
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'message' => 'Midtrans Payment Gagal'
                ]
            ]);
        }


    }
}
