<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUji extends Model
{
    use HasFactory;

    protected $table = 'data_uji';

    protected $fillable = ['tanggal_data_uji'];

    protected $casts = [
        'tanggal_data_uji' => 'date',
    ];
}
