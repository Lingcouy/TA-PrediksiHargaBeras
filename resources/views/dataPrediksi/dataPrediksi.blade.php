@extends('layouts.main')
@section('container')
    <!-- Page Content -->   
    {{-- @include('sweetalert::alert') --}}
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">user</h2>
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
                <h3 class="fs-3 mb-3">Kelola Data Bibit Sementara</h3>
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
                        <div class="row g-2">
                            <label for="search" class="" style="display: none;">\</label>
                            <div class="col-md-5">
                                <input class="form-control form-control-sl mb-0" type="text" placeholder="Cari...."
                                    style="max-width: 100%;" value="" name="search" autofocus>
                            </div>
                            <div class="col-md-5">
                                <select class="form-select form-select-sl mb-0" aria-label="Default select example"
                                    style="max-width: 100%" name="persemaian" id="persemaianSelect">
                                    {{-- <option value="{{ Auth::user()->persemaian }}"
                                        {{ request('persemaian') == Auth::user()->persemaian ? 'selected' : '' }}>
                                        {{ Auth::user()->persemaian }}
                                    </option> --}}
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success mb-2" id="cariButton">Cari
                                    Data <i class="fas fa-search"></i></button>
                            </div>
                    </form>
                    <div class="col-auto">
                        <a href="/keloladataprediksi/create" class="btn btn-success mb-2">Tambah Data <i
                                class="fas fa-plus"></i></a>
                    </div>
                </div>
                {{-- @if (session('info'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('info') }}
                    </div>
                @endif --}}
                <div class="table-responsive">

                    <table id="myTable" class="table bg-white rounded shadow-sm table-striped table-hover">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" width="50">No</th>
                                <th scope="col">Harga Beras</th>
                                <th scope="col">Produksi Padi</th>
                                <th scope="col">Produksi Beras</th>
                                <th scope="col">Luas Panen</th>
                                <th scope="col">IHK</th>
                                <th scope="col">Curah Hujan</th>
                                <th scope="col">Inflasi</th>
                                <th scope="col">Tipe Bibit</th>
                                <th scope="col">Jumlah Bibit</th>

                                {{-- <th scope="col">Penambahan Terakhir</th>
                                            <th scope="col">Pengurangan Terakhir</th> --}}
                                <th scope="col">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>

                            @php
                                // $nomor = 1 + ($bibits->currentPage() - 1) * $bibits->perPage();
                            @endphp
                            {{-- @foreach ($bibits as $bibit) --}}
                                <tr>
                                    <td>
                                        {{-- {{ $loop->iteration }} --}}
                                        {{-- {{ $nomor++ }} --}}
                                        fdgdg
                                    </td>
                                    <td>
                                        {{-- {{ $bibit->jenisBibit }} --}}
                                        fhfghfgh
                                    </td>
                                    <td>
                                       gfhfghfghf
                                    </td>
                                    <td>
                                       fghfghfg
                                    </td>
                                    <td>
                                       fghfghfg
                                    </td>
                                    <td>
                                       fghfghfg
                                    </td>
                                    <td>
                                       fghfghfg
                                    </td>
                                    <td>
                                       fghfghfg
                                    </td>
                                    <td>
                                       fghfghfg
                                    </td>
                                    <td>
                                       fghfghfg
                                    </td>
                                    <th>

                                        <a href="" type="button"
                                            class="badge bg-primary"><i class="fas fa-edit"></i></a>
                                        <form action="" method="post"
                                            type=button class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="badge bg-danger border-0 confirm-deleted"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>

                                    </th>
                                </tr>
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                    {{-- {{ $bibits->links() }} --}}
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
