<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keranjang extends Model
{
    protected $table = 'keranjang';

    protected $fillable = [
        'idUser',
        'idProduk',
        'jumlah',
    ];
    public function produk(){
        return $this->belongsTo(Produk::class, 'idProduk');
    }
}
