<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'user_accounts',
        'passwords' => 'user_accounts',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],

        'users' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin_accounts' => [
            'driver' => 'session',
            'provider' => 'admin_accounts',
        ],

        'client_accounts' => [
            'driver' => 'session',
            'provider' => 'client_accounts',
        ],

        'user_accounts' => [
            'driver' => 'session',
            'provider' => 'user_accounts',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'admin_accounts' => [
            'driver' => 'eloquent',
            'model' => App\Eloquents\AdminAccount::class,
        ],

        'client_accounts' => [
            'driver' => 'eloquent',
            'model' => App\Eloquents\ClientAccount::class,
        ],

        'user_accounts' => [
            'driver' => 'eloquent',
            'model' => App\Eloquents\UserAccount::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Here you may set the options for resetting passwords including the view
    | that is your password reset e-mail. You may also set the name of the
    | table that maintains all of the reset tokens for your application.
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'admin_accounts' => [
            'provider' => 'admin_accounts',
            'email' => 'admin_accounts.emails.password',
            'table' => 'admin_account_password_resets',
            'expire' => 60,
        ],
        'client_accounts' => [
            'provider' => 'client_accounts',
            'email' => 'client_accounts.emails.password',
            'table' => 'client_account_password_resets',
            'expire' => 60,
        ],
        'user_accounts' => [
            'provider' => 'user_accounts',
            'email' => 'user_accounts.emails.password',
            'table' => 'user_account_password_resets',
            'expire' => 60,
        ],
    ],

];
