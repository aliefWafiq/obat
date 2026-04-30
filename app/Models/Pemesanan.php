<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $fillable = [
        'idUser',
        'idProduk',
        'status',
        'totalBeli',
        'totalHarga',
        'estimasipembayaran',
        'estimasiPengantaran',
    ];
}
