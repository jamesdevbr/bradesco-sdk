<?php

namespace JamesDevBR\BradescoSDK\Providers;

use Illuminate\Support\ServiceProvider;

class BradescoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/bradesco.php',
            'bradesco'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/bradesco.php' => config_path('bradesco.php'),
        ], 'config');
    }
}