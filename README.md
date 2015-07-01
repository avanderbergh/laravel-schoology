# Laravel Schoology
A Laravel 5 package that provides an easy way to create <a href="https://developers.schoology.com/">Schoology</a> applications using the <a href="http://laravel.com/">Laravel</a> framework.
This package combines modified files from <a href="https://github.com/aacotroneo/laravel-saml2">aacotroneo/laravel-saml2</a> and <a href="https://github.com/schoology/schoology_php_sdk">schoology/schoology_php_sdk</a> into a new package.

# Installation with Composer
To install this package please add the following to your __composer.json__ in the Laravel root directory...
```json
"avanderbergh/schoology" : "*"
```
... and run `composer update`. When the installation finishes, add add the following to `app/config/app.php`.
```json
'providers' => [
    ...
    'Avanderbergh\Schoology',
    ...
]
'alias' => [
    ...
    'Saml2'     =>  'Avanderbergh\Schoology\Facades\Saml2Auth',
]
```
Once this has been added, run the command `php artisan vendor:publish` to copy the settings and migrations files to your Laravel `config` and `database/migrations` directories.
Now run a `php artisan migrate` to create the __oauth_store__ table. This table is used to store oauth access tokens so that users don't need to provide authorization every time they make a request.

## CSRF Token Verification Middleware
For this package to work, you will need to disable Laravel's CSRF varification middleware. To do this, open the file `app/Http/Kernel.php`, find the array ```protected $middleware``` and delete the line ```'App\Http\Middleware\VerifyCsrfToken',```.
```php
protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		~~'App\Http\Middleware\VerifyCsrfToken',~~
];
```
# Usage
Set your application's **SAML ACS URL** to `[yourdomain]/saml/acs` in Schoology.

Create the following keys in your `.env` file:
```
CONSUMER_KEY='Your Schoology Oauth Consumer Key'
CONSUMER_SECRET='You Schoology Oauth Consumer Secret'
```

