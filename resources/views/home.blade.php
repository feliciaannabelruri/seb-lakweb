@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Welcome to Seblak Order System</h2>
        @auth
            <p>You are logged in!</p>
        @else
            <p>Please login to place an order.</p>
        @endauth
    </div>
</div>
@endsection