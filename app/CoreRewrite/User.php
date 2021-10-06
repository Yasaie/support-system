<?php

namespace App\CoreRewrite;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\CoreRewrite\Passwords\CanResetPassword;
use App\CoreRewrite\verify\CanVerify;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, CanVerify;
}
