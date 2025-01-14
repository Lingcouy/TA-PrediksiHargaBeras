<?php

namespace App\Http\Controllers;

use App\Models\DataPrediksi;
use Illuminate\Http\Request;

class DataPrediksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dataPrediksis = DataPrediksi::all();
        return view("dataPrediksi.dataPrediksi");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("dataPrediksi.aksi.create");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         // Validasi input bulan dan tahun
        $validatedData = $request->validate([
            'bulan' => [
                'required',
                'regex:/^(0[1-9]|1[0-2])$/' // Validasi format MM
            ],
            'tahun' => [
                'required',
                'digits:4', // Validasi format YYYY
                'integer',
                'min:2000', // Tahun minimal 2000
                'max:' . date('Y'), // Tahun tidak boleh melebihi tahun saat ini
            ],
            'hargaBeras' => 'required|numeric|min:0',
            'produksiPadi' => 'required|numeric|min:0',
            'produksiBeras' => 'required|numeric|min:0',
            'luasPanenPadi' => 'required|numeric|min:0',
            'indeksHargaKonsumen' => 'required|numeric|min:0',
            'inflasi' => 'required|numeric|between:-100,100',
            'curahHujan' => 'required|numeric|min:0',
        ], [
            // Pesan kesalahan khusus
            'bulan.required' => 'Bulan wajib diisi.',
            'bulan.regex' => 'Format bulan harus MM (01-12).',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.digits' => 'Tahun harus terdiri dari 4 digit.',
            'tahun.min' => 'Tahun minimal adalah 2000.',
            'tahun.max' => 'Tahun tidak boleh melebihi tahun saat ini.',
        ]);

        // Gabungkan bulan dan tahun menjadi periode
        $validatedData['periode'] = $validatedData['tahun'] . '-' . $validatedData['bulan'];

        // Simpan data ke database
        DataPrediksi::create($validatedData);

        // Redirect atau respon sukses
        return redirect('/keloladataprediksi')->with('success', 'Data prediksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataPrediksi $dataPrediksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPrediksi $dataPrediksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataPrediksi $dataPrediksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPrediksi $dataPrediksi)
    {
        //
    }
}
