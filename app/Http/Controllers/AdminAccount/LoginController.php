<?php

namespace App\Http\Controllers\AdminAccount;

use Illuminate\Http\Request;

// model
use App\AdminAccount;
use Validator;
use App\Http\Controllers\Controller;
// ファサード
use Auth;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    // 使用するガード名
    protected $guard = 'admin_accounts';
    // ログイン後のリダイレクト先
    protected $redirectTo = '/admin/index';
    // ログアウト後のリダイレクト先
    protected $redirectAfterLogout = '/test';
    // 認証用のカラム
    protected $username = 'email';
    // ログインスロットルとなるまで最高のログイン失敗回数
    protected $maxLoginAttempts = 5;
    // ログインスロットルとなってからの待ち秒数
    protected $lockoutTime = 60;

    /**
     * ログインフォーム
     * テンプレートの場所を変える為
     */
    public function showLoginForm()
    {
        return view('admin_accounts.login', [
            'guard' => $this->guard,
        ]);
    }


    /**
     * ログイン
     */
    public function login(Request $request)
    {
        $checked = [
            'email'     => $request->email,
            'password'  => $request->password,
        ];

        if (Auth::guard($this->guard)->attempt($checked)) {
            return redirect($this->redirectTo);
        }

        return redirect()->back();
    }

}
