<?php

namespace App\Providers;

use App\Hello\Hello;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(1071);
        Order::observe(OrderObserver::class);
        Builder::defaultStringLength(191);
        Passport::routes();
    }
}
