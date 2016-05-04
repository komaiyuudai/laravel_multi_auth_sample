<!DOCTYPE html>
<html>
    <head>
        <title>Multi Auth Test</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
                margin-bottom: 20px;
            }
            .login_test{
                font-size: 40px;
                margin-right: 10px;
                margin-left: 10px;
            }
            .logout_test{
                font-size: 20px;
                margin-right: 10px;
                margin-left: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Login</div>
                @if (Auth::guard('user_accounts')->guest())
                    <a class="login_test" href="user/login">User Login</a>
                @else
                    <a class="login_test" href="user/index">User Home</a>
                @endif
                @if (Auth::guard('client_accounts')->guest())
                    <a class="login_test" href="client/login">Client Login</a>
                @else
                    <a class="login_test" href="client/index">Client Home</a>
                @endif
                @if (Auth::guard('admin_accounts')->guest())
                    <a class="login_test" href="admin/login">Admin Login</a>
                @else
                    <a class="login_test" href="admin/index">Admin Home</a>
                @endif
            </div>
        </div>
    </body>
</html>
