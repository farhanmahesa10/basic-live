@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <h2 class="text-5xl text-center">BASIC LIFE</h2>
    <h3 class="text-md  text-center  text-2xl mt-7">Login</h3>
    <div class="w-full">
        <label for="email" class=" text-xl text-gray-700 relative top-6 left-2 bg-white">Email</label>
        <input type="text" name="email" id="email" autocomplete="given-name" value="{{old('email')}}"
            class="mt-1 h-16 p-2 focus:text-lg focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
            style="font-size:20px;">
        @error('email')
        <span class="text-red-300">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div>
        <label for="password" class=" text-xl text-gray-700 relative top-6 left-2 bg-white">Password</label>
        <input type="password" name="password" id="password" autocomplete="given-name"
            class="mt-1 h-16 p-1 focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
            style="font-size:20px;">
        @error('password')
        <span class="text-red-300">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <button class="bg-yellow-100 w-full p-2 rounded-full mt-4 h-14 text-2xl hover:bg-gray-200">LOGIN</button>

    <div class="text-xs text-center mt-4">
        {{ __("Didn't have account?") }}
        <a href="/register" class="hover:no-underline font-bold hover:text-gray-400">
            Register</a>
    </div>
</form>
@endsection

@section('thisIsHiddenForForgotPassword')
<div class="form-group row">
    <div class="col-md-6 offset-md-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ __('Login') }}
        </button>

        @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
        @endif
    </div>
</div>
@endsection