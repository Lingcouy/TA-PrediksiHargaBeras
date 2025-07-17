<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
//use Illuminate\Support\Carbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrapFive();
        // Set locale aplikasi ke Indonesia
        App::setLocale('id');

        // Set locale Carbon ke Indonesia
        Carbon::setLocale('id'); // Bisa juga 'id' saja, tergantung sistem

        // (Opsional) Paksa format lokal dari Carbon Intl
        \Carbon\Carbon::setToStringFormat('l, j F Y H:i'); // Contoh format
    }
}
