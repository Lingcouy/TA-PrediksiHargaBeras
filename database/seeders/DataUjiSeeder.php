<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataUji;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DataUjiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('data/data_uji.csv');

        if (!File::exists($file)) {
            echo "File CSV tidak ditemukan!\n";
            return;
        }

        $data = array_map('str_getcsv', file($file));
        array_shift($data); // Hapus header

        DB::table('data_uji')->truncate();

        foreach ($data as $row) {
            DB::table('data_uji')->insert([
                'tanggal_data_uji' => $row[0],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
