<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPrediksi;

class data_prediksi extends Controller
{
    //
    public function index(Request $request){
         // Ambil input bulan dan tahun dari request
         $bulan = $request->input('bulan');
         $tahun = $request->input('tahun');
 
         // Filter data berdasarkan bulan dan/atau tahun
         $dataPrediksis = DataPrediksi::when($tahun, function ($query, $tahun) {
                 return $query->where('periode', 'like', $tahun . '-%');
             })
             ->when($bulan, function ($query, $bulan) {
                 return $query->where('periode', 'like', '%-' . $bulan);
             })
             ->paginate(10); // Atur jumlah item per halaman
 
         return view('data_prediksi.data_prediksi', [
             'dataPrediksis' => $dataPrediksis,
             'bulan' => $bulan, // Kirim data bulan ke view
             'tahun' => $tahun  // Kirim data tahun ke view
         ]); 
    }
}
