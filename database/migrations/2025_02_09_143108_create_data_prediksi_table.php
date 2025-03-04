<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_prediksi', function (Blueprint $table) {
            $table->id('idDataPrediksi');
            $table->date('periode');
            $table->integer('hargaBeras');
            $table->decimal('produksiPadi', 8, 2);
            $table->decimal('produksiBeras', 8, 2);
            $table->decimal('luasPanenPadi', 8, 2);
            $table->decimal('indeksHargaKonsumen', 8, 2);
            $table->decimal('inflasi', 8, 2)->nullable();;
            $table->decimal('curahHujan', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_prediksi');
    }
};
