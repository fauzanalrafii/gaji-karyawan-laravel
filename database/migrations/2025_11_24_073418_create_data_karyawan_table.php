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
        Schema::create('data_karyawan', function (Blueprint $table) {
            $table->id(); // Ini otomatis jadi Primary Key Auto Increment
            $table->string('nama', 100)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('no_telp', 13)->unique()->nullable();
            $table->timestamps(); // Ini fitur Laravel (created_at & updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_karyawan');
    }
};
