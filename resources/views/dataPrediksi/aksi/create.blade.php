@extends('layouts.main')
@section('title', 'Tambah Data Prediksi')

@section('container')
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">DATA PREDIKSI</h2>
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
                <h3 class="fs-3 mb-3 text-center">Tambah Data Prediksi</h3>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('keloladataprediksi.store') }}">
                    @csrf
                    <a href="{{ route('keloladataprediksi.index') }}" class="btn btn-outline-success btn-sm mb-3"><i
                            class="fas fa-arrow-left"></i> Kembali</a>

                    <div class="container-fluid border border-1 border-success rounded mx-auto">
                        <div class="row mb-3 mt-3">
                            <label for="bulan" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-5">
                                <select class="form-select @error('bulan') is-invalid @enderror" name="bulan"
                                    id="bulanSelect" required>
                                    <option value="" disabled {{ old('bulan') ? '' : 'selected' }}>Pilih Bulan
                                    </option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('bulan') == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                                @error('bulan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-5">
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                    name="tahun" id="tahunSelect" value="{{ old('tahun', date('Y')) }}" min="2000"
                                    max="2099" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga_beras_kualitas_bawah_i" class="col-sm-2 col-form-label">Harga Beras Bawah
                                I</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('harga_beras_kualitas_bawah_i') is-invalid @enderror"
                                    id="harga_beras_kualitas_bawah_i" name="harga_beras_kualitas_bawah_i"
                                    value="{{ old('harga_beras_kualitas_bawah_i') }}">
                                @error('harga_beras_kualitas_bawah_i')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga_beras_kualitas_bawah_ii" class="col-sm-2 col-form-label">Harga Beras Bawah
                                II</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('harga_beras_kualitas_bawah_ii') is-invalid @enderror"
                                    id="harga_beras_kualitas_bawah_ii" name="harga_beras_kualitas_bawah_ii"
                                    value="{{ old('harga_beras_kualitas_bawah_ii') }}">
                                @error('harga_beras_kualitas_bawah_ii')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga_beras_kualitas_medium_i" class="col-sm-2 col-form-label">Harga Beras Medium
                                I</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('harga_beras_kualitas_medium_i') is-invalid @enderror"
                                    id="harga_beras_kualitas_medium_i" name="harga_beras_kualitas_medium_i"
                                    value="{{ old('harga_beras_kualitas_medium_i') }}">
                                @error('harga_beras_kualitas_medium_i')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga_beras_kualitas_medium_ii" class="col-sm-2 col-form-label">Harga Beras Medium
                                II</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('harga_beras_kualitas_medium_ii') is-invalid @enderror"
                                    id="harga_beras_kualitas_medium_ii" name="harga_beras_kualitas_medium_ii"
                                    value="{{ old('harga_beras_kualitas_medium_ii') }}">
                                @error('harga_beras_kualitas_medium_ii')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga_beras_kualitas_super_i" class="col-sm-2 col-form-label">Harga Beras Super
                                I</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('harga_beras_kualitas_super_i') is-invalid @enderror"
                                    id="harga_beras_kualitas_super_i" name="harga_beras_kualitas_super_i"
                                    value="{{ old('harga_beras_kualitas_super_i') }}">
                                @error('harga_beras_kualitas_super_i')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga_beras_kualitas_super_ii" class="col-sm-2 col-form-label">Harga Beras Super
                                II</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('harga_beras_kualitas_super_ii') is-invalid @enderror"
                                    id="harga_beras_kualitas_super_ii" name="harga_beras_kualitas_super_ii"
                                    value="{{ old('harga_beras_kualitas_super_ii') }}">
                                @error('harga_beras_kualitas_super_ii')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inflasi_bi" class="col-sm-2 col-form-label">Inflasi BI</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('inflasi_bi') is-invalid @enderror" id="inflasi_bi"
                                    name="inflasi_bi" value="{{ old('inflasi_bi') }}">
                                @error('inflasi_bi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kurs_usd" class="col-sm-2 col-form-label">Kurs USD</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('kurs_usd') is-invalid @enderror" id="kurs_usd"
                                    name="kurs_usd" value="{{ old('kurs_usd') }}">
                                @error('kurs_usd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="bbm_pertalite" class="col-sm-2 col-form-label">BBM Pertalite</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('bbm_pertalite') is-invalid @enderror" id="bbm_pertalite"
                                    name="bbm_pertalite" value="{{ old('bbm_pertalite') }}">
                                @error('bbm_pertalite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ump_sulut" class="col-sm-2 col-form-label">UMP Sulut</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('ump_sulut') is-invalid @enderror" id="ump_sulut"
                                    name="ump_sulut" value="{{ old('ump_sulut') }}">
                                @error('ump_sulut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jumlah_penduduk" class="col-sm-2 col-form-label">Jumlah Penduduk</label>
                            <div class="col-sm-10">
                                <input type="number" step="1"
                                    class="form-control @error('jumlah_penduduk') is-invalid @enderror"
                                    id="jumlah_penduduk" name="jumlah_penduduk" value="{{ old('jumlah_penduduk') }}">
                                @error('jumlah_penduduk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pupuk_nonsubsidi" class="col-sm-2 col-form-label">Pupuk Non-Subsidi</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"
                                    class="form-control @error('pupuk_nonsubsidi') is-invalid @enderror" id="pupuk_nonsubsidi"
                                    name="pupuk_nonsubsidi" value="{{ old('pupuk_nonsubsidi') }}">
                                @error('pupuk_nonsubsidi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3 offset-sm-2">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const bulan = document.querySelector('#bulanSelect').value;
            const tahun = document.querySelector('#tahunSelect').value;
            if (!bulan || !tahun) {
                event.preventDefault();
                alert('Silakan pilih bulan dan tahun!');
            }
        });
    </script>
@endsection
