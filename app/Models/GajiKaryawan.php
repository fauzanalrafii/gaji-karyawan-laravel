<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    protected $table = 'gaji_karyawan';
    protected $primaryKey = 'id_gaji';
    protected $guarded = [];

    // Relasi: Gaji "Belongs To" (Milik) Karyawan
    public function karyawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'id_karyawan', 'id');
    }
}
