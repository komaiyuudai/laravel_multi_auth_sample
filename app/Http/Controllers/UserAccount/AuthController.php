<?php

namespace App\Http\Controllers\UserAccount;

use Illuminate\Http\Request;

use App\UserAccount;
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

    // ThrottlesLogins = ログイン制限機能
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $guard = 'user_accounts';
    // ログイン後のリダイレクト先
    protected $redirectTo = '/user/index';
    // ログアウト後のリダイレクト先
    protected $redirectAfterLogout = '/';
    // ログインとなるDBの項目名
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
            'email' => 'required|email|max:255|unique:user_accounts',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return UserAccount::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * テンプレートの場所を変える
     */
    public function showLoginForm()
    {
        return view('user_accounts.login', [
            'guard' => $this->guard,
        ]);
    }

    public function showRegistrationForm()
    {
        return view('user_accounts.register', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * 退会
     */
    public function withdrawal()
    {
        return view('user_accounts.withdrawal', [
            'guard' => $this->guard,
        ]);
    }

    /**
     * 会員削除
     */
    public function userDelete()
    {
        $user = Auth::guard($this->guard)->user();
        UserAccount::where('id', $user->id)->delete();
        return redirect('user/logout');
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
            UserAccount::where('id', Auth::guard($this->guard)->user()->id)->update(['last_login_time' => $date]);

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // ログインロック
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

}
