@extends('layouts.main')
@section('title', 'Manual Calculation - ' . str_replace('HARGA_BERAS_KUALITAS_', '', $category))
@section('container')
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">Perhitungan Manual - Harga Beras Kualitas
                    {{ str_replace('HARGA_BERAS_KUALITAS_', '', $category) }}</h2>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('account.settings') }}">⚙️ Akun</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <div class="row my-3">
                <a href="{{ route('calculate.coefficients') }}" class="btn btn-secondary mb-3">Kembali</a>
                <h4>Perhitungan Manual untuk Prediksi Harga Beras Kualitas
                    {{ str_replace('HARGA_BERAS_KUALITAS_', '', $category) }}</h4>
                <p><strong>Persamaan Regresi:</strong> {{ $regression_equation }}</p>
                <p><strong>MAE:</strong> {{ $mae }}</p>
                <p><strong>RMSE:</strong> {{ $rmse }}</p>
                <p><strong>MAPE:</strong> {{ $mape }}%</p>

                <!-- Step 1: Data Table -->
                <h5>1. Data</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>HARGA BERAS KUALITAS {{ str_replace('HARGA_BERAS_KUALITAS_', '', $category) }} (PER KG)
                            </th>
                            <th>INFLASI (BI)</th>
                            <th>KURS USD</th>
                            <th>BBM (PERTALITE)</th>
                            <th>UMP SULUT</th>
                            <th>JUMLAH PENDUDUK</th>
                            <th>PUPUK SUBSIDI</th>
                        </tr>
                        <tr>
                            <th>i</th>
                            <th></th>
                            <th>Y</th>
                            <th>X1</th>
                            <th>X2</th>
                            <th>X3</th>
                            <th>X4</th>
                            <th>X5</th>
                            <th>X6</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data_table as $row)
                            <tr>
                                <td>{{ $row['NO'] }}</td>
                                <td>{{ $row['TANGGAL'] }}</td>
                                <td>{{ $row['Y'] }}</td>
                                <td>{{ $row['X1'] }}</td>
                                <td>{{ $row['X2'] }}</td>
                                <td>{{ $row['X3'] }}</td>
                                <td>{{ $row['X4'] }}</td>
                                <td>{{ $row['X5'] }}</td>
                                <td>{{ $row['X6'] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td><strong>Sum</strong></td>
                            <td><strong>{{ $data_sums['Y'] }}</strong></td>
                            <td><strong>{{ $data_sums['X1'] }}</strong></td>
                            <td><strong>{{ $data_sums['X2'] }}</strong></td>
                            <td><strong>{{ $data_sums['X3'] }}</strong></td>
                            <td><strong>{{ $data_sums['X4'] }}</strong></td>
                            <td><strong>{{ $data_sums['X5'] }}</strong></td>
                            <td><strong>{{ $data_sums['X6'] }}</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Step 2: Pairwise Products and Squares -->
                <h5>2. Produk Berpasangan dan Kuadrat</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>X1Y</th>
                            <th>X2Y</th>
                            <th>X3Y</th>
                            <th>X4Y</th>
                            <th>X5Y</th>
                            <th>X6Y</th>
                            <th>X1X2</th>
                            <th>X1X3</th>
                            <th>X1X4</th>
                            <th>X1X5</th>
                            <th>X1X6</th>
                            <th>X2X3</th>
                            <th>X2X4</th>
                            <th>X2X5</th>
                            <th>X2X6</th>
                            <th>X3X4</th>
                            <th>X3X5</th>
                            <th>X3X6</th>
                            <th>X4X5</th>
                            <th>X4X6</th>
                            <th>X5X6</th>
                            <th>X1^2</th>
                            <th>X2^2</th>
                            <th>X3^2</th>
                            <th>X4^2</th>
                            <th>X5^2</th>
                            <th>X6^2</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pairwise_calculations as $row)
                            <tr>
                                <td>{{ number_format($row['X1Y'], 2) }}</td>
                                <td>{{ number_format($row['X2Y'], 2) }}</td>
                                <td>{{ number_format($row['X3Y'], 2) }}</td>
                                <td>{{ number_format($row['X4Y'], 2) }}</td>
                                <td>{{ number_format($row['X5Y'], 2) }}</td>
                                <td>{{ number_format($row['X6Y'], 2) }}</td>
                                <td>{{ number_format($row['X1X2'], 2) }}</td>
                                <td>{{ number_format($row['X1X3'], 2) }}</td>
                                <td>{{ number_format($row['X1X4'], 2) }}</td>
                                <td>{{ number_format($row['X1X5'], 2) }}</td>
                                <td>{{ number_format($row['X1X6'], 2) }}</td>
                                <td>{{ number_format($row['X2X3'], 2) }}</td>
                                <td>{{ number_format($row['X2X4'], 2) }}</td>
                                <td>{{ number_format($row['X2X5'], 2) }}</td>
                                <td>{{ number_format($row['X2X6'], 2) }}</td>
                                <td>{{ number_format($row['X3X4'], 2) }}</td>
                                <td>{{ number_format($row['X3X5'], 2) }}</td>
                                <td>{{ number_format($row['X3X6'], 2) }}</td>
                                <td>{{ number_format($row['X4X5'], 2) }}</td>
                                <td>{{ number_format($row['X4X6'], 2) }}</td>
                                <td>{{ number_format($row['X5X6'], 2) }}</td>
                                <td>{{ number_format($row['X1_2'], 4) }}</td>
                                <td>{{ number_format($row['X2_2'], 4) }}</td>
                                <td>{{ number_format($row['X3_2'], 4) }}</td>
                                <td>{{ number_format($row['X4_2'], 4) }}</td>
                                <td>{{ number_format($row['X5_2'], 4) }}</td>
                                <td>{{ number_format($row['X6_2'], 4) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>{{ number_format($pairwise_sums['X1Y'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X2Y'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X3Y'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X4Y'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X5Y'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X6Y'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X1X2'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X1X3'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X1X4'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X1X5'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X1X6'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X2X3'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X2X4'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X2X5'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X2X6'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X3X4'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X3X5'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X3X6'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X4X5'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X4X6'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X5X6'], 2) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X1_2'], 4) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X2_2'], 4) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X3_2'], 4) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X4_2'], 4) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X5_2'], 4) }}</strong></td>
                            <td><strong>{{ number_format($pairwise_sums['X6_2'], 4) }}</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Matrix H -->
                <h5>3. Matriks H</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Variable</th>
                            <th>Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (['Y', 'X1Y', 'X2Y', 'X3Y', 'X4Y', 'X5Y', 'X6Y'] as $index => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ $matrix_h[$index] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Step 4: Matrices A through A7 -->
                <h5>4. Matriks A</h5>
                @foreach (['A' => $A_matrix] + array_combine(range(1, 7), $A_matrices) as $matrix_name => $matrix)
                    @if ($matrix_name === 'A')
                        <h6>Matriks {{ $matrix_name }}</h6>
                    @else
                        <h6>Matriks A{{ $matrix_name }}</h6>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Intercept</th>
                                <th>X1</th>
                                <th>X2</th>
                                <th>X3</th>
                                <th>X4</th>
                                <th>X5</th>
                                <th>X6</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($matrix as $index => $row)
                                <tr>
                                    <td>{{ $index == 0 ? 'Intercept' : ($index == 1 ? 'X1' : ($index == 2 ? 'X2' : ($index == 3 ? 'X3' : ($index == 4 ? 'X4' : ($index == 5 ? 'X5' : 'X6'))))) }}
                                    </td>
                                    @foreach ($row as $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <!-- Step 5: Determinants -->
                <h5>5. Determinan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Matrix</th>
                            <th>Determinant</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>DET A</td>
                            <td>{{ $det_A }}</td>
                        </tr>
                        @foreach ($det_Ai as $index => $det)
                            <tr>
                                <td>DET A{{ $index + 1 }}</td>
                                <td>{{ $det }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Step 6: Coefficients -->
                <h5>6. Koefisien</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Coefficient</th>
                            <th>Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($coefficients as $index => $coef)
                            <tr>
                                <td>{{ $index == 0 ? 'b0 (det A1/det A)' : 'b' . $index . ' (det A' . ($index + 1) . '/det A)' }}
                                </td>
                                <td>{{ $coef }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Step 7: Predicted Prices -->
                <h5>7. Prediksi Harga</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th title="Intercept">b0</th>
                            <th>+</th>
                            <th title="Inflasi BI">b1*X1</th>
                            <th>+</th>
                            <th title="Kurs USD">b2*X2</th>
                            <th>+</th>
                            <th title="BBM Pertalite">b3*X3</th>
                            <th>+</th>
                            <th title="UMP Sulut">b4*X4</th>
                            <th>+</th>
                            <th title="Jumlah Penduduk">b5*X5</th>
                            <th>+</th>
                            <th title="Pupuk Subsidi">b6*X6</th>
                            <th>=</th>
                            <th>Hasil (Y Predicted)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data_table as $index => $row)
                            <tr>
                                <td>{{ $row['NO'] }}</td>
                                <td>{{ $row['TANGGAL'] }}</td>
                                <td>{{ $regression_terms[$index]['b0'] }}</td>
                                <td>+</td>
                                <td>{{ $regression_terms[$index]['b1X1'] }}</td>
                                <td>+</td>
                                <td>{{ $regression_terms[$index]['b2X2'] }}</td>
                                <td>+</td>
                                <td>{{ $regression_terms[$index]['b3X3'] }}</td>
                                <td>+</td>
                                <td>{{ $regression_terms[$index]['b4X4'] }}</td>
                                <td>+</td>
                                <td>{{ $regression_terms[$index]['b5X5'] }}</td>
                                <td>+</td>
                                <td>{{ $regression_terms[$index]['b6X6'] }}</td>
                                <td>=</td>
                                <td>{{ $predicted_prices[$index] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                </div>
                <h5 class="mt-3">8. Perbandingan Harga Aktual dan Prediksi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>Y AKTUAL</th>
                            <th>Y PREDICTED</th>
                            <th>Y RESIDUAL (𝑦ᵢ − ŷᵢ)</th>
                            <th>|𝑦ᵢ − ŷᵢ|</th>
                            <th>(𝑦ᵢ − ŷᵢ)^2</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sum_abs_diff = 0;
                            $sum_sq_diff = 0;
                            $sum_mape_numerator = 0;
                            $mape_count = 0;
                        @endphp
                        @foreach ($data_table as $index => $row)
                            @php
                                $actual_price = (float) str_replace(',', '', $row['Y']);
                                $predicted_price = (float) str_replace(',', '', $predicted_prices[$index]);
                                $residual = $actual_price - $predicted_price;
                                $abs_diff = abs($residual);
                                $sq_diff = pow($residual, 2);

                                $sum_abs_diff += $abs_diff;
                                $sum_sq_diff += $sq_diff;

                                if ($actual_price != 0) {
                                    $sum_mape_numerator += $abs_diff / $actual_price;
                                    $mape_count++;
                                }
                            @endphp
                            <tr>
                                <td>{{ $row['NO'] }}</td>
                                <td>{{ $row['TANGGAL'] }}</td>
                                <td>{{ $row['Y'] }}</td>
                                <td>{{ $predicted_prices[$index] }}</td>
                                <td>{{ number_format($residual, 2) }}</td>
                                <td>{{ number_format($abs_diff, 2) }}</td>
                                <td>{{ number_format($sq_diff, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"><strong>Sum</strong></td>
                            <td></td>
                            <td><strong>{{ number_format($sum_abs_diff, 2) }}</strong></td>
                            <td><strong>{{ number_format($sum_sq_diff, 2) }}</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="mt-3">9. Perhitungan Metrik Evaluasi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Metrik</th>
                            <th>Rumus</th>
                            <th>Perhitungan</th>
                            <th>Hasil</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Metrik</th>
                            <th>Rumus</th>
                            <th>Perhitungan</th>
                            <th>Hasil</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>MAE (Mean Absolute Error)</td>
                            <td>1/n ∑|yᵢ - ŷᵢ|</td>
                            <td>1/{{ count($data_table) }} × {{ number_format($sum_abs_diff, 2) }}</td>
                            <td>{{ $mae }}</td>
                        </tr>
                        <tr>
                            <td>RMSE (Root Mean Squared Error)</td>
                            <td>√((1/n) ∑(yᵢ - ŷᵢ)²)</td>
                            <td>√((1/{{ count($data_table) }}) × {{ number_format($sum_sq_diff, 2) }})</td>
                            <td>{{ $rmse }}</td>
                        </tr>
                        <tr>
                            <td>MAPE (Mean Absolute Percentage Error)</td>
                            <td>(100%/n) ∑|(yᵢ - ŷᵢ)/yᵢ|</td>
                            <td>(100%/{{ $mape_count > 0 ? $mape_count : 1 }}) × {{ number_format($sum_mape_numerator, 4) }}</td>
                            <td>{{ $mape }}%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
