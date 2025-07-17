@extends('layouts.main')
@section('title', 'Kelola Data Prediksi')

@section('container')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">Kelola Data Prediksi</h2>
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
                <h3 class="fs-3 mb-3">Kelola Data Prediksi</h3>
                @if (session('success'))
                    <div id="successAlert"
                         class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                         role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="col">
                    <form action="{{ route('keloladataprediksi.index') }}" method="GET">
                        <div class="row g-2 align-items-end">
                            <!-- Input Tahun -->
                            <div class="col-md-5">
                                <input class="form-control" type="number" placeholder="Masukkan Tahun"
                                       name="tahun" value="{{ request('tahun') }}" min="2000" max="2099" autofocus>
                            </div>

                            <!-- Dropdown Bulan -->
                            <div class="col-md-5">
                                <select class="form-select" name="bulan" id="bulan">
                                    <option value="">Pilih Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Tombol Cari -->
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success" id="cariButton">Cari Data <i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                    <div class="row g-2 mt-2 mb-3">
                        <!-- Tombol Tambah Data -->
                        <div class="col-auto">
                            <a href="{{ route('keloladataprediksi.create') }}" class="btn btn-success">Tambah Data <i
                                    class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="myTable" class="table bg-white rounded shadow-sm table-striped table-hover"
                           aria-label="Rice Price Prediction Data">
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
                            <th scope="col">Pupuk Non-Subsidi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $nomor = 1 + ($dataBeras->currentPage() - 1) * $dataBeras->perPage();
                        @endphp
                        @if($dataBeras->count() > 0)
                            @foreach ($dataBeras as $data)
                                <tr>
                                    <td>{{ $nomor++ }}</td>
{{--                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('F Y') }}</td>--}}
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('MMMM-YYYY') }}</td>

                                    <td>{{ number_format($data->harga_beras_kualitas_bawah_i, 2) }}</td>
                                    <td>{{ number_format($data->harga_beras_kualitas_bawah_ii, 2) }}</td>
                                    <td>{{ number_format($data->harga_beras_kualitas_medium_i, 2) }}</td>
                                    <td>{{ number_format($data->harga_beras_kualitas_medium_ii, 2) }}</td>
                                    <td>{{ number_format($data->harga_beras_kualitas_super_i, 2) }}</td>
                                    <td>{{ number_format($data->harga_beras_kualitas_super_ii, 2) }}</td>
                                    <td>{{ number_format($data->inflasi_bi, 2) }}</td>
                                    <td>{{ number_format($data->kurs_usd, 2) }}</td>
                                    <td>{{ number_format($data->bbm_pertalite, 2) }}</td>
                                    <td>{{ number_format($data->ump_sulut, 2) }}</td>
                                    <td>{{ number_format($data->jumlah_penduduk, 0) }}</td>
                                    <td>{{ number_format($data->pupuk_nonsubsidi, 2) }}</td>
                                    <td>
                                        <a href="{{ route('keloladataprediksi.edit', $data->id) }}"
                                           class="badge bg-primary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('keloladataprediksi.destroy', $data->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0 confirm-deleted">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="15" class="text-center text-muted">No data available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {{ $dataBeras->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.confirm-deleted').forEach(button => {
            button.addEventListener('click', function (event) {
                if (!confirm('Apakah anda yakin ingin menghapus data ini?')) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
