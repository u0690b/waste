<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Log;

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
        if (config('app.env') === 'local') {
            DB::listen(function ($query) {
                Log::info(
                    $query->sql,[
                    $query->bindings,
                    $query->time
                    ]
                );
            });
        }

    }
}
