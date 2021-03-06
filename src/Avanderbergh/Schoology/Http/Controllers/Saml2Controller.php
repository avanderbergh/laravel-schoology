<?php

namespace Avanderbergh\Schoology\Http\Controllers;

use App\Http\Controllers\Controller;
use Avanderbergh\Schoology\Facades\Schoology;
use Avanderbergh\Schoology\Saml2Auth;
use Avanderbergh\Schoology\SchoologyUser;
use Mockery\CountValidator\Exception;
use Request;
use Redirect;
use Auth;
use Input;

class Saml2Controller extends Controller
{
    protected $saml2Auth;

    /**
     * @param Saml2Auth $saml2Auth injected.
     */
    public function __construct(Saml2Auth $saml2Auth)
    {
        $this->saml2Auth = $saml2Auth;
    }

    /**
     * Generate local sp metadata.
     *
     * @return \Illuminate\Http\Response
     */
    public function metadata()
    {
        $metadata = $this->saml2Auth->getMetadata();
        $response = Response::make($metadata, 200);

        $response->header('Content-Type', 'text/xml');

        return $response;
    }

    /**
     * Process an incoming saml2 assertion request.
     * Fires 'saml2.loginRequestReceived' event if a valid user is Found.
     */
    public function acs()
    {
        $errors = $this->saml2Auth->acs();
        if (!empty($errors)) {
            throw new Exception('SAML ACS produced errors!');
        }
        $user = $this->saml2Auth->getSaml2User();

        $userAttributes = $user->getAttributes();
        foreach ($userAttributes as $key => $attribute) {
            $schoology_user[$key] = $attribute[0];
        }
        $schoology_user['timestamp'] = time();
        $schoology_user['app_url'] = Request::get('RelayState');
        session(['schoology' => $schoology_user]);
        $redirectUrl = Schoology::authorize();

        return Redirect::secure($redirectUrl);
    }

    /**
     * @param null  $ability
     * @param array $arguments
     *
     * @return mixed
     */
    public function authorize($ability = null, $arguments = array())
    {
        $uid = session('schoology')['uid'];
        Schoology::authorize();
        $apiResult = Schoology::apiResult('users/'.$uid);
        $user = SchoologyUser::findOrNew($apiResult->uid);
        $user->id = $apiResult->uid;
        $user->name = $apiResult->name_display;
        $user->email = $apiResult->primary_email;
        $user->username = $apiResult->username;
        $user->save();
        Auth::loginUsingId($apiResult->uid);
        $redirect = session('schoology')['app_url'];

        return Redirect::secure($redirect);
    }

    /**
     * Process an incoming saml2 logout request.
     * Fires 'saml2.logoutRequestReceived' event if its valid.
     * This means the user logged out of the SSO infrastructure, you 'should' log him out locally too.
     */
    public function sls()
    {
        $error = $this->saml2Auth->sls();
        if (!empty($error)) {
            throw new \Exception('Could not log out');
        }

        return Redirect::secure('/');
    }

    /**
     * This initiates a logout request across all the SSO infrastructure.
     */
    public function logout()
    {
        $this->saml2Auth->logout(); //will actually end up in the sls endpoint
        //does not return
    }

    /**
     * This initiates a login request.
     */
    public function login()
    {
        $this->saml2Auth->login();
    }
}
