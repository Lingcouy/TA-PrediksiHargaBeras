<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DataBerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('data/beras-new.csv');

        if (!File::exists($file)) {
            echo "File CSV tidak ditemukan!\n";
            return;
        }

        $data = array_map('str_getcsv', file($file));
        array_shift($data); // Hapus header

        DB::table('data_beras')->truncate();

        foreach ($data as $row) {
            DB::table('data_beras')->insert([
                'tanggal' => $row[0],
                'harga_beras_kualitas_bawah_i' => (float)$row[1],
                'harga_beras_kualitas_bawah_ii' => (float)$row[2],
                'harga_beras_kualitas_medium_i' => (float)$row[3],
                'harga_beras_kualitas_medium_ii' => (float)$row[4],
                'harga_beras_kualitas_super_i' => (float)$row[5],
                'harga_beras_kualitas_super_ii' => (float)$row[6],
                'inflasi_bi' => (float)$row[7],
                'kurs_usd' => (float)$row[8],
                'bbm_pertalite' => (float)$row[9],
                'ump_sulut' => (float)$row[10],
                'jumlah_penduduk' => (float)$row[11],
                'pupuk_nonsubsidi' => (float)$row[12],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
