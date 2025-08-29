<?php

namespace App\Providers;

use App\Http\Controllers\Portfolio\HomeController;
use App\Http\Controllers\Web\PortfolioContactController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            $this->registerAttributeRoutes();
        });

    }


    /**
     * Register routes for controllers using PHP 8 attributes.
     * This method registers their routes based on attribute definitions.
     */
    protected function registerAttributeRoutes(): void
    {
        Route::controller(HomeController::class);
        Route::controller(PortfolioContactController::class);
    }

}
