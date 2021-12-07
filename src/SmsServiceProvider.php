<?php

namespace Phpritesh\Rksms;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/rksms.php' => config_path('rksms.php'),
        ], 'rksms');
    }

    public function register()
    {
        
    }

}