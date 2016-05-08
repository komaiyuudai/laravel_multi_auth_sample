@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Password</div>

                <div class="form">
                    <form action="register_pass" method="post">
                        {!! csrf_field() !!}
                        <div class="input">
                            <p>before password</p>
                            <input type="password" name="before_pass">
                        </div>
                        <div class="input">
                            <p>after password</p>
                            <input type="password" name="after_pass">
                        </div>
                        <div class="input">
                            <p>after password check</p>
                            <input type="password" name="after_pass_check">
                        </div>
                        <div class="input">
                            <input type="submit" value="Edit">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
