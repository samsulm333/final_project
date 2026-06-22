<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JalurPendaftaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seeder Akun Default
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ppdb.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Panitia',
            'email' => 'panitia@ppdb.com',
            'password' => Hash::make('password123'),
            'role' => 'panitia'
        ]);

        User::create([
            'name' => 'Calon Siswa Demo',
            'email' => 'siswa_001@ppdb.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa'
        ]);

        // 2. Seeder 3 Jalur Pendaftaran Sesuai Ketentuan
        JalurPendaftaran::insert([
            [
                'nama' => 'Reguler',
                'kuota' => 20,
                'deskripsi' => 'Seleksi berdasarkan nilai rata-rata rapor tertinggi.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Prestasi',
                'kuota' => 8,
                'deskripsi' => 'Wajib upload piagam serta seleksi berdasarkan nilai tertinggi.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Zonasi',
                'kuota' => 5,
                'deskripsi' => 'Domisili dalam kota yang sama (nama kecamatan sama) serta seleksi berdasarkan nilai tertinggi.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}