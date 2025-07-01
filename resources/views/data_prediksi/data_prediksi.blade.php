@extends('layouts.main')
@section('title', 'Data Prediksi')
@section('container')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">Data Prediksi</h2>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>John Doe
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <div class="row my-3">
                <h3 class="fs-3 mb-3">Data Prediksi</h3>
                <div class="col">
                    <form action="{{ route('data-prediksi') }}" method="GET">

                    @csrf
                        <div class="row g-2 align-items-end">
                            <!-- Input Tahun -->
                            <div class="col-md-5">
                                <input class="form-control" type="text" placeholder="Masukkan Tahun"
                                       name="tahun" value="{{ request('tahun') }}" autofocus>
                            </div>

                            <!-- Dropdown Bulan -->
                            <div class="col-md-5">
                                <select class="form-select" name="bulan" id="bulan">
                                    <option value="">Pilih Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                            {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Tombol Cari -->
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success" id="cariButton">Cari
                                    Data <i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="myTable" class="table bg-white rounded shadow-sm table-striped table-hover">
                        <thead class="table-success">
                        <tr>
                            <th scope="col" width="50">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Harga Beras Bawah I</th>
                            <th scope="col">Harga Beras Bawah II</th>
                            <th scope="col">Harga Beras Medium I</th>
                            <th scope="col">Harga Beras Medium II</th>
                            <th scope="col">Harga Beras Super I</th>
                            <th scope="col">Harga Beras Super II</th>
                            <th scope="col">Inflasi BI</th>
                            <th scope="col">Kurs USD</th>
                            <th scope="col">BBM Pertalite</th>
                            <th scope="col">UMP Sulut</th>
                            <th scope="col">Jumlah Penduduk</th>
                            <th scope="col">Pupuk Subsidi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $nomor = 1 + ($dataPrediksis->currentPage() - 1) * $dataPrediksis->perPage();
                        @endphp
                        @if($dataPrediksis->count() > 0)
                            @foreach ($dataPrediksis as $dataPrediksi)
                                <tr>
                                    <td>{{ $nomor++ }}</td>
                                    <td>{{ \Carbon\Carbon::parse($dataPrediksi->tanggal)->format('F-Y') }}</td>
                                    <td>{{ number_format($dataPrediksi->harga_beras_kualitas_bawah_i, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->harga_beras_kualitas_bawah_ii, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->harga_beras_kualitas_medium_i, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->harga_beras_kualitas_medium_ii, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->harga_beras_kualitas_super_i, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->harga_beras_kualitas_super_ii, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->inflasi_bi, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->kurs_usd, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->bbm_pertalite, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->ump_sulut, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->jumlah_penduduk, 2) }}</td>
                                    <td>{{ number_format($dataPrediksi->pupuk_subsidi, 2) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="14" class="text-center">No data available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {{ $dataPrediksis->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
@endsection
