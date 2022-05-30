<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id','id');
    }
}
