<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DataKaryawan;
use App\Models\GajiKaryawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        // Passwordnya saya set: password
        User::create([
            'name' => 'Admin Gaji',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);

        // 2. Buat Data Karyawan: Achmad Nurnaafi
        $karyawan1 = DataKaryawan::create([
            'nama' => 'Achmad Nurnaafi',
            'jabatan' => 'IT',
            'alamat' => 'Tangerang',
            'no_telp' => '628989149386',
        ]);

        // 3. Buat Data Karyawan: Ikhsan Saputra
        $karyawan2 = DataKaryawan::create([
            'nama' => 'Ikhsan Saputra',
            'jabatan' => 'IT',
            'alamat' => 'Jakarta Utara',
            'no_telp' => '628991114444',
        ]);

        // 4. Masukkan Gaji (Contoh relasi: pakai ID dari karyawan yang baru dibuat)
        GajiKaryawan::create([
            'id_karyawan' => $karyawan1->id, // Punya Achmad
            'bulan' => 'November',
            'tahun' => '2025',
            'gaji_pokok' => 15000000,
            'tunjangan' => 1000000,
            'potongan' => 1200000,
            'total_gaji' => 14800000,
        ]);

        GajiKaryawan::create([
            'id_karyawan' => $karyawan2->id, // Punya Ikhsan
            'bulan' => 'November',
            'tahun' => '2025',
            'gaji_pokok' => 15000000,
            'tunjangan' => 1000000,
            'potongan' => 2000000,
            'total_gaji' => 14000000,
        ]);
    }
}
