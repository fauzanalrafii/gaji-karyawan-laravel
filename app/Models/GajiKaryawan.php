<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    protected $table = 'gaji_karyawan';
    protected $primaryKey = 'id_gaji';
    protected $fillable = [
        'id_karyawan',
        'bulan',
        'tahun',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'total_gaji',
    ];

    public function karyawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'id_karyawan');
    }

    public function scopeUrutkanPeriode($query)
    {
        return $query->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");
    }

    // Ambil semua gaji
    public static function ambilSemua()
    {
        return self::with('karyawan')->urutkanPeriode()->get();
    }

    // Cari berdasarkan ID
    public static function cari($id)
    {
        return self::findOrFail($id);
    }

    // Tambah data
    public static function tambah($data)
    {
        return self::create($data);
    }

    // Update data
    public static function ubah($id, $data)
    {
        return self::cari($id)->update($data);
    }

    // Hapus data
    public static function hapus($id)
    {
        return self::cari($id)->delete();
    }

    public static function cekDuplikat($id_karyawan, $bulan, $tahun, $excludeId)
    {
        return self::where('id_karyawan', $id_karyawan)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('id_gaji', '!=', $excludeId) // Kecualikan ID yang sedang diedit
            ->exists();
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $hasil = ($model->gaji_pokok + $model->tunjangan) - $model->potongan;
            $model->total_gaji = $hasil < 0 ? 0 : $hasil;
        });
    }
}
