<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';


    public function klien()
    {
        return $this->belongsTo(User::class, 'user_id','id');
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
