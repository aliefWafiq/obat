<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $fillable = [
        'kodePemesanan',
        'idUser',
        'status',
        'totalHarga',
        'paymentLink',
        'estimasipembayaran',
        'estimasiPengantaran',
        'tipePembayaran',
    ];

    public function details()
    {
        return $this->hasMany(DetailPemesanan::class, 'idPemesanan');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
}
