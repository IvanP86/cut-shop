<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
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
        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {
            DB::listen(function ($query) {
                if ($query->time > 1000) {
                    logger()->channel('telegram')->debug('query longer than 1s : ' . $query->sql, $query->bindings);
                }
            });
        }
        app(Kernel::class)->whenRequestLifecycleIsLongerThan(
            CarbonInterval::second(4),
            function () {
                logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan : ' . request()->url());
            }
        );
    }
}
