<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gaji_karyawan', function (Blueprint $table) {
            $table->id('id_gaji'); // Kita set nama ID-nya sesuai SQL lama
            
            // Ini cara Laravel bikin Relasi (Foreign Key)
            // Artinya: id_karyawan nyambung ke id di tabel data_karyawan
            // Kalau karyawan dihapus, gajinya ikut terhapus (cascade)
            $table->foreignId('id_karyawan')
                ->constrained('data_karyawan')
                ->onDelete('cascade');

            // Tipe data ENUM untuk Bulan
            $table->enum('bulan', [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ])->nullable();

            $table->year('tahun')->nullable();
            
            // Decimal (12 digit, 2 desimal) sesuai SQL lama
            $table->decimal('gaji_pokok', 12, 2)->nullable();
            $table->decimal('tunjangan', 12, 2)->nullable();
            $table->decimal('potongan', 12, 2)->nullable();
            $table->decimal('total_gaji', 12, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_karyawan');
    }
};
