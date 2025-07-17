<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBeras extends Model
{
    use HasFactory;

    protected $table = 'data_beras';

    protected $fillable = [
        'tanggal',
        'harga_beras_kualitas_bawah_i',
        'harga_beras_kualitas_bawah_ii',
        'harga_beras_kualitas_medium_i',
        'harga_beras_kualitas_medium_ii',
        'harga_beras_kualitas_super_i',
        'harga_beras_kualitas_super_ii',
        'inflasi_bi',
        'kurs_usd',
        'bbm_pertalite',
        'ump_sulut',
        'jumlah_penduduk',
        'pupuk_nonsubsidi', // Diubah dari pupuk_subsidi
    ];

    protected $casts = [
        'tanggal' => 'date',
        'harga_beras_kualitas_bawah_i' => 'decimal:2',
        'harga_beras_kualitas_bawah_ii' => 'decimal:2',
        'harga_beras_kualitas_medium_i' => 'decimal:2',
        'harga_beras_kualitas_medium_ii' => 'decimal:2',
        'harga_beras_kualitas_super_i' => 'decimal:2',
        'harga_beras_kualitas_super_ii' => 'decimal:2',
        'inflasi_bi' => 'decimal:2',
        'kurs_usd' => 'decimal:2',
        'bbm_pertalite' => 'decimal:2',
        'ump_sulut' => 'decimal:2',
        'jumlah_penduduk' => 'decimal:2',
        'pupuk_nonsubsidi' => 'decimal:2', // Diubah dari pupuk_subsidi
    ];
}
