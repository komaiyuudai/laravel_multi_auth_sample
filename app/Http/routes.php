<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/



Route::group(['middleware' => ['web']], function () {
# TOP
    Route::get('/', function () {
        return view('index');
    });
 
    # 管理者アカウント
    Route::group(['prefix' => 'admin'], function() {
        # 未ログイン時
        Route::group(['middleware' => 'guest:admin_accounts'], function() {
            Route::get('login', 'AdminAccount\AuthController@showLoginForm');
            Route::post('login', 'AdminAccount\AuthController@login');
 
            // 新規登録フォーム
            Route::get('register', 'AdminAccount\AuthController@showRegistrationForm');
            // 新規登録処理
            Route::post('register', 'AdminAccount\AuthController@register');
 
            // パスワードリセットフォーム
            Route::get('password/reset/{token?}', 'AdminAccount\PasswordController@showResetForm');
            // メール送信フォーム
            Route::post('password/email', 'AdminAccount\PasswordController@sendResetLinkEmail');
            // メール送信フォーム
            Route::post('password/reset', 'AdminAccount\PasswordController@reset');
        });
 
        # ログイン時
        Route::group(['middleware' => 'auth:admin_accounts'], function() {
            // 会員トップページ
            Route::get('index', 'AdminAccount\AccountController@index');
            // 会員詳細ページ
            Route::get('detail', 'AdminAccount\AccountController@detail');
            // ログアウト処理
            Route::get('logout', 'AdminAccount\AuthController@logout');
            // 退会ページ
            Route::get('withdrawal', 'AdminAccount\AuthController@withdrawal');
            // 退会処理
            Route::post('user_delete', 'AdminAccount\AuthController@userDelete');
            
            # 編集処理
            Route::group(['prefix' => 'edit'], function(){
                // メールアドレス
                Route::get('email', 'AdminAccount\AccountController@editEmail');
                Route::post('register_email', 'AdminAccount\AccountController@registerEmail');
                // パスワード
                Route::get('password', 'AdminAccount\AccountController@editPassword');
                Route::post('register_pass', 'AdminAccount\AccountController@registerPassword');
            });
        });
    });
 
    # クライアントアカウント
    Route::group(['prefix' => 'client'], function() {
        # 未ログイン時
        Route::group(['middleware' => 'guest:client_accounts'], function() {
 
            Route::get('login', 'ClientAccount\AuthController@showLoginForm');
            Route::post('login', 'ClientAccount\AuthController@login');
 
            Route::get('register', 'ClientAccount\AuthController@showRegistrationForm');
            Route::post('register', 'ClientAccount\AuthController@register');
 
            Route::get('password/reset/{token?}', 'ClientAccount\PasswordController@showResetForm');
            Route::post('password/email', 'ClientAccount\PasswordController@sendResetLinkEmail');
            Route::post('password/reset', 'ClientAccount\PasswordController@reset');
        });
        # ログイン時
        Route::group(['middleware' => 'auth:client_accounts'], function() {
            Route::get('index', 'ClientAccount\AccountController@index');
            Route::get('detail', 'ClientAccount\AccountController@detail');
            Route::get('logout', 'ClientAccount\AuthController@logout');
            Route::get('withdrawal', 'ClientAccount\AuthController@withdrawal');
            Route::post('user_delete', 'ClientAccount\AuthController@userDelete');

            # 編集処理
            Route::group(['prefix' => 'edit'], function(){
                Route::get('email', 'ClientAccount\AccountController@editEmail');
                Route::post('register_email', 'ClientAccount\AccountController@registerEmail');
                Route::get('password', 'ClientAccount\AccountController@editPassword');
                Route::post('register_pass', 'ClientAccount\AccountController@registerPassword');
            });
        });
    });
 
    # ユーザーアカウント
    Route::group(['prefix' => 'user'], function() {
        # 未ログイン時
        Route::group(['middleware' => 'guest:user_accounts'], function() {
 
            Route::get('login', 'UserAccount\AuthController@showLoginForm');
            Route::post('login', 'UserAccount\AuthController@login');
 
            Route::get('register', 'UserAccount\AuthController@showRegistrationForm');
            Route::post('register', 'UserAccount\AuthController@register');
 
            Route::get('password/reset/{token?}', 'UserAccount\PasswordController@showResetForm');
            Route::post('password/email', 'UserAccount\PasswordController@sendResetLinkEmail');
            Route::post('password/reset', 'UserAccount\PasswordController@reset');
        });
 
        # ログイン時
        Route::group(['middleware' => 'auth:user_accounts'], function() {
            Route::get('index', 'UserAccount\AccountController@index');
            Route::get('detail', 'UserAccount\AccountController@detail');
            Route::get('logout', 'UserAccount\AuthController@logout');
            Route::get('withdrawal', 'UserAccount\AuthController@withdrawal');
            Route::post('user_delete', 'UserAccount\AuthController@userDelete');

            # 編集処理
            Route::group(['prefix' => 'edit'], function(){
                Route::get('email', 'UserAccount\AccountController@editEmail');
                Route::post('register_email', 'UserAccount\AccountController@registerEmail');
                Route::get('password', 'UserAccount\AccountController@editPassword');
                Route::post('register_pass', 'UserAccount\AccountController@registerPassword');
            });
        });
    });
});


