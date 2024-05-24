@extends('layout')
@section('content')
<div class="container">
    <h2>Login Form</h2>
    <?php
    var_dump($errors)
    ?>
    < method="post" action="{{ route('login') }}">
        @csrf
        <input type="email" class="form-control" name="email" placeholder="email" required />
        @if ($errors->has('email'))
        <p class="text-danger"> {{$errors->first('email')}}</p>
        @endif
        <input type="text" class="form-control mt-2" name="password" placeholder="password" required />
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

@endsection