<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'Super Admin',
            'phoneNumber' => '08123890',
            'password' => Hash::make('123'),
            'idKlinik' => null,
            'role' => 'SuperAdmin',
            'alamat' => 'asdasd',
        ]);
    }
}
