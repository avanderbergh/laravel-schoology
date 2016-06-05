<?php

Route::group(['prefix' => 'saml'], function () {

    Route::post('/acs', [
        'as' => 'saml_acs',
        'uses' => 'Avanderbergh\Schoology\Http\Controllers\Saml2Controller@acs', ]);

    Route::get('/authorize', [
        'as' => 'saml_authorize',
        'uses' => 'Avanderbergh\Schoology\Http\Controllers\Saml2Controller@authorize',
    ]);

    Route::get('/sls', array(
        'as' => 'saml_sls',
        'uses' => 'Avanderbergh\Schoology\Http\Controllers\Saml2Controller@sls',
    ));

    Route::get('/metadata', array(
        'as' => 'saml_metadata',
        'uses' => 'Avanderbergh\Schoology\Http\Controllers\Saml2Controller@metadata',
    ));

});
