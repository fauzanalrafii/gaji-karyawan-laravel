<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    protected $table = 'data_karyawan';
    protected $guarded = [];

    // --- RELASI ---
    public function gaji()
    {
        return $this->hasMany(GajiKaryawan::class, 'id_karyawan');
    }

    // --- QUERY SCOPE ---
    public function scopeUrutkanNama($query)
    {
        return $query->orderBy('nama', 'asc');
    }

    // --- STATIC METHODS (FAT MODEL) ---

    // 1. Ambil Semua Data
    public static function ambilSemua()
    {
        return self::urutkanNama()->get();
    }

    // 2. Cari Data by ID
    public static function cari($id)
    {
        return self::findOrFail($id);
    }

    // 3. Tambah Data
    public static function tambah($data)
    {
        return self::create($data);
    }

    // 4. Update Data
    public static function ubah($id, $data)
    {
        return self::cari($id)->update($data);
    }

    // 5. Hapus Data
    public static function hapus($id)
    {
        return self::cari($id)->delete();
    }
}
