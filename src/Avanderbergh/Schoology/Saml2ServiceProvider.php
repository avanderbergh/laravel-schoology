<?php namespace Avanderbergh\Schoology;

use OneLogin_Saml2_Auth;
use URL;
use Illuminate\Support\ServiceProvider;

class Saml2ServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * publish the saml_settings file to the config_path
         */
         $this->publishes([
             __DIR__.'/../../config/saml2_settings.php' => config_path('saml2_settings.php'),
             __DIR__.'/../../migrations/create_oauth_stores_table.php' => database_path('migrations/create_oauth_stores_table.php')
         ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('Avanderbegh\Schoology\Saml2Auth', function ($app) {

            $config = config('saml2_settings');

            $config['sp']['entityId'] = URL::route('saml_metadata');

            $config['sp']['assertionConsumerService']['url'] = URL::route('saml_acs');

            $config['sp']['singleLogoutService']['url'] = URL::route('saml_sls');

            $auth = new OneLogin_Saml2_Auth($config);

            return new Saml2Auth($auth);

        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
