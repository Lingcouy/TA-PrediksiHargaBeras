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
        Schema::create('data_prediksis', function (Blueprint $table) {
            $table->id('idDataPrediksi');
            $table->string('periode', 7)->comment('Periode dalam format YYYY-MM');
            $table->decimal('hargaBeras', 12, 4);
            $table->decimal('produksiPadi', 12, 4);
            $table->decimal('produksiBeras', 12, 4);
            $table->decimal('luasPanenPadi', 12, 4);
            $table->decimal('indeksHargaKonsumen', 12, 4);
            $table->decimal('inflasi', 12, 4);
            $table->decimal('curahHujan', 12, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_prediksis');
    }
};
