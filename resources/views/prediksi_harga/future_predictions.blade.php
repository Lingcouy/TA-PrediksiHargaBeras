@extends('layouts.main')
@section('title', 'Prediksi Harga ke Selanjutnya')
@section('container')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">Prediksi Harga ke Selanjutnya</h2>
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
            {{-- Removed Months Ahead Selection Form --}}
            {{--
            <div class="row mb-4">
                <div class="col-md-4">
                    <form action="{{ route('data-beras.predictFuture') }}" method="GET">
                        <div class="input-group">
                            <label for="months_ahead" class="input-group-text">Bulan ke Selanjutnya</label>
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
            --}}

            <!-- Display Error if Any -->
            @if (isset($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif

            <!-- Forecasted Prices -->
            <div class="row my-5">
                <h3 class="fs-4 mb-3">Prediksi Harga (Bulan Selanjutnya)</h3> {{-- Changed text here --}}
                @foreach ($results as $category => $result)
                    @if (isset($result['error']))
                        <div class="alert alert-warning">
                            Error for {{ str_replace('_', ' ', $category) }}: {{ $result['error'] }}
                        </div>
                    @else
                        <div class="col-md-4 mb-4">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">{{ number_format((float)str_replace(',', '', $result['future_predictions'][0]['predicted_price']), 2, '.', ',') }}
                                    </h3>
                                    <p class="fs-5">{{ str_replace('_', ' ', $category) }} (Bulan Selanjutnya)</p>
                                </div>
                                <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Predictions Table -->
            <div class="row my-5">
                <h3 class="fs-4 mb-3">Detail Prediksi</h3>
                <div class="col">
                    <table class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                        <tr>
                            <th scope="col" width="50">#</th>
                            <th scope="col">Tanggal</th>
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
                                            <td>{{ number_format((float)str_replace(',', '', $result['future_predictions'][$index]['predicted_price']), 2, '.', ',') }}</td>
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

            <!-- New Section: Future Independent Variables -->
            <div class="row my-5">
                <h3 class="fs-4 mb-3">Variabel Indipenden (Bulan Selanjutnya)</h3> {{-- Changed text here --}}
                <div class="col">
                    @if (!empty($future_independent_variables))
                        <table class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Inflasi BI</th>
                                <th scope="col">Kurs USD</th>
                                <th scope="col">BBM Pertalite</th>
                                <th scope="col">UMP Sulut</th>
                                <th scope="col">Jumlah Penduduk</th>
                                <th scope="col">Pupuk Subsidi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($future_independent_variables as $future_data)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($future_data['tanggal'])->format('F-Y') }}</td>
                                    <td>{{ number_format($future_data['inflasi_bi'], 2, '.', ',') }}</td>
                                    <td>{{ number_format($future_data['kurs_usd'], 2, '.', ',') }}</td>
                                    <td>{{ number_format($future_data['bbm_pertalite'], 2, '.', ',') }}</td>
                                    <td>{{ number_format($future_data['ump_sulut'], 2, '.', ',') }}</td>
                                    <td>{{ number_format($future_data['jumlah_penduduk'], 0, '.', ',') }}</td>
                                    <td>{{ number_format($future_data['pupuk_subsidi'], 2, '.', ',') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">Tidak ada data variabel indipenden ditemukan.</div>
                    @endif
                </div>
            </div>

            <!-- Coefficients Table -->
            <div class="row my-5">
                <h3 class="fs-4 mb-3">Koofisien Regresi</h3>
                <div class="col">
                    <table class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Kategiru</th>
                            <th scope="col">Intercept (b0)</th>
                            <th scope="col">Inflasi BI (b1)</th>
                            <th scope="col">Kurs USD (b2)</th>
                            <th scope="col">BBM Pertalite (b3)</th>
                            <th scope="col">UMP Sulut (b4)</th>
                            <th scope="col">Jumlah Penduduk (b5)</th>
                            <th scope="col">Pupuk Subsidi (b6)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($results as $category => $result)
                            @if (!isset($result['error']))
                                <tr>
                                    <td>{{ str_replace('_', ' ', $category) }}</td>
                                    <td>{{ $result['coefficients'][0] }}</td>
                                    <td>{{ $result['coefficients'][1] }}</td>
                                    <td>{{ $result['coefficients'][2] }}</td>
                                    <td>{{ $result['coefficients'][3] }}</td>
                                    <td>{{ $result['coefficients'][4] }}</td>
                                    <td>{{ $result['coefficients'][5] }}</td>
                                    <td>{{ $result['coefficients'][6] }}</td>
                                </tr>
                            @endif
                        @endforeach
                        @if (empty(array_filter($results, fn($r) => !isset($r['error']))))
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada koefisien ditemukan</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
    <!-- /#page-content-wrapper -->
@endsection
