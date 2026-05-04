<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $fillable = [
        'kodePemesanan',
        'idUser',
        'status',
        'totalHarga',
        'estimasipembayaran',
        'estimasiPengantaran',
    ];

    public function details() {
        return $this->hasMany(DetailPemesanan::class, 'idPemesanan');
    }
}