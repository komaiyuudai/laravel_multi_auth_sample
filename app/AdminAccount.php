<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// ソフトデリート
use Illuminate\Database\Eloquent\SoftDeletes;
// 以下Auth使用時必須
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class AdminAccount extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    // Auth用、ソフトデリート用のトレイト使用
    use Authenticatable, CanResetPassword, SoftDeletes, Authorizable;

    protected $table = 'admin_accounts';
    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
}
