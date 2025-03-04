<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPrediksi extends Model
{
    use HasFactory;

    protected $table = 'data_prediksi';
    protected $primaryKey = 'idDataPrediksi';
    protected $fillable = ['periode', 'hargaBeras', 'produksiPadi', 'produksiBeras', 'luasPanenPadi', 'indeksHargaKonsumen', 'inflasi', 'curahHujan'];
}

//namespace App\Models;
//
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//
//class DataPrediksi extends Model
//{
//    use HasFactory;
//
//    protected $table = 'data_prediksi';
//
//    protected $fillable = [
//        'tanggal', 'harga_beras', 'produksi_padi',
//        'produksi_beras', 'luas_panen', 'ihk', 'curah_hujan'
//    ];
//}
