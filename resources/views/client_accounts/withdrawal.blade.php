@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Withdrawal</div>

                <div class="panel-body">
                    Are you sure you want to unsubscribe ?
                </div>

                <div class="form">
                    <form action="user_delete" method="post">
                        {!! csrf_field() !!}
                        <input type="submit" value="Yes">
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
