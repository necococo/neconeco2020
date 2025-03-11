<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

         \Schema::defaultStringLength(191);

    //     if ($this->app->environment() == 'production') {
    //       URL::forceScheme('https');
    //   }
    //   $this->app['request']->server->set('HTTPS','on');
    if ($this->app->environment() == 'production') {
          $this->app['request']->server->set('HTTPS','on');
      }

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
