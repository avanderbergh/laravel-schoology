<?php

//This is variable is an example - Just make sure that the urls in the 'idp' config are ok.
$idp_host = 'http://localhost:8000/simplesaml';

return $settings = array(
    /*****
     * Cosmetic settings - controller routes
     **/
    'useRoutes' => true, //include library routes and controllers

    'routesPrefix' => '/saml2',

    /*
     * Where to redirect after logout
     */
    'logoutRoute' => '/',

    /*
     * Where to redirect after login if no other option was provided
     */
    'loginRoute' => 'application',

    /*
     * Where to redirect after login if no other option was provided
     */
    'errorRoute' => 'error',

    /*****
     * One Loign Settings
     */

    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them signed or encrypted
    // Also will reject the messages if not strictly follow the SAML
    // standard: Destination, NameId, Conditions ... are validated too.
    'strict' => false, //@todo: make this depend on laravel config

    // Enable debug mode (to print errors)
    'debug' => true, //@todo: make this depend on laravel config

    // Service Provider Data that we are deploying
    'sp' => array(

        // Specifies constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',

        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x509cert' => '',
        'privateKey' > '',

        //LARAVEL - You don't need to change anything else on the sp
        // Identifier of the SP entity  (must be a URI)
        'entityId' => 'saml2/metadata', //LARAVEL: This would be set to saml_metadata route
        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => array(
            // URL Location where the <Response> from the IdP will be returned
            'url' => 'saml2/acs', //LARAVEL: This would be set to saml_acs route
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ),
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        'singleLogoutService' => array(
            // URL Location where the <Response> from the IdP will be returned
            'url' => 'saml2/sls', //LARAVEL: This would be set to saml_sls route
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
    ),

    // Identity Provider Data that we want connect with our SP
    'idp' => array(
        // Identifier of the IdP entity  (must be a URI)
        'entityId' => $idp_host.'/saml2/idp/metadata.php',
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => array(
            // URL Target of the IdP where the SP will send the Authentication Request Message
            'url' => $idp_host.'/saml2/idp/SSOService.php',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-POST binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // SLO endpoint info of the IdP.
        'singleLogoutService' => array(
            // URL Location of the IdP where the SP will send the SLO Request
            'url' => $idp_host.'/saml2/idp/SingleLogoutService.php',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // Public x509 certificate of the IdP
        'x509cert' => 'MIIDHzCCAoigAwIBAgIJAJizWLR+eapYMA0GCSqGSIb3DQEBBQUAMGkxCzAJBgNVBAYTAlVTMREwDwYDVQQIEwhOZXcgWW9yazERMA8GA1UEBxMITmV3IFlvcmsxGDAWBgNVBAoTD1NjaG9vbG9neSwgSW5jLjEaMBgGA1UEAxMRYXBwLnNjaG9vbG9neS5jb20wHhcNMTIwNDI0MDUzMDAxWhcNMjIwNDI0MDUzMDAxWjBpMQswCQYDVQQGEwJVUzERMA8GA1UECBMITmV3IFlvcmsxETAPBgNVBAcTCE5ldyBZb3JrMRgwFgYDVQQKEw9TY2hvb2xvZ3ksIEluYy4xGjAYBgNVBAMTEWFwcC5zY2hvb2xvZ3kuY29tMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDWUfhkC6xhkCY1c/tVBr+KXn+vuz2chZ4k7vML96DeGbtf9++TRUUvVZMD0lVwmqvYZPnIliOdEsZHaydOwJ6icTwL+ILI6UEOUR7xZuPv2pXU8rLwacHhQRetMBuJ4okLBOJd3pcZVJ7mttXvkABSpwpA4ZzjVTqxvHi7T1CgewIDAQABo4HOMIHLMB0GA1UdDgQWBBRKOeb2v2xzQ0QHAX23xGUxN6ex4TCBmwYDVR0jBIGTMIGQgBRKOeb2v2xzQ0QHAX23xGUxN6ex4aFtpGswaTELMAkGA1UEBhMCVVMxETAPBgNVBAgTCE5ldyBZb3JrMREwDwYDVQQHEwhOZXcgWW9yazEYMBYGA1UEChMPU2Nob29sb2d5LCBJbmMuMRowGAYDVQQDExFhcHAuc2Nob29sb2d5LmNvbYIJAJizWLR+eapYMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEA1f+bbhj+NkPGkOG+1t/ziOwMcy9fVR0NewRREaDMpJRoPfnnVk+6BRB3EHKqgyLDZjYStPAMzh8/sElOMShb+pUtrqTVtadBo4nacGeKY+hTAY8FwdgQCNPd5Yp6Tlhzo76+Z0IrBvLA932cJEBWXDwQePVN2ztXaIV0SgD6mPg=',
        /*
         *  Instead of use the whole x509cert you can use a fingerprint
         *  (openssl x509 -noout -fingerprint -in "idp.crt" to generate it)
         */
        // 'certFingerprint' => '',
    ),

    /***
     *
     *  OneLogin advanced settings
     *
     *
     */
    // Security settings
    'security' => array(

        /* signatures and encryptions offered */

        // Indicates that the nameID of the <samlp:logoutRequest> sent by this SP
        // will be encrypted.
        'nameIdEncrypted' => false,

        // Indicates whether the <samlp:AuthnRequest> messages sent by this SP
        // will be signed.              [The Metadata of the SP will offer this info]
        'authnRequestsSigned' => false,

        // Indicates whether the <samlp:logoutRequest> messages sent by this SP
        // will be signed.
        'logoutRequestSigned' => false,

        // Indicates whether the <samlp:logoutResponse> messages sent by this SP
        // will be signed.
        'logoutResponseSigned' => false,

        /* Sign the Metadata
         False || True (use sp certs) || array (
                                                    keyFileName => 'metadata.key',
                                                    certFileName => 'metadata.crt'
                                                )
         */
        'signMetadata' => false,

        /* signatures and encryptions required **/

        // Indicates a requirement for the <samlp:Response>, <samlp:LogoutRequest> and
        // <samlp:LogoutResponse> elements received by this SP to be signed.
        'wantMessagesSigned' => false,

        // Indicates a requirement for the <saml:Assertion> elements received by
        // this SP to be signed.        [The Metadata of the SP will offer this info]
        'wantAssertionsSigned' => false,

        // Indicates a requirement for the NameID received by
        // this SP to be encrypted.
        'wantNameIdEncrypted' => false,

        // Authentication context.
        // Set to false and no AuthContext will be sent in the AuthNRequest,
        // Set true or don't present thi parameter and you will get an AuthContext 'exact' 'urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport'
        // Set an array with the possible auth context values: array ('urn:oasis:names:tc:SAML:2.0:ac:classes:Password', 'urn:oasis:names:tc:SAML:2.0:ac:classes:X509'),
        'requestedAuthnContext' => true,
    ),

    // Contact information template, it is recommended to suply a technical and support contacts
    'contactPerson' => array(
        'technical' => array(
            'givenName' => 'name',
            'emailAddress' => 'no@reply.com',
        ),
        'support' => array(
            'givenName' => 'Support',
            'emailAddress' => 'no@reply.com',
        ),
    ),

    // Organization information template, the info in en_US lang is recomended, add more if required
    'organization' => array(
        'en-US' => array(
            'name' => 'Name',
            'displayname' => 'Display Name',
            'url' => 'http://url',
        ),
    ),

/* Interoperable SAML 2.0 Web Browser SSO Profile [saml2int]   http://saml2int.org/profile/current

   'authnRequestsSigned' => false,    // SP SHOULD NOT sign the <samlp:AuthnRequest>,
                                      // MUST NOT assume that the IdP validates the sign
   'wantAssertionsSigned' => true,
   'wantAssertionsEncrypted' => true, // MUST be enabled if SSL/HTTPs is disabled
   'wantNameIdEncrypted' => false,
 */

);
