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
        Schema::create('data_beras', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->decimal('harga_beras_kualitas_bawah_i', 10, 2);
            $table->decimal('harga_beras_kualitas_bawah_ii', 10, 2);
            $table->decimal('harga_beras_kualitas_medium_i', 10, 2);
            $table->decimal('harga_beras_kualitas_medium_ii', 10, 2);
            $table->decimal('harga_beras_kualitas_super_i', 10, 2);
            $table->decimal('harga_beras_kualitas_super_ii', 10, 2);
            $table->decimal('inflasi_bi', 5, 2);
            $table->decimal('kurs_usd', 10, 2);
            $table->decimal('bbm_pertalite', 10, 2);
            $table->decimal('ump_sulut', 10, 2);
            $table->decimal('jumlah_penduduk', 12, 2);
            $table->decimal('pupuk_subsidi', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_beras');
    }
};
