@extends('layouts.auth')

@section('content')

<form method="POST" action="{{ route('register') }}">
    @csrf
    <h2 class="text-5xl text-center">BASIC LIFE</h2>
    <h3 class="text-md  text-center  text-2xl mt-7">Login</h3>
    <div class="w-full">
        <label for="name" class=" text-xl text-gray-700 relative top-6 left-2 bg-white">Name</label>
        <input type="text" name="name" id="name" autocomplete="given-name" value="{{old('name')}}"
            class="h-14 p-2 focus:text-lg focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
            style="font-size:20px;">
        @error('name')
        <span class="text-red-300">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="w-full">
        <label for="email" class=" text-xl text-gray-700 relative top-6 left-2 bg-white">Email</label>
        <input type="text" name="email" id="email" autocomplete="given-name" value="{{old('email')}}"
            class="h-14 p-2 focus:text-lg focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
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
            class="h-14 p-1 focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
            style="font-size:20px;">
        @error('password')
        <span class="text-red-300">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div>
        <label for="password-confirm" class=" text-xl text-gray-700 relative top-6 left-2 bg-white">Password</label>
        <input type="password" name="password_confirmation" id="password-confirm" autocomplete="given-name"
            class="h-14 p-1 focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
            style="font-size:20px;">
        @error('password')
        <span class="text-red-300">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <button type="submit"
        class="bg-yellow-100 w-full p-2 rounded-full mt-4 h-14 text-2xl hover:bg-gray-200">REGISTER</button>

    <div class="text-xs text-center mt-4">
        {{ __("have account?") }}
        <a href="/login" class="hover:no-underline font-bold hover:text-gray-400">
            Login</a>
    </div>
</form>





@endsection