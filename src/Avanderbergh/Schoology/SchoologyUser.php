<?php

namespace Avanderbergh\Schoology;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SchoologyUser extends Authenticatable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'schoology_users';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['name', 'email', 'username'];
}

