<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPrediksi;

class prediksi_harga extends Controller
{
    // Fungsi untuk menampilkan data prediksi berdasarkan bulan dan tahun
    public function prediksi(Request $request)
    {
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

        return view('prediksi_harga.prediksi', [
            'dataPrediksis' => $dataPrediksis,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    // Fungsi untuk analisis regresi linier dan prediksi harga beras
    public function analyze(Request $request)
    {
        // Cek apakah pengguna memilih bulan dan tahun, jika tidak, ambil semua data
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Ambil data berdasarkan bulan dan tahun yang dipilih (atau semua data jika belum dipilih)
        $dataPrediksis = DataPrediksi::when($tahun, function ($query, $tahun) {
            return $query->where('periode', 'like', $tahun . '-%');
        })
            ->when($bulan, function ($query, $bulan) {
                return $query->where('periode', 'like', '%-' . $bulan);
            })
            ->get(); // Ambil data sesuai filter atau semua data

        // Persiapkan data untuk analisis
        $cleanedData = [];
        foreach ($dataPrediksis as $data) {
            if (is_numeric($data->hargaBeras) && is_numeric($data->produksiPadi) &&
                is_numeric($data->produksiBeras) && is_numeric($data->luasPanenPadi) &&
                is_numeric($data->indeksHargaKonsumen) && is_numeric($data->curahHujan)) {
                $cleanedData[] = [
                    'NO' => $data->idDataPrediksi, // Menggunakan ID sebagai NO
                    'HARGA_BERAS' => $data->hargaBeras,
                    'PRODUKSI_PADI' => $data->produksiPadi,
                    'PRODUKSI_BERAS' => $data->produksiBeras,
                    'LUAS_PANEN' => $data->luasPanenPadi,
                    'IHK' => $data->indeksHargaKonsumen,
                    'CURAH_HUJAN' => $data->curahHujan,
                ];
            }
        }

        // Pisahkan data pelatihan (1-10) dan pengujian (11-12)
        $trainingData = array_filter($cleanedData, function($row) {
            return (int)$row['NO'] <= 10;
        });
        $testingData = array_filter($cleanedData, function($row) {
            return (int)$row['NO'] > 10;
        });

        // Definisikan variabel independen (X) dan dependen (Y) untuk pelatihan
        $X_train = array_map(function($row) {
            return [
                $row['PRODUKSI_PADI'],
                $row['PRODUKSI_BERAS'],
                $row['LUAS_PANEN'],
                $row['IHK'],
                $row['CURAH_HUJAN']
            ];
        }, $trainingData);
        $Y_train = array_column($trainingData, 'HARGA_BERAS');
        $Y_train = array_map(function($item) {
            return [$item]; // Jadikan setiap elemen sebagai kolom
        }, $Y_train);

        // Definisikan variabel independen (X) dan dependen (Y) untuk pengujian
        $X_test = array_map(function($row) {
            return [
                $row['PRODUKSI_PADI'],
                $row['PRODUKSI_BERAS'],
                $row['LUAS_PANEN'],
                $row['IHK'],
                $row['CURAH_HUJAN']
            ];
        }, $testingData);
        $Y_test = array_column($testingData, 'HARGA_BERAS');

        // Tambahkan kolom satu untuk X_train dan X_test untuk intercept
        $X_train_with_const = array_map(function($row) {
            return array_merge([1], $row);
        }, $X_train);
        $X_test_with_const = array_map(function($row) {
            return array_merge([1], $row);
        }, $X_test);

        // Hitung matriks A dan vektor B
        $A = $this->matrixMultiply($this->transpose($X_train_with_const), $X_train_with_const);
        $B = $this->matrixMultiply($this->transpose($X_train_with_const), $Y_train);

        // Hitung koefisien
        $b = $this->matrixMultiply($this->inverse($A), $B);

        // Bangun persamaan regresi
        $regressionEquation = "Y = " . $b[0][0]; // Akses elemen pertama dari matriks $b (misalnya, konstanta atau intercept)
        $variables = ["PRODUKSI_PADI", "PRODUKSI_BERAS", "LUAS_PANEN", "IHK", "CURAH_HUJAN"];
        foreach ($variables as $i => $var) {
            $regressionEquation .= " + ({$b[$i + 1][0]} * {$var})"; // Akses koefisien untuk setiap variabel independen
        }


        // Prediksi untuk data pengujian
        $predictedPrices = array_map(function($row) use ($b) {
            return $this->matrixMultiply([$row], $b)[0];
        }, $X_test_with_const);

        // Hitung akurasi (Mean Absolute Percentage Error - MAPE)
        $mape = array_sum(array_map(function($actual, $predicted) {
                // Pastikan bahwa $actual dan $predicted adalah angka
                if (is_array($actual)) {
                    $actual = $actual[0]; // Ambil nilai pertama jika $actual adalah array
                }
                if (is_array($predicted)) {
                    $predicted = $predicted[0]; // Ambil nilai pertama jika $predicted adalah array
                }

                return abs(($actual - $predicted) / $actual);
            }, $Y_test, $predictedPrices)) / count($Y_test) * 100;


        // Tampilkan hasil
        return view('prediksi_harga.prediksi', [
            'regressionEquation' => $regressionEquation,
            'predictedPrices' => $predictedPrices,
            'mape' => (100 - $mape),
        ]);
    }

    // Metode untuk mengalikan dua matriks
    private function matrixMultiply($matrixA, $matrixB)
    {
        $result = [];

        foreach ($matrixA as $i => $rowA) {
            foreach ($matrixB[0] as $j => $columnB) {

                $result[$i][$j] = 0;
                foreach ($rowA as $k => $valueA) {
                    $result[$i][$j] += $valueA * $matrixB[$k][$j];
                }
            }
        }
        return $result;
    }

    // Metode untuk mentranspos matriks
    private function transpose($matrix)
    {
        $result = [];
        foreach ($matrix as $rowKey => $row) {
            foreach ($row as $colKey => $value) {
                $result[$colKey][$rowKey] = $value;
            }
        }
        return $result;
    }

    // Metode untuk menghitung invers matriks menggunakan Gauss-Jordan
    private function inverse($matrix)
    {
        $n = count($matrix);
        $augmentedMatrix = $this->augmentMatrix($matrix, $n);

        // Proses eliminasi Gauss-Jordan
        for ($i = 0; $i < $n; $i++) {
            // Jika elemen diagonal adalah 0, tukar dengan baris lainnya
            if ($augmentedMatrix[$i][$i] == 0) {
                for ($j = $i + 1; $j < $n; $j++) {
                    if ($augmentedMatrix[$j][$i] != 0) {
                        $augmentedMatrix = $this->swapRows($augmentedMatrix, $i, $j);
                        break;
                    }
                }
            }

            // Membagi baris untuk membuat elemen diagonal menjadi 1
            $factor = $augmentedMatrix[$i][$i];
            for ($k = 0; $k < 2 * $n; $k++) {
                $augmentedMatrix[$i][$k] /= $factor;
            }

            // Mengeliminasi elemen di bawah dan di atas elemen diagonal
            for ($j = 0; $j < $n; $j++) {
                if ($i != $j) {
                    $factor = $augmentedMatrix[$j][$i];
                    for ($k = 0; $k < 2 * $n; $k++) {
                        $augmentedMatrix[$j][$k] -= $augmentedMatrix[$i][$k] * $factor;
                    }
                }
            }
        }

        // Ambil matriks invers dari augmented matrix
        $inverseMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = $n; $j < 2 * $n; $j++) {
                $inverseMatrix[$i][$j - $n] = $augmentedMatrix[$i][$j];
            }
        }

        return $inverseMatrix;
    }

    // Fungsi untuk menggabungkan matriks dengan matriks identitas (augment matrix)
    private function augmentMatrix($matrix, $n)
    {
        $augmentedMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            $augmentedMatrix[$i] = array_merge($matrix[$i], array_fill(0, $n, 0));
            $augmentedMatrix[$i][$i + $n] = 1;  // Menambahkan identitas ke matriks
        }
        return $augmentedMatrix;
    }

    // Fungsi untuk menukar dua baris dalam matriks
    private function swapRows($matrix, $row1, $row2)
    {
        $temp = $matrix[$row1];
        $matrix[$row1] = $matrix[$row2];
        $matrix[$row2] = $temp;
        return $matrix;
    }
}
