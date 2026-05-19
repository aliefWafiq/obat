<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = [
        'kodeProduk',
        'gambar',
        'namaProduk',
        'deskripsi',
        'idCategory',
        'harga',
        'stok',
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'idCategory');
    }

    public function kuantitasDiskon()
    {
        return $this->hasMany(KuantitasDiskon::class, 'idProduk', 'id');
    }
}
