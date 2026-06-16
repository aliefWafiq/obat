<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert(
            [
                [
                    'key' => 'namaAplikasi',
                    'value' => 'ObatKita',
                ],
                [
                    'key' => 'alamatEmailSupport',
                    'value' => 'support@obatkita.com',
                ],
                [
                    'key' => 'formatKode',
                    'value' => 'ORD-{YEAR}-{MONTH}-{RAND:4}',
                ],
                [
                    'key' => 'modePemeliharaan',
                    'value' => 'false',
                ],
                [
                    'key' => 'PendaftaranMandiriDokter',
                    'value' => 'true',
                ],
                [
                    'key' => 'kirimInvoiceOtomatis',
                    'value' => 'true',
                ],
                [
                    'key' => 'pengingatStok',
                    'value' => 'true',
                ],
                [
                    'key' => 'masaKadaluarsaSesi',
                    'value' => '120 Menit (2 Jam)',
                ],
                [
                    'key' => 'paksaKebijakanSandi',
                    'value' => 'true',
                ],
                [
                    'key' => 'logAktivitas',
                    'value' => 'true',
                ],
            ]
        );
    }
}
