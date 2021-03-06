<?php

namespace App\Http\Controllers\ClientAccount;

use Illuminate\Http\Request;

use App\Eloquents\ClientAccount;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
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
    protected $guard = 'client_accounts';                   // 使用するguard名(デフォルトはauth.phpのデフォルト設定してあるguard)
    protected $registerView = 'client_accounts.register';   // 新規登録画面のview(デフォルトは「auth.register」)
    protected $loginView = 'client_accounts.login';         // ログインページのview(デフォルトは「auth.authenticate」)
    protected $redirectTo = '/client/index';                // ログイン後のリダイレクト先(デフォルトは「/home」)
    protected $redirectAfterLogout = '/';                   // ログアウト後のリダイレクト先(デフォルトは「/」)
    protected $username = 'email';                          // 認証用のカラム(デフォルトは「email」)
    protected $maxLoginAttempts = 5;                        // ログインスロットルとなるまで最高のログイン失敗回数(デフォルトは「5」)
    protected $lockoutTime = 60;                            // ログインスロットルとなってからの待ち秒数(デフォルトは60)



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
            'email' => 'required|email|max:255|unique:client_accounts,email,NULL,id,deleted_at,NULL',
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
        return ClientAccount::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * ログインフォーム
     */
    public function showLoginForm()
    {
        return view('client_accounts.login', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * 新規登録フォーム
     */
    public function showRegistrationForm()
    {
        return view($this->registerView, [
            'guard' => $this->guard,
        ]);
    }

    /**
     * 退会
     */
    public function withdrawal()
    {
        return view('client_accounts.withdrawal', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * 会員削除
     */
    public function userDelete()
    {
        $user = Auth::guard($this->guard)->user();
        ClientAccount::where('id', $user->id)->delete();
        return redirect('client/logout');
    }

    /**
     * ログイン
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            $date = date('Y-m-d H:i:s');
            ClientAccount::where('id', Auth::guard($this->guard)->user()->id)->update(['last_login_time' => $date]);

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
