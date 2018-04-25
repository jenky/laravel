<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenky\LaravelPlupload\PluploadServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(PluploadServiceProvider::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
