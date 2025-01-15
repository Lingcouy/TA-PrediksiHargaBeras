<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPrediksi extends Model
{
    //
    protected $primaryKey = 'idDataPrediksi';
    protected $fillable = ['periode', 'hargaBeras', 'produksiPadi', 'produksiBeras', 'luasPanenPadi', 'indeksHargaKonsumen', 'inflasi', 'curahHujan'];
}   