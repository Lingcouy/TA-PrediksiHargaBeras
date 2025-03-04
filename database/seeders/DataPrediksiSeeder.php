<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataPrediksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DataPrediksiSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('data/data_beras.csv');

        if (!File::exists($file)) {
            echo "File CSV tidak ditemukan!\n";
            return;
        }

        $data = array_map('str_getcsv', file($file));
        array_shift($data); // Hapus header

        DB::table('data_prediksi')->truncate();

        foreach ($data as $row) {
            if ($row[0] === 'SUM') {
                continue;
            }

            DataPrediksi::create([
                'periode' => $row[1], // tanggal
                'hargaBeras' => (int)$row[2],
                'produksiPadi' => (float)$row[3],
                'produksiBeras' => (float)$row[4],
                'luasPanenPadi' => (float)$row[5],
                'indeksHargaKonsumen' => (float)$row[6], // ihk
                'inflasi' => null, // Explicitly set NULL since CSV has no inflasi column
                'curahHujan' => (float)$row[7] // curah_hujan
            ]);
        }
    }
}
