<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuatProgram extends Model
{
    protected $table = 'buatProgram';

    protected $fillable = [
        'gambar',
        'tagProgram',
        'judul',
        'deskripsi',
    ];
}
