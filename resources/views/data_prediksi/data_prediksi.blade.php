@extends('layouts.main')
@section('container')
    <!-- Page Content -->   
    {{-- @include('sweetalert::alert') --}}
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
                            @elseif(Auth::user()->tipePengguna === 'admin')
                                Admin BPDASHL
                            @else
                                {{ Auth::user()->tipePengguna }}
                            @endif --}}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                dfgd
                            </li>
                            {{-- <li><a class="dropdown-item" href="{{ route('') }}"
                                    onclick="event.preventDefault(); document.getElementById('').submit();">
                                    Keluar
                                </a>
                                <form id="logout-form" action="{{ route('') }}" method="POST" style="display: none;">
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
                <h3 class="fs-3 mb-3">Kelola Data Prediksi</h3>
                {{-- @if (session()->has('success')) --}}
                    {{-- <div id="successAlert"
                        class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                        role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> --}}
                {{-- @endif --}}
                <div class="col">

                    <form action="/keloladataprediksi" method="GET">
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
                {{-- @if (session('info'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('info') }}
                    </div>
                @endif --}}
                <div class="table-responsive mt-3">

                    <table id="myTable" class="table bg-white rounded shadow-sm table-striped table-hover">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" width="50">No</th>                                
                                <th scope="col">Periode</th>
                                <th scope="col">Harga Beras</th>
                                <th scope="col">Produksi Padi</th>
                                <th scope="col">Produksi Beras</th>
                                <th scope="col">Luas Panen</th>
                                <th scope="col">IHK</th>
                                <th scope="col">Curah Hujan</th>
                                <th scope="col">Inflasi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nomor = 1 + ($dataPrediksis->currentPage() - 1) * $dataPrediksis->perPage();
                            @endphp
                            @foreach ($dataPrediksis as $dataPrediksi)
                                <tr>
                                    <td>
                                        {{-- {{ $loop->iteration }} --}}
                                        {{ $nomor++ }}
                                        
                                    </td>
                                    <td>
                                        {{ $dataPrediksi->periode }}                 
                                    </td>
                                    <td>
                                        {{ $dataPrediksi->hargaBeras }}                 
                                    </td>
                                    <td>
                                        {{ $dataPrediksi->produksiPadi }}
                                    </td>
                                    <td>
                                        {{ $dataPrediksi->produksiBeras }}
                                    </td>
                                    <td>
                                        {{ $dataPrediksi->luasPanenPadi }}
                                    </td>
                                    <td>
                                        {{ $dataPrediksi->indeksHargaKonsumen }}
                                    </td>
                                    <td>
                                        {{ $dataPrediksi->inflasi }}
                                    </td>
                                    <td>
                                        {{ $dataPrediksi->curahHujan }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $dataPrediksis->links() }}
                    {{-- {!! $bibits->appends(Request::except('page'))->render() !!} --}}
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>
@endsection
