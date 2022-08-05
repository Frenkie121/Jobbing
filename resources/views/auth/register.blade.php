@extends('layouts.front')

@section('subtitle', 'Register')

@section('content')
    
    <!-- Titlebar ================================================== -->
    <x-front.title-bar title="Register" previous="Home" previous_url="{{ route('home') }}" />
    
    <!-- Content ================================================== -->

    <!-- Container -->
    <div class="container">

        <div class="my-account">

            <div class="tabs-container">
                <div class="tab-content" id="tab2" style="display: none;">

                    <form action="{{ route('register') }}" method="post" class="register">
                        @csrf
                        @method('POST')
                        
                        <p class="form-row form-row-wide">
                            <label for="name">Full Name:</label>
                            <input type="name" class="form-control @error('name') is-invalid @else is-valid @enderror" name="name" id="name" value="{{ old('name') }}" />
                        </p>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        
                        <p class="form-row form-row-wide">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control @error('email') is-invalid @else is-valid @enderror" name="email" id="email" value="{{ old('email') }}" />
                        </p>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        
                        <p class="form-row form-row-wide">
                            <label for="reg_password">Password:</label>
                            <input type="password" class="form-control @error('password') is-invalid @else is-valid @enderror" name="password" id="reg_password" />
                        </p>
                        @error('password')
                            <div class="alert text-danger">{{ $message }}</div>
                        @enderror

                        <p class="form-row form-row-wide">
                            <label for="reg_password2">Repeat Password:</label>
                            <input type="password" class="form-control" name="password_confirmation" id="reg_password2" />
                        </p>

                        @foreach ($roles as $role)
                            <input type="radio" name="role" id="{{ $role->name }}" value="{{ $role->id }}" @checked(old('role', $role->id))>
                            <label for="{{ $role->name }}" class="ml-2">{{ $role->name }}</label>
                        @endforeach
                        @error('role')
                            <div class="alert text-danger">{{ $message }}</div>
                        @enderror

                        <div class="d-flex justify-content-between">
                            <div></div>
                            <p class="form-row">
                                <input type="submit" class="button" value="Register" />
                            </p>
                        </div>
                    </form>
                    <div class="d-flex justify-content-right">
                        <span>Already have an account? <a href="{{ route('login') }}">Click here to sign in</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection