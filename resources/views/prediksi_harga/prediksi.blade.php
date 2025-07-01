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

                <!-- Results from Analysis -->
                @if(isset($regressionEquation) && isset($predictedPrices))
                    <div class="mt-5">
                        <h4>Hasil Perhitungan Regresi Linier</h4>
                        <p><strong>Persamaan Regresi:</strong> {{ $regressionEquation }}</p>
                        <p><strong>Harga Prediksi:</strong></p>
                        <ul>
                            @foreach($predictedPrices as $index => $predictedPrice)
                                @php
                                    $actualPrice = isset($actualPrices[$index]) ? $actualPrices[$index] : null;
                                @endphp
                                <li>
                                    Bulan {{ $index + 1 }}:
                                    <span><strong>Harga Aktual:</strong>
                        @if($actualPrice !== null)
                                            Rp {{ number_format($actualPrice, 2, ',', '.') }}
                                        @else
                                            Data tidak tersedia
                                        @endif
                    </span> |
                                    <span><strong>Harga Prediksi:</strong> Rp {{ number_format($predictedPrice[0], 2, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <p><strong>MAPE:</strong> {{ number_format($mape, 2) }}%</p>
                        <p><strong>RMSE:</strong> {{ number_format($rmse, 2, ',', '.') }}</p> <!-- Tambahkan hasil RMSE -->
                    </div>
                @endif


                <!-- Grafik Prediksi Harga Beras -->
                <div class="mt-5">
                    <h4>Grafik Prediksi Harga Beras</h4>
                    <div class="chart-container" style="position: relative; height: 65vh; width:100%">
                        <canvas id="prediksiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('prediksiChart').getContext('2d');
        const prediksiChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], // Update labels dynamically based on range
                datasets: [
                    {
                        label: 'Harga Aktual',
                        data: [12000, 12500, 13000, 12800, 13500, 14000, 14500, 15000, 15500, 16000, 16500, 17000], // Replace with actual data
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Harga Prediksi',
                        data: [11500, 12000, 12500, 12300, 13000, 13500, 13800, 14300, 14800, 15200, 15800, 16200], // Replace with predicted data
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false
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
                        text: 'Prediksi Harga Beras'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    </script>
@endsection
