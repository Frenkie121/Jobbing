@extends('layouts.front')

@section('subtitle', 'Reset Password')

@section('content')
    
    <!-- Titlebar ================================================== -->
    <x-front.title-bar title="Reset Password" previous="Home" previousUrl="{{ route('home') }}" />

    <!-- Content ================================================== -->

    <!-- Container -->
    <div class="container">

        <div class="my-account">

            <div class="tabs-container">
                <div class="tab-content" id="tab1" style="display: none;">

                    @if (session()->has('status'))
                        <div class="alert alert-success">{{ session()->get('status') }}</div>
                    @endif
                    
                    @if (session()->has('error'))
                        <div class="alert alert-danger h6">
                            <small>{{ session()->get('error') }}</small>
                        </div>
                    @endif
                    <span class="mt-2 mb-4 h6">Fill the form to reset your password.</span>
                    <form method="post" action="{{ route('verification.send') }}" class="login">
                        @csrf
                        @method('POST')
                        
                        <p class="form-row form-row-wide mt-4">
                            <label for="email">Email Address:</label>
                            <input type="email" class="input-text @error('email') is-invalid @else is-valid @enderror" name="email" id="email" value="{{ old('email') }}" />
                        </p>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        
                        <p class="form-row form-row-wide mt-4">
                            <label for="password">Password:</label>
                            <input type="password" class="input-text @error('password') is-invalid @else is-valid @enderror" name="password" id="password" value="{{ old('password') }}" />
                        </p>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        
                        <p class="form-row form-row-wide mt-4">
                            <label for="password_confirmation">Confirm password:</label>
                            <input type="password" class="input-text" name="password_confirmation" id="password_confirmation" />
                        </p>

                        <div class="d-flex justify-content-between">
                            <div></div>
                            <p class="form-row">
                                <input type="submit" class="button" name="login" value="Submit" />
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection