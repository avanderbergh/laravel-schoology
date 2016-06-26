# Laravel Schoology
A Laravel 5 package that provides an easy way to create <a href="https://developers.schoology.com/">Schoology</a> applications using the <a href="http://laravel.com/">Laravel</a> framework.
This package combines modified files from <a href="https://github.com/aacotroneo/laravel-saml2">aacotroneo/laravel-saml2</a> and <a href="https://github.com/schoology/schoology_php_sdk">schoology/schoology_php_sdk</a> into a new package.

# Installation with Composer
Run the following command in your app's root directory ```composer require avanderbergh/laravel-schoology```.

When the installation finishes, add add the following to `config/app.php`.
```php
'providers' => [
    ...
    Avanderbergh\Schoology\Saml2ServiceProvider::class,
    Avanderbergh\Schoology\SchoologyServiceProvider::class,
]
'aliases' => [
    ...
    'Schoology' => Avanderbergh\Schoology\Facades\Schoology::class,
]
```

Once this has been added, run the command `php artisan vendor:publish` to copy the settings and migrations files to your Laravel `config` and `database/migrations` directories.
Now run the command `php artisan migrate` to create the __oauth_store__ and __schoology_users__ tables. These tables are used to store oauth access tokens and user information retrieved from Schoology.

Once the tables have been created, you will need to edit the __config/auth.php__ file.
In the User Providers section, change the `model` key for the `users` provider to ```Avanderbergh\Schoology\SchoologyUser::class,```
The file should now look like this:
```php
...
    ...
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Avanderbergh\Schoology\SchoologyUser::class,
        ],
    ...
...
```
## CSRF Token Verification Middleware
For this package to work, you will need to exclude the 'saml/*' route from Laravel's CSRF verification middleware. Open `app/Http/Middleware/VerifyCsrfToken.php`, and enter 'saml/*' into the ```$except``` array.

###The file should now look like this:

```php
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'saml/*'
    ];
}
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
