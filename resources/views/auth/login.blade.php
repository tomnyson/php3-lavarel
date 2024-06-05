<style>
.form {
    max-width: 500px;
    margin: 0 auto
}
</style>
@extends('layout')
@section('content')

<div class="col col-md-12">
    <div class="form">
        <h2>Login</h2>
        <form method="post" action="{{ route('login') }}">
            @csrf
            <input type="email" class="form-control" name="email" placeholder="email" required />
            @if ($errors->has('email'))
            <p class="text-danger"> {{$errors->first('email')}}</p>
            @endif
            <input type="password" class="form-control mt-2" name="password" placeholder="password" required />
            @if ($errors->has('password'))
            <p class="text-danger"> {{$errors->first('password')}}</p>
            @endif
            <button type="submit" class="btn btn-primary full-width mt-2">Login</button>
            <br />
            <a href="{{route('register')}}">Register new Account</a>
            </br>
            <a href="{{route('password.request')}}">Forgot password</a>
        </form>

    </div>

</div>
@endsection