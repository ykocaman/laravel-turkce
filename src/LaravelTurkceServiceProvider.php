<?php

namespace Ykocaman\LaravelTurkce;

use Illuminate\Support\ServiceProvider;

class LaravelTurkceServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {

            // lang klasorune turkce cevirileri ekle
            $this->publishes([
                __DIR__ . '/../lang/tr' => resource_path('lang/tr'),
            ]);

            // ayar dosyasından turkce'yi aktiflestir
            $content = file_get_contents(config_path('app.php'));
            $content = str_replace('\'locale\' => \'en\'', '\'locale\' => \'tr\'', $content);
            file_put_contents(config_path('app.php'), $content);


            $this->commands([
                Commands\AuthMakeTrCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     * @return void
     */
    public function register()
    {
        //
    }
}