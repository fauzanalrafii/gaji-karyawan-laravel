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
            $table->id('id_gaji');
            $table->foreignId('id_karyawan')
                ->constrained('data_karyawan')
                ->onDelete('cascade');
            $table->enum('bulan', [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ])->nullable();
            $table->year('tahun')->nullable();
            $table->decimal('gaji_pokok', 12, 2)->nullable();
            $table->decimal('tunjangan', 12, 2)->nullable();
            $table->decimal('potongan', 12, 2)->nullable();
            $table->decimal('total_gaji', 12, 2)->nullable();
            $table->timestamps();

            $table->unique(['id_karyawan', 'bulan', 'tahun'], 'unique_gaji_per_bulan_tahun');
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
