@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Email</div>

                <div class="form">
                    <form action="register_email" method="post">
                        {!! csrf_field() !!}
                        <input type="email" name="email">
                        <input type="submit" value="edit">
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
