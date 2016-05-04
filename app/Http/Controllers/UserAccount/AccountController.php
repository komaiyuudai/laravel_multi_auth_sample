<?php

namespace App\Http\Controllers\UserAccount;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public $guard = 'user_accounts';
    /**
     * 会員TOPページ
     */
    public function index() {
        return view('user_accounts.index', [
            'guard' => $this->guard,
        ]);
    }
}
