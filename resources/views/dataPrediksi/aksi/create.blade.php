@extends('layouts.main')

@section('container')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0"></h2>
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
                <form method="post" action="/bibitdummy">
                    <a href="/bibitdummy" class="btn btn-outline-success btn-sm mb-3"><i class="fas fa-arrow-left"></i>
                        Kembali</a>

                    @csrf
                    <div class="container-fluid border border-1 border-success rounded mx-auto">
                        <div class="row mb-3 mt-3 ">
                            <label for="persemaian" class="col-sm-2 col-form-label">Persemaian</label>
                            <div class="col-sm-10">
                                <select class="form-select form-select-sl mb-0" aria-label="Default select example"
                                    style="max-width: 100%" name="persemaian" id="persemaianSelect">
                                    {{-- <option value="{{ Auth::user()->persemaian }}"
                                        {{ request('persemaian') == Auth::user()->persemaian ? 'selected' : '' }}>
                                        {{ Auth::user()->persemaian }}
                                    </option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jenis_Bibit" class="col-sm-2 col-form-label">Jenis Bibit</label>
                            <div class="col-sm-10">
                                {{-- <select class="form-select" name="jenis_Bibit" id="jenis_Bibit">
                                    @foreach ($jenis as $jeni)
                                        <option value="{{ $jeni->jenis_bibit }}">{{ $jeni->jenis_bibit }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tipe_Bibit" class="col-sm-2 col-form-label">Tipe Bibit</label>
                            <div class="col-sm-10">
                                {{-- <select class="form-select" name="tipe_Bibit" id="tipe_Bibit">
                                    @foreach ($tipe as $tipes)
                                        <option value="{{ $tipes->tipe_bibit }}">{{ $tipes->tipe_bibit }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-10">
                                {{-- <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah" name="jumlah" value="{{ old('jumlah') }}"> @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror --}}
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
@endsection
<!-- /#page-content-wrapper -->
