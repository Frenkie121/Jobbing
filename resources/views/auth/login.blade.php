@extends('layouts.front')

@section('subtitle', 'Login')

@section('content')
    
    <!-- Titlebar ================================================== -->
    <x-front.title-bar title="Login" previous="Home" previousUrl="{{ route('home') }}" />

    <!-- Content ================================================== -->

    <!-- Container -->
    <div class="container">

        <div class="my-account">

            <div class="tabs-container">
                <!-- Login -->
                <div class="tab-content" id="tab1" style="display: none;">

                    <h3 class="margin-bottom-10 margin-top-10">Login</h3>

                    @if (session()->has('account_disabled'))
                        <div class="alert alert-danger">{{ session()->get('account_disabled') }}</div>
                    @endif

                    <form method="post" action="{{ route('login') }}" class="login">
                        @csrf
                        @method('POST')
                        
                        <p class="form-row form-row-wide">
                            <label for="email">Email Address:</label>
                            <input type="email" class="input-text @error('email') is-invalid @else is-valid @enderror" name="email" id="email" value="{{ old('email') }}" />
                        </p>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <p class="form-row form-row-wide">
                            <label for="password">Password:</label>
                            <input class="input-text @error('password') is-invalid @else is-valid @enderror" type="password" name="password" id="password" />
                        </p>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        
                        <label for="rememberme" class="rememberme">
                        <input name="rememberme" type="checkbox" id="rememberme" @checked(old('rememberme')) /> Remember Me</label>

                        <p class="form-row">
                            <input type="submit" class="button" name="login" value="Login" />
                        </p>
                    </form>

                    <p class="lost_password">
                        <a href="#">Lost Your Password?</a>
                    </p>
                    
                    <div class="">
                        <span>Or use one of the following drivers:</span>
                        <ul class="social-icons">
                            @foreach ($drivers as $key => $driver)
                                <li><a class="{{ $key }}" href="#"><i class="icon-{{ $key }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection