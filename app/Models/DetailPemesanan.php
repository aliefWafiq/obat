<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    protected $table = 'detailPemesanan';
    protected $fillable = [
        'idPemesanan',
        'idProduk',
        'jumlahBeli',
        'harga'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'id');
    }
}
