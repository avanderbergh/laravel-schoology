<?php

namespace Avanderbergh\Schoology;

use Illuminate\Database\Eloquent\Model;

class OAuthStore extends Model
{
    protected $fillable = [
        'id',
        'token_key',
        'token_secret',
        'token_is_access',
    ];

    protected $table = 'oauth_store';
}
