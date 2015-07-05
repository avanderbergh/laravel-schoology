<?php namespace Avanderbergh\Schoology;

use Illuminate\Support\ServiceProvider;

class SchoologyServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {

    }

    public function register()
    {
        $this->app->singleton('Avanderbergh\Schoology\SchoologyApi', function($app){
            return new SchoologyApi(getenv('CONSUMER_KEY'),getenv('CONSUMER_SECRET'),session('schoology')['domain']);
        });
    }

    public function provides()
    {
        return array();
    }
}