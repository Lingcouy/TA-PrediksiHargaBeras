@extends('layouts.main')
@section('title', 'Future Price Predictions')
@section('container')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">Future Price Predictions</h2>
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

                    @guest
                        <!-- Kosongkan untuk guest / user belum login -->
                    @endguest
                </ul>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <!-- Months Ahead Selection Form -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <form action="{{ route('data-beras.predictFuture') }}" method="GET">
                        <div class="input-group">
                            <label for="months_ahead" class="input-group-text">Months Ahead</label>
                            <select name="months_ahead" id="months_ahead" class="form-select" onchange="this.form.submit()">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $months_ahead == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ $i == 1 ? 'Month' : 'Months' }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Display Error if Any -->
            @if (isset($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif

            <!-- Forecasted Prices -->
            <div class="row my-5">
                <h3 class="fs-4 mb-3">Forecasted Rice Prices ({{ $months_ahead }} {{ $months_ahead == 1 ? 'Month' : 'Months' }} Ahead)</h3>
                @foreach ($results as $category => $result)
                    @if (isset($result['error']))
                        <div class="alert alert-warning">
                            Error for {{ str_replace('_', ' ', $category) }}: {{ $result['error'] }}
                        </div>
                    @else
                        <div class="col-md-4 mb-4">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">{{ number_format((float)$result['future_predictions'][0]['predicted_price'], 2) }}</h3>                                    <p class="fs-5">{{ str_replace('_', ' ', $category) }} (Next Month)</p>
                                </div>
                                <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Predictions Table -->
            <div class="row my-5">
                <h3 class="fs-4 mb-3">Prediction Details</h3>
                <div class="col">
                    <table class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                        <tr>
                            <th scope="col" width="50">#</th>
                            <th scope="col">Date</th>
                            @foreach ($results as $category => $result)
                                @if (!isset($result['error']))
                                    <th scope="col">{{ str_replace('_', ' ', $category) }}</th>
                                @endif
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @if (!empty($results) && !isset($results[array_key_first($results)]['error']))
                            @foreach ($results[array_key_first($results)]['future_predictions'] as $index => $prediction)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ \Carbon\Carbon::parse($prediction['tanggal'])->format('F-Y') }}</td>
                                    @foreach ($results as $category => $result)
                                        @if (!isset($result['error']))
                                            <td>{{ number_format((float)$result['future_predictions'][$index]['predicted_price'], 2) }}</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="{{ 2 + count(array_filter($results, fn($r) => !isset($r['error']))) }}" class="text-center">No predictions available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chart -->
            @if (!empty($results) && !isset($results[array_key_first($results)]['error']))
                <div class="row my-5">
                    <h3 class="fs-4 mb-3">Price Trends</h3>
                    <div class="col">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <canvas id="priceChart" width="800" height="400"></canvas>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    @if (!empty($results) && !isset($results[array_key_first($results)]['error']))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('priceChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json(array_map(fn($date) => \Carbon\Carbon::parse($date)->format('F-Y'), array_column($results[array_key_first($results)]['future_predictions'], 'tanggal'))),

                        datasets: [
                                @foreach ($results as $category => $result)
                                @if (!isset($result['error']))
                            {
                                label: '{{ str_replace('_', ' ', $category) }}',
                                data: @json(array_column($result['future_predictions'], 'predicted_price')),
                                borderColor: '{{ $loop->index == 0 ? '#007bff' : ($loop->index == 1 ? '#28a745' : ($loop->index == 2 ? '#dc3545' : ($loop->index == 3 ? '#ffc107' : ($loop->index == 4 ? '#17a2b8' : '#6f42c1')))) }}',
                                backgroundColor: '{{ $loop->index == 0 ? 'rgba(0, 123, 255, 0.1)' : ($loop->index == 1 ? 'rgba(40, 167, 69, 0.1)' : ($loop->index == 2 ? 'rgba(220, 53, 69, 0.1)' : ($loop->index == 3 ? 'rgba(255, 193, 7, 0.1)' : ($loop->index == 4 ? 'rgba(23, 162, 184, 0.1)' : 'rgba(111, 66, 193, 0.1)')))) }}',
                                fill: false
                            },
                            @endif
                            @endforeach
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Price (IDR)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endsection
