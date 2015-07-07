# Laravel Schoology
A Laravel 5 package that provides an easy way to create <a href="https://developers.schoology.com/">Schoology</a> applications using the <a href="http://laravel.com/">Laravel</a> framework.
This package combines modified files from <a href="https://github.com/aacotroneo/laravel-saml2">aacotroneo/laravel-saml2</a> and <a href="https://github.com/schoology/schoology_php_sdk">schoology/schoology_php_sdk</a> into a new package.

# Installation with Composer
To install this package please add the following to your __composer.json__ in the Laravel root directory...
```json
"avanderbergh/laravel-schoology" : "*"
```
... and run `composer update`. When the installation finishes, add add the following to `app/config/app.php`.
```
'providers' => [
    ...
    Avanderbergh\Schoology\Saml2ServiceProvider::class,
    Avanderbergh\Schoology\SchoologyServiceProvider::class,
]
'alias' => [
    ...
    'Schoology' => Avanderbergh\Schoology\Facades\Schoology::class
]
```
Once this has been added, run the command `php artisan vendor:publish` to copy the settings and migrations files to your Laravel `config` and `database/migrations` directories.
Now run the command `php artisan migrate` to create the __oauth_store__ and __schoology_users__ tables. These tables are used to store oauth access tokens and user information retrieved from Schoology.

## CSRF Token Verification Middleware
For this package to work, you will need to disable Laravel's CSRF varification middleware. To do this, open the file `app/Http/Kernel.php`, find the array ```protected $middleware``` and delete the line ```'App\Http\Middleware\VerifyCsrfToken',```.
The file should now look like this:
```php
protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
];
```
# Usage
Set your application's **SAML ACS URL** to `[yourdomain]/saml/acs` in Schoology.

Create the following keys in your `.env` file:
```
CONSUMER_KEY='Your Schoology Oauth Consumer Key'
CONSUMER_SECRET='You Schoology Oauth Consumer Secret'
```

Create a route and enter that as your App URL in the Schoology App Center. The user will be routed to this URL once they have been authenticated.

Now, to make API calls to Schoology, simply use the registered Facade for ```php Schoology ```. Use the line ```php Schoology::authorize(); ```` to authorize. You can now make API calls using, for example, ```php` $users = Schoology::apiResult('users'); ```.
That's it!