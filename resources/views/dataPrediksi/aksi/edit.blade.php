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
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown"></ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <div class="row my-3">
                <h3 class="fs-3 mb-3 text-center">Ubah Data Prediksi</h3>
                <form method="POST" action="{{ route('keloladataprediksi.update', $dataPrediksi->idDataPrediksi) }}">
                    @csrf
                    @method('PUT')
                    <a href="/keloladataprediksi" class="btn btn-outline-success btn-sm mb-3"><i class="fas fa-arrow-left"></i>
                        Kembali</a>

                    <div class="container-fluid border border-1 border-success rounded mx-auto">
                        <div class="row mb-3 mt-3">
                            <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                            <div class="col-sm-5">
                                <select class="form-select @error('bulan') is-invalid @enderror" name="bulan" id="bulanSelect" required>
                                    <option value="" disabled>Pilih Bulan</option>
                                    <option value="01" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '01' ? 'selected' : '' }}>Januari</option>
                                    <option value="02" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '02' ? 'selected' : '' }}>Februari</option>
                                    <option value="03" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '03' ? 'selected' : '' }}>Maret</option>
                                    <option value="04" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '04' ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '05' ? 'selected' : '' }}>Mei</option>
                                    <option value="06" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '06' ? 'selected' : '' }}>Juni</option>
                                    <option value="07" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '07' ? 'selected' : '' }}>Juli</option>
                                    <option value="08" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '08' ? 'selected' : '' }}>Agustus</option>
                                    <option value="09" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '09' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ old('bulan', substr($dataPrediksi->periode, 5, 2)) == '12' ? 'selected' : '' }}>Desember</option>
                                </select>
                                @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-5">
                                <select class="form-select @error('tahun') is-invalid @enderror" name="tahun" id="tahunSelect" required>
                                    <option value="" disabled>Pilih Tahun</option>
                                    @for ($year = 2000; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}" {{ old('tahun', substr($dataPrediksi->periode, 0, 4)) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                                @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Input lainnya -->
                        <div class="row mb-3">
                            <label for="hargaBeras" class="col-sm-2 col-form-label">Harga Beras</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('hargaBeras') is-invalid @enderror"
                                    id="hargaBeras" name="hargaBeras" value="{{ old('hargaBeras', $dataPrediksi->hargaBeras) }}">
                                @error('hargaBeras')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="produksiPadi" class="col-sm-2 col-form-label">Produksi Padi</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('produksiPadi') is-invalid @enderror"
                                    id="produksiPadi" name="produksiPadi" value="{{ old('produksiPadi', $dataPrediksi->produksiPadi) }}">
                                @error('produksiPadi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="produksiBeras" class="col-sm-2 col-form-label">Produksi Beras</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('produksiBeras') is-invalid @enderror"
                                    id="produksiBeras" name="produksiBeras" value="{{ old('produksiBeras', $dataPrediksi->produksiBeras) }}">
                                @error('produksiBeras')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="luasPanenPadi" class="col-sm-2 col-form-label">Luas Panen Padi</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('luasPanenPadi') is-invalid @enderror"
                                    id="luasPanenPadi" name="luasPanenPadi" value="{{ old('luasPanenPadi', $dataPrediksi->luasPanenPadi) }}">
                                @error('luasPanenPadi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="indeksHargaKonsumen" class="col-sm-2 col-form-label">IHK</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('indeksHargaKonsumen') is-invalid @enderror"
                                    id="indeksHargaKonsumen" name="indeksHargaKonsumen" value="{{ old('indeksHargaKonsumen', $dataPrediksi->indeksHargaKonsumen) }}">
                                @error('indeksHargaKonsumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inflasi" class="col-sm-2 col-form-label">Inflasi</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('inflasi') is-invalid @enderror"
                                    id="inflasi" name="inflasi" value="{{ old('inflasi', $dataPrediksi->inflasi) }}">
                                @error('inflasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="curahHujan" class="col-sm-2 col-form-label">Curah Hujan</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('curahHujan') is-invalid @enderror"
                                    id="curahHujan" name="curahHujan" value="{{ old('curahHujan', $dataPrediksi->curahHujan) }}">
                                @error('curahHujan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="row mb-3">
                            <div class="col-sm-3 offset-sm-2">
                                <button type="submit" class="btn btn-success">Update</button>
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
