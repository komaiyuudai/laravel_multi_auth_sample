<?php

namespace App\Http\Controllers\ClientAccount;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public $guard = 'client_accounts';
    /**
     * 会員TOPページ
     */
    public function index() {
        return view('client_accounts.index', [
            'guard' => $this->guard,
        ]);
    }

}
