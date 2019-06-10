<?php

namespace PTTridi\Cekmutasi;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CekmutasiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('Cekmutasi', function() {
            return new Cekmutasi;
        });
    }
}