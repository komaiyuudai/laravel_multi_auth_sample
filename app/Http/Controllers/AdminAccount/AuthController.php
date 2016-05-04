<?php

namespace App\Http\Controllers\AdminAccount;

use Illuminate\Http\Request;

// model
use App\AdminAccount;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
// ファサード
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

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
    protected $redirectAfterLogout = '/';
    // 認証用のカラム
    protected $username = 'email';
    // ログインスロットルとなるまで最高のログイン失敗回数
    protected $maxLoginAttempts = 5;
    // ログインスロットルとなってからの待ち秒数
    protected $lockoutTime = 60;



    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admin_accounts',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * ユーザー作成時のカラム
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return AdminAccount::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

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
     * 新規登録フォーム
     * テンプレートの場所を変えるため
     */
    public function showRegistrationForm()
    {
        return view('admin_accounts.register', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * 退会
     * 自作する必要あり？
     */
    public function withdrawal()
    {
        return view('admin_accounts.withdrawal', [
            'guard' => $this->guard,
            'user' => Auth::guard($this->guard)->user(),
        ]);
    }

    /**
     * 会員削除
     * 自作する必要あり？
     */
    public function userDelete()
    {
        // 現在の会員情報取得
        $user = Auth::guard($this->guard)->user();
        // ソフトデリート使用
        AdminAccount::where('id', $user->id)->delete();
        // ログアウト処理
        Auth::logout();
        // リダイレクト
        return redirect('/');
    }

    /**
     * ログイン
     */
    public function login(Request $request)
    {
        // バリデート
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        // ログイン処理
        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            $date = date('Y-m-d H:i:s');
            // ログイン時間登録
            AdminAccount::where('id', Auth::guard($this->guard)->user()->id)->update(['last_login_time' => $date]);

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // ログインロック
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

}
