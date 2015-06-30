<?php namespace Avanderbergh\Schoology;

use Illuminate\Database\Eloquent\Model;

class OAuthStore extends Model {

	protected $fillable = [
        'uid',
        'token_key',
        'token_secret',
        'token_is_access'
    ];
}