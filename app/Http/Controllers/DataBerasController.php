<?php

namespace App\Http\Controllers;

use App\Models\DataBeras;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DataBerasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $dataBeras = DataBeras::all();
        return response()->json([
            'success' => true,
            'data' => $dataBeras
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'harga_beras_kualitas_bawah_i' => 'required|numeric|min:0',
            'harga_beras_kualitas_bawah_ii' => 'required|numeric|min:0',
            'harga_beras_kualitas_medium_i' => 'required|numeric|min:0',
            'harga_beras_kualitas_medium_ii' => 'required|numeric|min:0',
            'harga_beras_kualitas_super_i' => 'required|numeric|min:0',
            'harga_beras_kualitas_super_ii' => 'required|numeric|min:0',
            'inflasi_bi' => 'required|numeric',
            'kurs_usd' => 'required|numeric|min:0',
            'bbm_pertalite' => 'required|numeric|min:0',
            'ump_sulut' => 'required|numeric|min:0',
            'jumlah_penduduk' => 'required|numeric|min:0',
            'pupuk_subsidi' => 'required|numeric|min:0',
        ]);

        $dataBeras = DataBeras::create($validated);

        return response()->json([
            'success' => true,
            'data' => $dataBeras,
            'message' => 'Data created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DataBeras $dataBeras): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $dataBeras
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataBeras $dataBeras): JsonResponse
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'harga_beras_kualitas_bawah_i' => 'required|numeric|min:0',
            'harga_beras_kualitas_bawah_ii' => 'required|numeric|min:0',
            'harga_beras_kualitas_medium_i' => 'required|numeric|min:0',
            'harga_beras_kualitas_medium_ii' => 'required|numeric|min:0',
            'harga_beras_kualitas_super_i' => 'required|numeric|min:0',
            'harga_beras_kualitas_super_ii' => 'required|numeric|min:0',
            'inflasi_bi' => 'required|numeric',
            'kurs_usd' => 'required|numeric|min:0',
            'bbm_pertalite' => 'required|numeric|min:0',
            'ump_sulut' => 'required|numeric|min:0',
            'jumlah_penduduk' => 'required|numeric|min:0',
            'pupuk_subsidi' => 'required|numeric|min:0',
        ]);

        $dataBeras->update($validated);

        return response()->json([
            'success' => true,
            'data' => $dataBeras,
            'message' => 'Data updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataBeras $dataBeras): JsonResponse
    {
        $dataBeras->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }

    /**
     * Analyze data for linear regression prediction of rice prices.
     */
    public function analyze(Request $request): JsonResponse
    {
        // Fetch all data from the database
        $dataBeras = DataBeras::all();

        // Prepare data for analysis
        $cleanedData = [];
        foreach ($dataBeras as $data) {
            if (is_numeric($data->harga_beras_kualitas_bawah_i) &&
                is_numeric($data->harga_beras_kualitas_bawah_ii) &&
                is_numeric($data->harga_beras_kualitas_medium_i) &&
                is_numeric($data->harga_beras_kualitas_medium_ii) &&
                is_numeric($data->harga_beras_kualitas_super_i) &&
                is_numeric($data->harga_beras_kualitas_super_ii) &&
                is_numeric($data->inflasi_bi) &&
                is_numeric($data->kurs_usd) &&
                is_numeric($data->bbm_pertalite) &&
                is_numeric($data->ump_sulut) &&
                is_numeric($data->jumlah_penduduk) &&
                is_numeric($data->pupuk_subsidi)) {
                $cleanedData[] = [
                    'NO' => $data->id,
                    'HARGA_BERAS_KUALITAS_BAWAH_I' => $data->harga_beras_kualitas_bawah_i,
                    'HARGA_BERAS_KUALITAS_BAWAH_II' => $data->harga_beras_kualitas_bawah_ii,
                    'HARGA_BERAS_KUALITAS_MEDIUM_I' => $data->harga_beras_kualitas_medium_i,
                    'HARGA_BERAS_KUALITAS_MEDIUM_II' => $data->harga_beras_kualitas_medium_ii,
                    'HARGA_BERAS_KUALITAS_SUPER_I' => $data->harga_beras_kualitas_super_i,
                    'HARGA_BERAS_KUALITAS_SUPER_II' => $data->harga_beras_kualitas_super_ii,
                    'INFLASI_BI' => $data->inflasi_bi,
                    'KURS_USD' => $data->kurs_usd,
                    'BBM_PERTALITE' => $data->bbm_pertalite,
                    'UMP_SULUT' => $data->ump_sulut,
                    'JUMLAH_PENDUDUK' => $data->jumlah_penduduk,
                    'PUPUK_SUBSIDI' => $data->pupuk_subsidi,
                ];
            }
        }

        // Split into training (first 80%) and testing (last 20%) data
        $totalData = count($cleanedData);
        $trainingSize = (int)($totalData * 0.8);
        $trainingData = array_slice($cleanedData, 0, $trainingSize);
        $testingData = array_slice($cleanedData, $trainingSize);

        // Define rice price categories
        $priceCategories = [
            'HARGA_BERAS_KUALITAS_BAWAH_I',
            'HARGA_BERAS_KUALITAS_BAWAH_II',
            'HARGA_BERAS_KUALITAS_MEDIUM_I',
            'HARGA_BERAS_KUALITAS_MEDIUM_II',
            'HARGA_BERAS_KUALITAS_SUPER_I',
            'HARGA_BERAS_KUALITAS_SUPER_II',
        ];

        $results = [];
        foreach ($priceCategories as $priceCategory) {
            // Prepare training data
            $X_train = array_map(function($row) {
                return [
                    $row['INFLASI_BI'],
                    $row['KURS_USD'],
                    $row['BBM_PERTALITE'],
                    $row['UMP_SULUT'],
                    $row['JUMLAH_PENDUDUK'],
                    $row['PUPUK_SUBSIDI']
                ];
            }, $trainingData);
            $Y_train = array_column($trainingData, $priceCategory);
            $Y_train = array_map(function($item) {
                return [$item];
            }, $Y_train);

            // Prepare testing data
            $X_test = array_map(function($row) {
                return [
                    $row['INFLASI_BI'],
                    $row['KURS_USD'],
                    $row['BBM_PERTALITE'],
                    $row['UMP_SULUT'],
                    $row['JUMLAH_PENDUDUK'],
                    $row['PUPUK_SUBSIDI']
                ];
            }, $testingData);
            $Y_test = array_column($testingData, $priceCategory);

            // Add intercept column
            $X_train_with_const = array_map(function($row) {
                return array_merge([1], $row);
            }, $X_train);
            $X_test_with_const = array_map(function($row) {
                return array_merge([1], $row);
            }, $X_test);

            // Calculate coefficients
            $A = $this->matrixMultiply($this->transpose($X_train_with_const), $X_train_with_const);
            $B = $this->matrixMultiply($this->transpose($X_train_with_const), $Y_train);
            $b = $this->matrixMultiply($this->inverse($A), $B);

            // Build regression equation
            $regressionEquation = "Y = " . number_format($b[0][0], 2);
            $variables = ['INFLASI_BI', 'KURS_USD', 'BBM_PERTALITE', 'UMP_SULUT', 'JUMLAH_PENDUDUK', 'PUPUK_SUBSIDI'];
            foreach ($variables as $i => $var) {
                $regressionEquation .= " + (" . number_format($b[$i + 1][0], 2) . " * {$var})";
            }

            // Predict for testing data
            $predictedPrices = array_map(function($row) use ($b) {
                return $this->matrixMultiply([$row], $b)[0][0];
            }, $X_test_with_const);

            // Calculate MAPE
            $mape = array_sum(array_map(function($actual, $predicted) {
                    return abs(($actual - $predicted) / ($actual ?: 1)) * 100;
                }, $Y_test, $predictedPrices)) / (count($Y_test) ?: 1);

            // Calculate RMSE
            $rmse = sqrt(array_sum(array_map(function($actual, $predicted) {
                    return pow($actual - $predicted, 2);
                }, $Y_test, $predictedPrices)) / (count($Y_test) ?: 1));

            $results[$priceCategory] = [
                'regression_equation' => $regressionEquation,
                'predicted_prices' => array_map(function($price) {
                    return number_format($price, 2);
                }, $predictedPrices),
                'actual_prices' => array_map(function($price) {
                    return number_format($price, 2);
                }, $Y_test),
                'mape' => number_format(100 - $mape, 2),
                'rmse' => number_format($rmse, 2),
            ];
        }

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }

    /**
     * Calculate regression coefficients using all data.
     */
    public function calculateCoefficients()
    {
        // Fetch all data from the database
        $dataBeras = DataBeras::all();

        // Check if there's enough data
        if ($dataBeras->count() < 7) {
            return view('prediksi_harga.analyze', [
                'results' => null,
                'error' => 'Insufficient data: At least 7 records are required.'
            ]);
        }

        // Prepare data for analysis
        $cleanedData = [];
        $dates = [];
        foreach ($dataBeras as $data) {
            if (is_numeric($data->harga_beras_kualitas_bawah_i) &&
                is_numeric($data->harga_beras_kualitas_bawah_ii) &&
                is_numeric($data->harga_beras_kualitas_medium_i) &&
                is_numeric($data->harga_beras_kualitas_medium_ii) &&
                is_numeric($data->harga_beras_kualitas_super_i) &&
                is_numeric($data->harga_beras_kualitas_super_ii) &&
                is_numeric($data->inflasi_bi) &&
                is_numeric($data->kurs_usd) &&
                is_numeric($data->bbm_pertalite) &&
                is_numeric($data->ump_sulut) &&
                is_numeric($data->jumlah_penduduk) &&
                is_numeric($data->pupuk_subsidi)) {
                $cleanedData[] = [
                    'NO' => $data->id,
                    'TANGGAL' => $data->tanggal,
                    'HARGA_BERAS_KUALITAS_BAWAH_I' => $data->harga_beras_kualitas_bawah_i,
                    'HARGA_BERAS_KUALITAS_BAWAH_II' => $data->harga_beras_kualitas_bawah_ii,
                    'HARGA_BERAS_KUALITAS_MEDIUM_I' => $data->harga_beras_kualitas_medium_i,
                    'HARGA_BERAS_KUALITAS_MEDIUM_II' => $data->harga_beras_kualitas_medium_ii,
                    'HARGA_BERAS_KUALITAS_SUPER_I' => $data->harga_beras_kualitas_super_i,
                    'HARGA_BERAS_KUALITAS_SUPER_II' => $data->harga_beras_kualitas_super_ii,
                    'INFLASI_BI' => $data->inflasi_bi,
                    'KURS_USD' => $data->kurs_usd,
                    'BBM_PERTALITE' => $data->bbm_pertalite,
                    'UMP_SULUT' => $data->ump_sulut,
                    'JUMLAH_PENDUDUK' => $data->jumlah_penduduk,
                    'PUPUK_SUBSIDI' => $data->pupuk_subsidi,
                ];
                $dates[] = \Carbon\Carbon::parse($data->tanggal)->format('Y-m');
            }
        }

        // Check if cleaned data is empty
        if (empty($cleanedData)) {
            return view('prediksi_harga.analyze', [
                'results' => null,
                'error' => 'No valid data found after cleaning.'
            ]);
        }

        // Define rice price categories
        $priceCategories = [
            'HARGA_BERAS_KUALITAS_BAWAH_I',
            'HARGA_BERAS_KUALITAS_BAWAH_II',
            'HARGA_BERAS_KUALITAS_MEDIUM_I',
            'HARGA_BERAS_KUALITAS_MEDIUM_II',
            'HARGA_BERAS_KUALITAS_SUPER_I',
            'HARGA_BERAS_KUALITAS_SUPER_II',
        ];

        $results = [];
        foreach ($priceCategories as $priceCategory) {
            // Prepare data (use all data)
            $X = array_map(function($row) {
                return [
                    $row['INFLASI_BI'],
                    $row['KURS_USD'],
                    $row['BBM_PERTALITE'],
                    $row['UMP_SULUT'],
                    $row['JUMLAH_PENDUDUK'],
                    $row['PUPUK_SUBSIDI']
                ];
            }, $cleanedData);
            $Y = array_column($cleanedData, $priceCategory);
            $Y = array_map(function($item) {
                return [$item];
            }, $Y);

            // Add intercept column
            $X_with_const = array_map(function($row) {
                return array_merge([1], $row);
            }, $X);

            // Calculate coefficients
            try {
                $A = $this->matrixMultiply($this->transpose($X_with_const), $X_with_const);
                $B = $this->matrixMultiply($this->transpose($X_with_const), $Y);
                $b = $this->matrixMultiply($this->inverse($A), $B);
            } catch (\Exception $e) {
                return view('prediksi_harga.analyze', [
                    'results' => null,
                    'error' => 'Error calculating coefficients: ' . $e->getMessage()
                ]);
            }

            // Build regression equation
            $regressionEquation = "Y = " . number_format($b[0][0], 4);
            $variables = ['INFLASI_BI', 'KURS_USD', 'BBM_PERTALITE', 'UMP_SULUT', 'JUMLAH_PENDUDUK', 'PUPUK_SUBSIDI'];
            foreach ($variables as $i => $var) {
                $regressionEquation .= " + (" . number_format($b[$i + 1][0], 4) . " * {$var})";
            }

            // Calculate predicted prices for all data
            $predictedPrices = array_map(function($row) use ($b) {
                return $this->matrixMultiply([$row], $b)[0][0];
            }, $X_with_const);

            // Calculate MAPE and RMSE
            $actual = array_column($cleanedData, $priceCategory);
            $mape = array_sum(array_map(function($actual, $predicted) {
                    return abs(($actual - $predicted) / ($actual ?: 1)) * 100;
                }, $actual, $predictedPrices)) / (count($actual) ?: 1);
            $rmse = sqrt(array_sum(array_map(function($actual, $predicted) {
                    return pow($actual - $predicted, 2);
                }, $actual, $predictedPrices)) / (count($actual) ?: 1));

            $results[$priceCategory] = [
                'regression_equation' => $regressionEquation,
                'coefficients' => array_map(function($coef) {
                    return number_format($coef[0], 4);
                }, $b),
                'predicted_prices' => array_map(function($price) {
                    return number_format($price, 2);
                }, $predictedPrices),
                'actual_prices' => array_map(function($price) {
                    return number_format($price, 2);
                }, array_column($cleanedData, $priceCategory)),
                'dates' => $dates,
                'mape' => number_format($mape, 2),
                'rmse' => number_format($rmse, 2),
                'data' => $cleanedData,
            ];
        }

        return view('prediksi_harga.analyze', ['results' => $results]);
    }

    /**
     * Display manual calculation table for a specific price category, including coefficient derivation.
     */
    public function manualCalculation($category)
    {
        // Validate category
        $validCategories = [
            'HARGA_BERAS_KUALITAS_BAWAH_I',
            'HARGA_BERAS_KUALITAS_BAWAH_II',
            'HARGA_BERAS_KUALITAS_MEDIUM_I',
            'HARGA_BERAS_KUALITAS_MEDIUM_II',
            'HARGA_BERAS_KUALITAS_SUPER_I',
            'HARGA_BERAS_KUALITAS_SUPER_II',
        ];

        if (!in_array($category, $validCategories)) {
            return redirect()->route('calculate.coefficients')->with('error', 'Invalid price category');
        }

        // Fetch all data from the database
        $dataBeras = DataBeras::all();

        // Check if there's enough data
        if ($dataBeras->count() < 7) {
            return redirect()->route('calculate.coefficients')->with('error', 'Insufficient data: At least 7 records are required.');
        }

        // Prepare data for analysis
        $cleanedData = [];
        $dates = [];
        foreach ($dataBeras as $data) {
            if (is_numeric($data->harga_beras_kualitas_bawah_i) &&
                is_numeric($data->harga_beras_kualitas_bawah_ii) &&
                is_numeric($data->harga_beras_kualitas_medium_i) &&
                is_numeric($data->harga_beras_kualitas_medium_ii) &&
                is_numeric($data->harga_beras_kualitas_super_i) &&
                is_numeric($data->harga_beras_kualitas_super_ii) &&
                is_numeric($data->inflasi_bi) &&
                is_numeric($data->kurs_usd) &&
                is_numeric($data->bbm_pertalite) &&
                is_numeric($data->ump_sulut) &&
                is_numeric($data->jumlah_penduduk) &&
                is_numeric($data->pupuk_subsidi)) {
                $cleanedData[] = [
                    'NO' => $data->id,
                    'TANGGAL' => \Carbon\Carbon::parse($data->tanggal)->format('F-Y'),
                    'HARGA_BERAS_KUALITAS_BAWAH_I' => $data->harga_beras_kualitas_bawah_i,
                    'HARGA_BERAS_KUALITAS_BAWAH_II' => $data->harga_beras_kualitas_bawah_ii,
                    'HARGA_BERAS_KUALITAS_MEDIUM_I' => $data->harga_beras_kualitas_medium_i,
                    'HARGA_BERAS_KUALITAS_MEDIUM_II' => $data->harga_beras_kualitas_medium_ii,
                    'HARGA_BERAS_KUALITAS_SUPER_I' => $data->harga_beras_kualitas_super_i,
                    'HARGA_BERAS_KUALITAS_SUPER_II' => $data->harga_beras_kualitas_super_ii,
                    'INFLASI_BI' => $data->inflasi_bi,
                    'KURS_USD' => $data->kurs_usd,
                    'BBM_PERTALITE' => $data->bbm_pertalite,
                    'UMP_SULUT' => $data->ump_sulut,
                    'JUMLAH_PENDUDUK' => $data->jumlah_penduduk,
                    'PUPUK_SUBSIDI' => $data->pupuk_subsidi,
                ];
                $dates[] = \Carbon\Carbon::parse($data->tanggal)->format('Y-m');
            }
        }

        // Check if cleaned data is empty
        if (empty($cleanedData)) {
            return redirect()->route('calculate.coefficients')->with('error', 'No valid data found for manual calculation');
        }

        // Prepare data for the selected category
        $X = array_map(function($row) {
            return [
                $row['INFLASI_BI'],
                $row['KURS_USD'],
                $row['BBM_PERTALITE'],
                $row['UMP_SULUT'],
                $row['JUMLAH_PENDUDUK'],
                $row['PUPUK_SUBSIDI']
            ];
        }, $cleanedData);
        $Y = array_column($cleanedData, $category);
        $Y = array_map(function($item) {
            return [$item];
        }, $Y);

        // Calculate sums for numerical columns before formatting
        $data_sums = [
            'Y' => array_sum(array_column($cleanedData, $category)),
            'X1' => array_sum(array_column($cleanedData, 'INFLASI_BI')),
            'X2' => array_sum(array_column($cleanedData, 'KURS_USD')),
            'X3' => array_sum(array_column($cleanedData, 'BBM_PERTALITE')),
            'X4' => array_sum(array_column($cleanedData, 'UMP_SULUT')),
            'X5' => array_sum(array_column($cleanedData, 'JUMLAH_PENDUDUK')),
            'X6' => array_sum(array_column($cleanedData, 'PUPUK_SUBSIDI')),
        ];

        // Add intercept column
        $X_with_const = array_map(function($row) {
            return array_merge([1], $row);
        }, $X);

        // Calculate pairwise products and squares for step 2
        $pairwiseCalculations = [];
        foreach ($cleanedData as $index => $row) {
            $pairwiseCalculations[] = [
                'X1Y' => $row['INFLASI_BI'] * $row[$category],
                'X2Y' => $row['KURS_USD'] * $row[$category],
                'X3Y' => $row['BBM_PERTALITE'] * $row[$category],
                'X4Y' => $row['UMP_SULUT'] * $row[$category],
                'X5Y' => $row['JUMLAH_PENDUDUK'] * $row[$category],
                'X6Y' => $row['PUPUK_SUBSIDI'] * $row[$category],
                'X1X2' => $row['INFLASI_BI'] * $row['KURS_USD'],
                'X1X3' => $row['INFLASI_BI'] * $row['BBM_PERTALITE'],
                'X1X4' => $row['INFLASI_BI'] * $row['UMP_SULUT'],
                'X1X5' => $row['INFLASI_BI'] * $row['JUMLAH_PENDUDUK'],
                'X1X6' => $row['INFLASI_BI'] * $row['PUPUK_SUBSIDI'],
                'X2X3' => $row['KURS_USD'] * $row['BBM_PERTALITE'],
                'X2X4' => $row['KURS_USD'] * $row['UMP_SULUT'],
                'X2X5' => $row['KURS_USD'] * $row['JUMLAH_PENDUDUK'],
                'X2X6' => $row['KURS_USD'] * $row['PUPUK_SUBSIDI'],
                'X3X4' => $row['BBM_PERTALITE'] * $row['UMP_SULUT'],
                'X3X5' => $row['BBM_PERTALITE'] * $row['JUMLAH_PENDUDUK'],
                'X3X6' => $row['BBM_PERTALITE'] * $row['PUPUK_SUBSIDI'],
                'X4X5' => $row['UMP_SULUT'] * $row['JUMLAH_PENDUDUK'],
                'X4X6' => $row['UMP_SULUT'] * $row['PUPUK_SUBSIDI'],
                'X5X6' => $row['JUMLAH_PENDUDUK'] * $row['PUPUK_SUBSIDI'],
                'X1_2' => $row['INFLASI_BI'] * $row['INFLASI_BI'],
                'X2_2' => $row['KURS_USD'] * $row['KURS_USD'],
                'X3_2' => $row['BBM_PERTALITE'] * $row['BBM_PERTALITE'],
                'X4_2' => $row['UMP_SULUT'] * $row['UMP_SULUT'],
                'X5_2' => $row['JUMLAH_PENDUDUK'] * $row['JUMLAH_PENDUDUK'],
                'X6_2' => $row['PUPUK_SUBSIDI'] * $row['PUPUK_SUBSIDI'],
            ];
        }

        // Calculate sums for matrix A (X^T X)
        $X_with_const = array_map(function($row) {
            return array_merge([1], $row);
        }, $X);
        $X_transpose = $this->transpose($X_with_const);
        $A = $this->matrixMultiply($X_transpose, $X_with_const);
        $B = $this->matrixMultiply($X_transpose, $Y);

        // Calculate matrix H (X^T Y)
        $matrix_h = [
            $data_sums['Y'],
            $pairwiseSums['X1Y'] ?? array_sum(array_column($pairwiseCalculations, 'X1Y')),
            $pairwiseSums['X2Y'] ?? array_sum(array_column($pairwiseCalculations, 'X2Y')),
            $pairwiseSums['X3Y'] ?? array_sum(array_column($pairwiseCalculations, 'X3Y')),
            $pairwiseSums['X4Y'] ?? array_sum(array_column($pairwiseCalculations, 'X4Y')),
            $pairwiseSums['X5Y'] ?? array_sum(array_column($pairwiseCalculations, 'X5Y')),
            $pairwiseSums['X6Y'] ?? array_sum(array_column($pairwiseCalculations, 'X6Y')),
        ];

        // Format matrix H for display
        $matrix_h_formatted = array_map(function($value) {
            return number_format($value, 0);
        }, $matrix_h);

        // Calculate matrices A_i for Cramer's rule
        $A_matrices = [];
        for ($i = 0; $i < 7; $i++) {
            $A_i = $A;
            for ($j = 0; $j < 7; $j++) {
                $A_i[$j][$i] = $B[$j][0];
            }
            $A_matrices[$i] = $A_i;
        }

        // Calculate determinants
        try {
            $det_A = $this->determinant($A);
            $det_Ai = array_map(function($A_i) {
                return $this->determinant($A_i);
            }, $A_matrices);

            // Calculate coefficients using Cramer's rule
            $b = array_map(function($det_Ai, $index) use ($det_A) {
                return $det_A != 0 ? $det_Ai / $det_A : 0;
            }, $det_Ai, array_keys($det_Ai));
        } catch (\Exception $e) {
            return redirect()->route('calculate.coefficients')->with('error', 'Error calculating coefficients: ' . $e->getMessage());
        }

        // Build regression equation
        $regressionEquation = "Y = " . number_format($b[0], 6);
        $variables = ['INFLASI_BI', 'KURS_USD', 'BBM_PERTALITE', 'UMP_SULUT', 'JUMLAH_PENDUDUK', 'PUPUK_SUBSIDI'];
        foreach ($variables as $i => $var) {
            $regressionEquation .= " + (" . number_format($b[$i + 1], 6) . " * {$var})";
        }

        // Calculate predicted prices
        $predictedPrices = array_map(function($row) use ($b) {
            return $b[0] + $b[1] * $row[0] + $b[2] * $row[1] + $b[3] * $row[2] +
                $b[4] * $row[3] + $b[5] * $row[4] + $b[6] * $row[5];
        }, $X);

        // Calculate MAPE and RMSE
        $actual = array_column($cleanedData, $category);
        $mape = array_sum(array_map(function($actual, $predicted) {
                return abs(($actual - $predicted) / ($actual ?: 1)) * 100;
            }, $actual, $predictedPrices)) / (count($actual) ?: 1);
        $rmse = sqrt(array_sum(array_map(function($actual, $predicted) {
                return pow($actual - $predicted, 2);
            }, $actual, $predictedPrices)) / (count($actual) ?: 1));

        // Format data for view
        $dataTable = array_map(function($row, $index) use ($category, $dates) {
            return [
                'NO' => $row['NO'],
                'TANGGAL' => $row['TANGGAL'],
                'Y' => number_format($row[$category], 2),
                'X1' => number_format($row['INFLASI_BI'], 2),
                'X2' => number_format($row['KURS_USD'], 2),
                'X3' => number_format($row['BBM_PERTALITE'], 2),
                'X4' => number_format($row['UMP_SULUT'], 2),
                'X5' => number_format($row['JUMLAH_PENDUDUK'], 2),
                'X6' => number_format($row['PUPUK_SUBSIDI'], 2),
            ];
        }, $cleanedData, array_keys($cleanedData));

        $pairwiseSums = [];
        foreach ($pairwiseCalculations[0] as $key => $value) {
            $pairwiseSums[$key] = array_sum(array_column($pairwiseCalculations, $key));
        }

        // Format matrices and determinants
        $A_formatted = array_map(function($row) {
            return array_map(function($value) {
                return number_format($value, 0);
            }, $row);
        }, $A);
        $A_matrices_formatted = array_map(function($matrix) {
            return array_map(function($row) {
                return array_map(function($value) {
                    return number_format($value, 0);
                }, $row);
            }, $matrix);
        }, $A_matrices);

        $det_A_formatted = sprintf('%.5E', $det_A);
        $det_Ai_formatted = array_map(function($det) {
            return sprintf('%.5E', $det);
        }, $det_Ai);

        $coefficients = array_map(function($coef) {
            return number_format($coef, 6);
        }, $b);

        $predictedPricesFormatted = array_map(function($price) {
            return number_format($price, 5);
        }, $predictedPrices);

        // Format sums for display
        $data_sums_formatted = array_map(function($sum) {
            return number_format($sum, 2);
        }, $data_sums);

        return view('prediksi_harga.manual_calculation', [
            'category' => $category,
            'regression_equation' => $regressionEquation,
            'coefficients' => $coefficients,
            'data_table' => $dataTable,
            'pairwise_calculations' => $pairwiseCalculations,
            'pairwise_sums' => $pairwiseSums,
            'A_matrix' => $A_formatted,
            'A_matrices' => $A_matrices_formatted,
            'det_A' => $det_A_formatted,
            'det_Ai' => $det_Ai_formatted,
            'predicted_prices' => $predictedPricesFormatted,
            'mape' => number_format($mape, 2),
            'rmse' => number_format($rmse, 2),
            'data_sums' => $data_sums_formatted,
            'matrix_h' => $matrix_h_formatted,
        ]);
    }

    /**
     * Matrix multiplication.
     */
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

    /**
     * Transpose a matrix.
     */
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

    /**
     * Calculate determinant of a matrix using Laplace expansion.
     */
    private function determinant($matrix)
    {
        $n = count($matrix);
        if ($n == 1) {
            return $matrix[0][0];
        }
        if ($n == 2) {
            return $matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0];
        }

        $det = 0;
        for ($j = 0; $j < $n; $j++) {
            $det += ($j % 2 == 0 ? 1 : -1) * $matrix[0][$j] * $this->determinant($this->getMinor($matrix, 0, $j));
        }
        return $det;
    }

    /**
     * Get minor matrix by removing row $i and column $j.
     */
    private function getMinor($matrix, $row, $col)
    {
        $minor = [];
        $n = count($matrix);
        $r = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($i == $row) continue;
            $minor[$r] = [];
            $c = 0;
            for ($j = 0; $j < $n; $j++) {
                if ($j == $col) continue;
                $minor[$r][$c] = $matrix[$i][$j];
                $c++;
            }
            $r++;
        }
        return $minor;
    }

    /**
     * Calculate inverse matrix using Gauss-Jordan elimination.
     */
    private function inverse($matrix)
    {
        $n = count($matrix);
        $augmentedMatrix = $this->augmentMatrix($matrix, $n);

        for ($i = 0; $i < $n; $i++) {
            if ($augmentedMatrix[$i][$i] == 0) {
                for ($j = $i + 1; $j < $n; $j++) {
                    if ($augmentedMatrix[$j][$i] != 0) {
                        $augmentedMatrix = $this->swapRows($augmentedMatrix, $i, $j);
                        break;
                    }
                }
            }

            $factor = $augmentedMatrix[$i][$i];
            if ($factor == 0) {
                throw new \Exception('Matrix is singular or nearly singular');
            }

            for ($k = 0; $k < 2 * $n; $k++) {
                $augmentedMatrix[$i][$k] /= $factor;
            }

            for ($j = 0; $j < $n; $j++) {
                if ($i != $j) {
                    $factor = $augmentedMatrix[$j][$i];
                    for ($k = 0; $k < 2 * $n; $k++) {
                        $augmentedMatrix[$j][$k] -= $augmentedMatrix[$i][$k] * $factor;
                    }
                }
            }
        }

        $inverseMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = $n; $j < 2 * $n; $j++) {
                $inverseMatrix[$i][$j - $n] = $augmentedMatrix[$i][$j];
            }
        }

        return $inverseMatrix;
    }

    /**
     * Augment matrix with identity matrix.
     */
    private function augmentMatrix($matrix, $n)
    {
        $augmentedMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            $augmentedMatrix[$i] = array_merge($matrix[$i], array_fill(0, $n, 0));
            $augmentedMatrix[$i][$i + $n] = 1;
        }
        return $augmentedMatrix;
    }

    /**
     * Swap two rows in a matrix.
     */
    private function swapRows($matrix, $row1, $row2)
    {
        $temp = $matrix[$row1];
        $matrix[$row1] = $matrix[$row2];
        $matrix[$row2] = $temp;
        return $matrix;
    }
}
