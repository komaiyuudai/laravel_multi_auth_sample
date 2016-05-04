<?php

namespace App\Http\Controllers\AdminAccount;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
// form使うため
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

    // ガード名指定（必須）
    protected $broker = "admin_accounts";
    // 
    protected $redirectPath = "/";

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
     * パスワード変更フォーム
     * view変更の為
     */
    public function showLinkRequestForm()
    {
        // レイアウトでguard使用している為、アサインしておく
        if (property_exists($this, 'linkRequestView')) {
            return view($this->linkRequestView, [
                'guard' => $this->broker,
            ]);
        }

        if (view()->exists('admin_accounts.passwords.email')) {
            return view('admin_accounts.passwords.email', [
                'guard' => $this->broker,
            ]);
        }

        return view('admin_accounts.password', [
            'guard' => $this->broker,
        ]);
    }

    /**
     * メール送信フォーム
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

        if (view()->exists('admin_accounts.passwords.reset')) {
            return view('admin_accounts.passwords.reset')->with(compact('token', 'email', 'guard'));
        }

        return view('admin_accounts.reset')->with(compact('token', 'email'));
    }
}
