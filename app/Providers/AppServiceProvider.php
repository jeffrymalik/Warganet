<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Keluhan;
use App\Models\PermohonanSurat;
use App\Models\IplTagihan;
use App\Models\IuranTagihan;
use App\Observers\KeluhanObserver;
use App\Observers\PermohonanSuratObserver;
use App\Observers\IplTagihanObserver;
use App\Observers\IuranTagihanObserver;

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
        // URL::forceScheme('https');
        Keluhan::observe(KeluhanObserver::class);
        PermohonanSurat::observe(PermohonanSuratObserver::class);
        IplTagihan::observe(IplTagihanObserver::class);
        IuranTagihan::observe(IuranTagihanObserver::class);
    }
}
