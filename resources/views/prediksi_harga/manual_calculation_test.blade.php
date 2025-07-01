```blade
@extends('layouts.main')
@section('title', 'Manual Calculation (Data Uji) - ' . str_replace('HARGA_BERAS_KUALITAS_', '', $category))
@section('container')
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">Perhitungan Manual (Data Uji) - Harga Beras Kualitas {{ str_replace('HARGA_BERAS_KUALITAS_', '', $category) }}</h2>
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
                                <li><a class="dropdown-item" href="{{ route('account.settings') }}">⚙️ Akun</a></li>                                <li>
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
                <a href="{{ route('data-beras.analyze') }}" class="btn btn-secondary mb-3">Back to Analyze</a>
                <h4>Perhitungan Manual untuk Prediksi Harga Beras Kualitas {{ str_replace('HARGA_BERAS_KUALITAS_', '', $category) }} (Data Uji)</h4>
                <p><strong>Persamaan Regresi:</strong> {{ $regression_equation }}</p>
                <p><strong>MAE:</strong> {{ $mae }}</p>
                <p><strong>RMSE:</strong> {{ $rmse }}</p>
                <p><strong>MAPE:</strong> {{ $mape }}%</p>

                <!-- Step 1: Training Data Table -->
                <h5>1. Data Latih</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>HARGA BERAS KUALITAS {{ str_replace('HARGA_BERAS_KUALITAS_', '', $category) }} (PER KG)</th>
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
                        @foreach($data_table as $row)
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
                <h5>2. Produk Berpasangan dan Kuadrat (Data Latih)</h5>
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
                        @foreach($pairwise_calculations as $row)
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
                <h5>3. Matriks H (Data Latih)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Variable</th>
                            <th>Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(['Y', 'X1Y', 'X2Y', 'X3Y', 'X4Y', 'X5Y', 'X6Y'] as $index => $label)
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
                @foreach(['A' => $A_matrix] + array_combine(range(1, 7), $A_matrices) as $matrix_name => $matrix)
                    @if($matrix_name === 'A')
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
                            @foreach($matrix as $index => $row)
                                <tr>
                                    <td>{{ $index == 0 ? 'Intercept' : ($index == 1 ? 'X1' : ($index == 2 ? 'X2' : ($index == 3 ? 'X3' : ($index == 4 ? 'X4' : ($index == 5 ? 'X5' : 'X6'))))) }}</td>
                                    @foreach($row as $value)
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
                        @foreach($det_Ai as $index => $det)
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
                        @foreach($coefficients as $index => $coef)
                            <tr>
                                <td>{{ $index == 0 ? 'b0 (det A1/det A)' : 'b' . $index . ' (det A' . ($index + 1) . '/det A)' }}</td>
                                <td>{{ $coef }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Step 7: Predicted Prices (Testing Data) -->
                <h5>7. Prediksi Harga (Data Uji)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>Y PREDICTED</th>
                            <th>Harga Aktual</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($test_data_table as $row)
                            <tr>
                                <td>{{ $row['NO'] }}</td>
                                <td>{{ $row['TANGGAL'] }}</td>
                                <td>{{ $row['Y_PREDICTED'] }}</td>
                                <td>{{ $row['Y'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
