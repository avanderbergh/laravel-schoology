<?php

namespace Avanderbergh\Schoology\Facades;

use Illuminate\Support\Facades\Facade;

class Saml2Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Avanderbergh\Schoology\Saml2Auth';
    }
}
