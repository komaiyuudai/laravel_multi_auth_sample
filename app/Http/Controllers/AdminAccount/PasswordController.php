<?php

namespace App\Http\Controllers\AdminAccount;

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

    protected $guard = 'admin_accounts';                            // auth.guard設定(デフォルトはauth.phpでデフォルト設定したguard)
    protected $broker = 'admin_accounts';                           // auth.passwords設定('デフォルトはauth.phpでデフォルト設定したpasswords')
    protected $linkRequestView = 'admin_accounts.passwords.email';  // メールアドレス入力view(デフォルトは「auth.passwords.email」)
    protected $resetView = 'admin_accounts.passwords.reset';        // パスワードリセットページview(デフォルトは「auth.passwords.reset」or「auth.reset」)
    protected $subject = 'Password Reset';                          // リセットリンクメールの件名(デフォルトは「Your Password Reset Link」)
    protected $redirectTo = '/';                                    // パスワード変更後のリダイレクト先(デフォルトは「/home」)

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
     */
    public function showLinkRequestForm()
    {
        return view($this->linkRequestView, [
            'guard' => $this->guard,
        ]);
    }

    /**
     * メール送信フォーム
     */
    public function showResetForm(Request $request, $token = null)
    {
        $guard = $this->guard;

        if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');

        return view($this->resetView)->with(compact('token', 'email', 'guard'));
    }
}
