@extends('layouts.main')
@section('title', 'Prediksi Harga')
@section('container')
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">Prediksi Harga</h2>
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
                <!-- Error Message -->
                @if(isset($error))
                    <div class="mt-5 alert alert-danger">
                        {{ $error }}
                    </div>
                @endif

                <!-- Results from Coefficient Calculation -->
                @if(isset($results) && !isset($error))
                    <div class="mt-5">
                        <h4>Hasil Perhitungan Koefisien Regresi Linier</h4>
                        @foreach($results as $category => $data)
                            <div class="mb-4">
                                <a href="{{ route('manual.calculation', ['category' => $category]) }}" class="btn btn-primary" target="_blank">
                                    Harga Beras Kualitas {{ str_replace('HARGA_BERAS_KUALITAS_', '', $category) }}
                                </a>
                                <p><strong>Persamaan Regresi:</strong> {{ $data['regression_equation'] }}</p>
                                <p><strong>Koefisien:</strong></p>
                                <ul>
                                    <li>Intercept: {{ $data['coefficients'][0] }}</li>
                                    <li>INFLASI_BI: {{ $data['coefficients'][1] }}</li>
                                    <li>KURS_USD: {{ $data['coefficients'][2] }}</li>
                                    <li>BBM_PERTALITE: {{ $data['coefficients'][3] }}</li>
                                    <li>UMP_SULUT: {{ $data['coefficients'][4] }}</li>
                                    <li>JUMLAH_PENDUDUK: {{ $data['coefficients'][5] }}</li>
                                    <li>PUPUK_SUBSIDI: {{ $data['coefficients'][6] }}</li>
                                </ul>
                                <p><strong>MAE:</strong> {{ $data['mae'] }}</p>
                                <p><strong>RMSE:</strong> {{ $data['rmse'] }}</p>
                                <p><strong>MAPE:</strong> {{ $data['mape'] }}%</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Dropdown to Select Price Category for Chart -->
                    <div class="mt-5">
                        <h4>Grafik Prediksi Harga Beras</h4>
                        <div class="mb-3">
                            <label for="priceCategory" class="form-label">Pilih Kategori Harga:</label>
                            <select id="priceCategory" class="form-select" onchange="updateChart()">
                                @foreach($results as $category => $data)
                                    <option value="{{ $category }}">{{ str_replace('HARGA_BERAS_KUALITAS_', '', $category) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="chart-container" style="position: relative; height: 65vh; width:100%">
                            <canvas id="prediksiChart"></canvas>
                        </div>
                    </div>
                @else
                    <div class="mt-5">
                        <p>Tidak ada data hasil perhitungan koefisien yang tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(isset($results) && !isset($error))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Pass PHP data to JavaScript
            const results = @json($results);
            let prediksiChart;

            function updateChart() {
                const category = document.getElementById('priceCategory').value;
                const data = results[category];

                // Validate data
                if (!data || !data.dates || !data.actual_prices || !data.predicted_prices) {
                    console.error('Invalid chart data for category:', category, data);
                    return;
                }

                // Convert string prices to numbers
                const actualPrices = data.actual_prices.map(price => parseFloat(price.replace(',', '')));
                const predictedPrices = data.predicted_prices.map(price => parseFloat(price.replace(',', '')));

                // Log data for debugging
                console.log('Chart Data:', {
                    category: category,
                    dates: data.dates,
                    actual_prices: actualPrices,
                    predicted_prices: predictedPrices
                });

                // Destroy existing chart if it exists
                if (prediksiChart) {
                    prediksiChart.destroy();
                }

                // Create new chart
                const ctx = document.getElementById('prediksiChart').getContext('2d');
                prediksiChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [
                            {
                                label: 'Harga Aktual',
                                data: actualPrices,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: false,
                                pointRadius: 3
                            },
                            {
                                label: 'Harga Prediksi',
                                data: predictedPrices,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 2,
                                fill: false,
                                pointRadius: 3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Prediksi Harga Beras (' + category.replace('HARGA_BERAS_KUALITAS_', '') + ')'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Harga (Rp)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal (Tahun-Bulan)'
                                }
                            }
                        }
                    }
                });
            }

            // Initialize chart with the first category
            document.addEventListener('DOMContentLoaded', function() {
                updateChart();
            });
        </script>
    @endif
@endsection
