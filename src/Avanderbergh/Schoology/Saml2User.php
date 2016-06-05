<?php

namespace Avanderbergh\Schoology;

use Input;
use OneLogin_Saml2_Auth;
use URL;

/**
 * A simple class that represents the user that 'came' inside the saml2 assertion
 * Class Saml2User.
 */
class Saml2User
{
    protected $auth;

    public function __construct(OneLogin_Saml2_Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return string User Id retrieved from assertion processed this request
     */
    public function getUserId()
    {
        $auth = $this->auth;

        return $auth->getNameId();
    }

    /**
     * @return array attributes retrieved from assertion processed this request
     */
    public function getAttributes()
    {
        $auth = $this->auth;

        return $auth->getAttributes();
    }

    /**
     * @return string the saml assertion processed this request
     */
    public function getRawSamlAssertion()
    {
        return Input::get('SAMLResponse'); //just this request
    }

    public function getIntendedUrl()
    {
        $relayState = Input::get('RelayState'); //just this request

        if ($relayState && URL::full() != $relayState) {
            return $relayState;
        }
    }
}
