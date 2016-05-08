@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Detail</div>

                <div class="item">
                    <p>Name : {{$user->name}}</a></p>
                </div>

                <div class="item">
                    <p>Email : {{$user->email}}   <a href="edit/email">Edit</a></p>
                </div>

                <div class="item">
                    <p>Password <a href="edit/password">Edit</a></p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
