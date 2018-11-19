<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('empty_with','App\\Providers\\MyValidator@validateEmptyWith');
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
