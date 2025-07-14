@extends('layouts.main')
@section('title', 'Dashboard')
@section('container')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">BERANDA</h2>
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
            <!-- Rice Type Selection Dropdown -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="input-group">
                            <label for="rice_type" class="input-group-text">Pilih Tipe Beras</label>
                            <select name="rice_type" id="rice_type" class="form-select" onchange="this.form.submit()">
                                @foreach ($price_fields as $key => $label)
                                    <option value="{{ $key }}" {{ $selected_type == $key ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-3 my-2">
                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">
                                @if (isset($latest) && $latest)
                                    {{ number_format($latest->$selected_type, 2, ',', '.') }}
                                @else
                                    N/A
                                @endif
                            </h3>
                            <p class="fs-5">Harga Terkini ({{ $price_fields[$selected_type] }})</p>
                        </div>
                        <i class="fas fa-gift fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">
                                {{ isset($average_price) ? number_format($average_price, 2, ',', '.') : 'N/A' }}
                            </h3>
                            <p class="fs-5">Rata-rata Harga ({{ $price_fields[$selected_type] }})</p>
                        </div>
                        <i class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">
                                {{ isset($highest_price) ? number_format($highest_price, 2, ',', '.') : 'N/A' }}
                            </h3>
                            <p class="fs-5">Harga Tertinggi ({{ $price_fields[$selected_type] }})</p>
                        </div>
                        <i class="fas fa-arrow-up fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">
                                {{ isset($lowest_price) ? number_format($lowest_price, 2, ',', '.') : 'N/A' }}
                            </h3>
                            <p class="fs-5">Harga Terendah ({{ $price_fields[$selected_type] }})</p>
                        </div>
                        <i class="fas fa-arrow-down fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
            </div>


            <div class="row my-5">
                <h3 class="fs-4 mb-3">Daftar Harga Beras</h3>
                <div class="col">
                    <table class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Tanggal (Bulan-Tahun)</th>
                                <th scope="col">Bawah I</th>
                                <th scope="col">Bawah II</th>
                                <th scope="col">Medium I</th>
                                <th scope="col">Medium II</th>
                                <th scope="col">Super I</th>
                                <th scope="col">Super II</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nomor = 1 + ($recent_data->currentPage() - 1) * $recent_data->perPage();
                            @endphp
                            @if (isset($recent_data) && $recent_data->count() > 0)
                                @foreach ($recent_data as $index => $data)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('F-Y') }}</td>
                                        <td>{{ number_format($data->harga_beras_kualitas_bawah_i, 2) }}</td>
                                        <td>{{ number_format($data->harga_beras_kualitas_bawah_ii, 2) }}</td>
                                        <td>{{ number_format($data->harga_beras_kualitas_medium_i, 2) }}</td>
                                        <td>{{ number_format($data->harga_beras_kualitas_medium_ii, 2) }}</td>
                                        <td>{{ number_format($data->harga_beras_kualitas_super_i, 2) }}</td>
                                        <td>{{ number_format($data->harga_beras_kualitas_super_ii, 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $recent_data->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
@endsection
