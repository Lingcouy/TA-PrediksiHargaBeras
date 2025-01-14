@extends('layouts.main')

@section('container')
    <!-- Page Content -->
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>
                            {{-- @if (Auth::user()->tipePengguna === 'stafPersemaian')
                                Staf Persemaian
                            @else
                                {{ Auth::user()->tipePengguna }}
                            @endif --}}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            {{-- <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li> --}}
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <div class="row my-3">
                <h3 class="fs-3 mb-3 text-center">Tambah Data Bibit</h3>
                <form method="post" action="/keloladataprediksi">
                    <a href="/keloladataprediksi" class="btn btn-outline-success btn-sm mb-3"><i class="fas fa-arrow-left"></i>
                        Kembali</a>

                    @csrf
                    <div class="container-fluid border border-1 border-success rounded mx-auto">
                        <div class="row mb-3">
                            <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                            <div class="col-sm-5">
                                <select class="form-select @error('bulan') is-invalid @enderror" name="bulan" id="bulanSelect" required>
                                    <option value="" disabled selected>Pilih Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-5">
                                <select class="form-select @error('tahun') is-invalid @enderror" name="tahun" id="tahunSelect" required>
                                    <option value="" disabled selected>Pilih Tahun</option>
                                    @for ($year = 2000; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                                @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="hargaBeras" class="col-sm-2 col-form-label">Harga Beras</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('hargaBeras') is-invalid @enderror"
                                    id="hargaBeras" name="hargaBeras" value="{{ old('hargaBeras') }}"> @error('hargaBeras')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="produksiPadi" class="col-sm-2 col-form-label">produksiPadi</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('produksiPadi') is-invalid @enderror"
                                    id="produksiPadi" name="produksiPadi" value="{{ old('produksiPadi') }}"> @error('produksiPadi')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="produksiBeras" class="col-sm-2 col-form-label">produksiBeras</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('produksiBeras') is-invalid @enderror"
                                    id="produksiBeras" name="produksiBeras" value="{{ old('produksiBeras') }}"> @error('produksiBeras')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="luasPanenPadi" class="col-sm-2 col-form-label">Luas Panen Padi</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('luasPanenPadi') is-invalid @enderror"
                                    id="luasPanenPadi" name="luasPanenPadi" value="{{ old('luasPanenPadi') }}"> @error('luasPanenPadi')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="indeksHargaKonsumen" class="col-sm-2 col-form-label">IHK</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('indeksHargaKonsumen') is-invalid @enderror"
                                    id="indeksHargaKonsumen" name="indeksHargaKonsumen" value="{{ old('indeksHargaKonsumen') }}"> @error('indeksHargaKonsumen')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inflasi" class="col-sm-2 col-form-label">Inflasi</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('inflasi') is-invalid @enderror"
                                    id="inflasi" name="inflasi" value="{{ old('inflasi') }}"> @error('inflasi')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="curahHujan" class="col-sm-2 col-form-label">Curah Hujan</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('curahHujan') is-invalid @enderror"
                                    id="curahHujan" name="curahHujan" value="{{ old('curahHujan') }}"> @error('curahHujan')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>       
                        <div class="row mb-3">
                            <div class="col-sm-3 offset-sm-2">
                                <!-- Menggunakan class "offset-sm-10" untuk menggeser tombol ke kanan -->
                                <button type="submit" class="btn btn-success">Simpan</button>

                            </div>
                        </div>
                    </div>
                </form>

                <div>
                </div>
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
<!-- /#page-content-wrapper -->
