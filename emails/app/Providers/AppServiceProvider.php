<?php

namespace App\Providers;

use App\Jobs\AdminAdded;
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
        App::bindMethod([AdminAdded::class, 'handle'], fn ($job) => $job->handle());
    }
}
