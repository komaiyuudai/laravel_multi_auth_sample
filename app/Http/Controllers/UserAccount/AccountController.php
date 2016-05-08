<?php

namespace App\Http\Controllers\UserAccount;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Eloquents\UserAccount;
use Auth;
use Hash;
use Gate;

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

    /**
     * 会員詳細ページ
     */
    public function detail() 
    {
        return view('user_accounts.detail', [
            'guard' => $this->guard,
            'user'  => Auth::guard($this->guard)->user(),
        ]);
    }

    /**
     * メールアドレス編集
     */
    public function editEmail()
    {
        return view('user_accounts.edit.email', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * パスワード編集
     */
    public function editPassword()
    {
        return view('user_accounts.edit.password', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * メールアドレス編集登録
     */
    public function registerEmail(Request $request)
    {
        $user = Auth::guard($this->guard)->user();
        UserAccount::where('id', $user->id)->update(['email' => $request->email]);
        return redirect('/user/index');
    }

    /**
     * パスワード編集登録
     */
    public function registerPassword(Request $request)
    {
        $user = Auth::guard($this->guard)->user();
        // 現在のパスワードが一致しているか
        if (!Hash::check($request->before_pass, $user->password)) {
            return redirect()->back();
        }
        // 新しいパスワードが一致しているか
        if ($request->after_pass !== $request->after_pass_check) {
            return redirect()->back();
        }
        // ハッシュパス生成
        $hashPass = Hash::make($request->after_pass);
        UserAccount::where('id', $user->id)->update(['password' => $hashPass]);
        return redirect('/user/index');
    }
}
