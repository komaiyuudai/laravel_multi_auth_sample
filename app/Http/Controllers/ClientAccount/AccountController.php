<?php

namespace App\Http\Controllers\ClientAccount;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Eloquents\ClientAccount;
use Auth;
use Hash;
use Gate;

class AccountController extends Controller
{
    protected $guard = 'client_accounts';

    /**
     * 会員TOPページ
     */
    public function index() {
        return view('client_accounts.index', [
            'guard' => $this->guard,
            'user'  => Auth::guard($this->guard)->user(),
        ]);
    }

    /**
     * 会員詳細ページ
     */
    public function detail() 
    {
        return view('client_accounts.detail', [
            'guard' => $this->guard,
            'user'  => Auth::guard($this->guard)->user(),
        ]);
    }

    /**
     * メールアドレス編集
     */
    public function editEmail()
    {
        return view('client_accounts.edit.email', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * パスワード編集
     */
    public function editPassword()
    {
        return view('client_accounts.edit.password', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * メールアドレス編集登録
     */
    public function registerEmail(Request $request)
    {
        $user = Auth::guard($this->guard)->user();
        ClientAccount::where('id', $user->id)->update(['email' => $request->email]);
        return redirect('/client/index');
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
        ClientAccount::where('id', $user->id)->update(['password' => $hashPass]);
        return redirect('/client/index');
    }


}
