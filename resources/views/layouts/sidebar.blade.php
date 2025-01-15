<!-- Sidebar -->
<div class="" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
            class="fas fa-seedling me-2"></i>Prediksi <br> Harga Beras</div>
    <div class="list-group list-group-flush my-3">        
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-transparent second-text {{ Request::is('dashboard') ? 'active' : '' }}"><i
            class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
        <a href="prediksi" class="list-group-item list-group-item-action bg-transparent second-text fw-bold {{ Request::is('prediksi') ? 'active' : '' }}"><i 
            class="fas fa-chart-line me-2"></i>Prediksi Harga</a>
        <a href="{{ route('data-prediksi') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold {{ Request::is('data-prediksi') ? 'active' : '' }}" ><i
            class="fas fa-table me-2"></i>Data Prediksi</a>
        <a href="{{ route('keloladataprediksi.index') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold {{ Request::is('keloladataprediksi') ? 'active' : '' }}"><i
            class="fas fa-user-edit  me-2"></i>Kelola Data Prediksi</a>
        <a href="#" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
            class="fas fa-power-off me-2"></i>Logout</a>
    </div>
</div>
<!-- /#sidebar-wrapper -->  