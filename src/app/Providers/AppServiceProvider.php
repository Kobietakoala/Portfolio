<?php

namespace App\Providers;

use App\Service\ProfileService;
use App\Service\SkillService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProfileService::class);
        $this->app->singleton(SkillService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
