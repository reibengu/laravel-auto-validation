<?php

namespace Bekusc\Validation;

use Illuminate\Support\ServiceProvider;

class AutoValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/validation.php' => config_path('validation.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
