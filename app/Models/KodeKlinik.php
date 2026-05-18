<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeKlinik extends Model
{
    protected $table = 'kodeKlinik';

    protected $fillable = [
        'kodeKlinik',
        'namaKlinik',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'idKlinik');
    }
}
