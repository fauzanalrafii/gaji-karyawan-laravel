<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    // Kasih tahu Laravel nama tabelnya
    protected $table = 'data_karyawan';
    
    // Izinkan semua kolom diisi (biar tidak ribet setting satu-satu)
    protected $guarded = [];
}
