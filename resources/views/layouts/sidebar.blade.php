<!-- Sidebar -->
<div id="wrapper">
    <div class="" id="sidebar-wrapper">
        <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                class="fas fa-seedling me-2"></i>Prediksi <br> Harga Beras</div>
        <div class="list-group list-group-flush my-3">
            <a href="{{ route('dashboard') }}"
                class="list-group-item list-group-item-action bg-transparent second-text {{ Request::is('dashboard') ? 'active' : '' }}"><i
                    class="fas fa-tachometer-alt me-2"></i>Beranda</a>
            <a href="{{ route('prediksi-harga') }}"
                class="list-group-item list-group-item-action bg-transparent second-text fw-bold {{ Request::is('prediksi-harga', 'manual-calculation/*', 'calculate-coefficients') ? 'active' : '' }}"><i
                    class="fas fa-chart-line me-2"></i>Prediksi Harga</a>
            <a href="{{ route('data-beras.analyze') }}"
                class="list-group-item list-group-item-action bg-transparent second-text fw-bold {{ Request::is('analyze', 'manual-calculation-test/*') ? 'active' : '' }}"><i
                    class="fas fa-chart-area me-2"></i>Prediksi Harga (Data Uji)</a>
            <a href="{{ route('data-prediksi') }}"
                class="list-group-item list-group-item-action bg-transparent second-text fw-bold {{ Request::is('data-prediksi') ? 'active' : '' }}"><i
                    class="fas fa-table me-2"></i>Data Prediksi</a>
            @auth
                <a href="{{ route('keloladataprediksi.index') }}"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold {{ Request::is('keloladataprediksi') ? 'active' : '' }}"><i
                        class="fas fa-user-edit  me-2"></i>Kelola Data Prediksi</a>
            @endauth
            {{--        <a href="#" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i --}}
            {{--            class="fas fa-power-off me-2"></i>Logout</a> --}}

            @auth
                <form action="{{ route('logout') }}" method="POST"
                    class="list-group-item bg-transparent text-danger fw-bold border-0 p-0 m-0">
                    @csrf
                    <button type="submit"
                        class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
                        <i class="fas fa-power-off me-2"></i>Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="list-group-item list-group-item-action bg-transparent text-primary fw-bold">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </a>
            @endauth

        </div>
    </div>
</div>
<!-- /#sidebar-wrapper -->
