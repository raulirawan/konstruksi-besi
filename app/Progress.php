<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progress';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id','id');
    }

    public function mandor()
    {
        return $this->belongsTo(User::class, 'mandor_id','id');
    }
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id','id');
    }
}
