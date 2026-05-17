<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuantitasDiskon extends Model
{
    protected $table = "kuantitasDiskon";

    protected $fillable = [
        "idProduk",
        "minimalBeli",
        "diskon"
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'id');
    }
}