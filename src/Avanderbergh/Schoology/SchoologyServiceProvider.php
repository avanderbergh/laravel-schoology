<?php

namespace Avanderbergh\Schoology;

use Illuminate\Support\ServiceProvider;

class SchoologyServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../migrations/2015_07_01_000000_create_oauth_store_table.php' => database_path('migrations/2015_07_01_000000_create_oauth_store_table.php'),
            __DIR__.'/../../migrations/2015_07_03_000000_create_schoology_users_table.php' => database_path('migrations/2015_07_03_000000_create_schoology_users_table.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('Avanderbergh\Schoology\SchoologyApi', function ($app) {
            return new SchoologyApi(getenv('CONSUMER_KEY'), getenv('CONSUMER_SECRET'), session('schoology')['domain']);
        });
    }

    public function provides()
    {
        return array();
    }
}
