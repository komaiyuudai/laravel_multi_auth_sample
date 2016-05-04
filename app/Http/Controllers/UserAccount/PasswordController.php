<?php

namespace App\Http\Controllers\UserAccount;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public $broker = "user_accounts";
    public $redirectPath = "/";

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * view変更の為
     */
    public function showLinkRequestForm()
    {
        if (property_exists($this, 'linkRequestView')) {
            return view($this->linkRequestView, [
                'guard' => $this->broker,
            ]);
        }

        if (view()->exists('user_accounts.passwords.email')) {
            return view('user_accounts.passwords.email', [
                'guard' => $this->broker,
            ]);
        }

        return view('user_accounts.password', [
            'guard' => $this->broker,
        ]);
    }

    /**
     * view変更の為
     */
    public function showResetForm(Request $request, $token = null)
    {
        $guard = $this->broker;

        if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');

        if (property_exists($this, 'resetView')) {
            return view($this->resetView)->with(compact('token', 'email'));
        }

        if (view()->exists('user_accounts.passwords.reset')) {
            return view('user_accounts.passwords.reset')->with(compact('token', 'email', 'guard'));
        }

        return view('user_accounts.reset')->with(compact('token', 'email'));
    }

}
