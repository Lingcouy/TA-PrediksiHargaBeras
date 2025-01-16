@extends('layouts.main')
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i> Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Keluar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <div class="row my-3">
                <h3 class="fs-3 mb-3">Prediksi Harga</h3>
                <form method="GET" action="/prediksi-harga">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-select" name="bulan" id="bulan">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-select" name="tahun" id="tahun">
                                @for ($year = date('Y'); $year >= 2000; $year--)
                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mt-4">Prediksi Harga</button>
                            <button type="submit" class="btn btn-primary mt-4">Tampilkan Perhitungan</button>
                        </div>
                    </div>
                </form>

                <div class="mt-5 ">
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
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    {
                        label: 'Harga Aktual',
                        data: [12000, 12500, 13000, 12800, 13500, 14000, 14500, 15000, 15500, 16000, 16500, 17000],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Harga Prediksi',
                        data: [11500, 12000, 12500, 12300, 13000, 13500, 13800, 14300, 14800, 15200, 15800, 16200],
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
