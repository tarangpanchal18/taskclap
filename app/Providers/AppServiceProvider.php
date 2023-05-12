<?php

namespace App\Providers;

use App\Repositories\Admin\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ServiceRepository::class, function ($app, $id) {
            $request = array_filter(explode('/', $_SERVER['REQUEST_URI']));
            return new ServiceRepository($request[3]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        error_reporting(0);
        Paginator::useBootstrap();
    }
}
