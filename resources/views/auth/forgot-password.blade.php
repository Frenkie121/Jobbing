@extends('layouts.front')

@section('subtitle', 'Password Forgot')

@section('content')
    
    <!-- Titlebar ================================================== -->
    <x-front.title-bar title="Password Forgot" previous="Home" previousUrl="{{ route('home') }}" />

    <!-- Content ================================================== -->

    <!-- Container -->
    <div class="container">

        <div class="my-account">

            <div class="tabs-container">
                <div class="tab-content" id="tab1" style="display: none;">

                    @if (session()->has('status'))
                        <div class="alert alert-success">{{ session()->get('status') }}</div>
                    @endif
                    
                    @if (session()->has('email'))
                        <div class="alert alert-danger h6">
                            <small>{{ session()->get('email') }}</small>
                        </div>
                    @endif
                    <span class="mt-2 mb-4 h6">Fill the form with authenticating email that are using now and we'll send you an email to resetting your password.</span>
                    <form method="post" action="{{ route('password.email') }}" class="login">
                        @csrf
                        @method('POST')
                        
                        <p class="form-row form-row-wide mt-4">
                            <label for="email">Email Address:</label>
                            <input type="email" class="input-text @error('email') is-invalid @else is-valid @enderror" name="email" id="email" value="{{ old('email') }}" />
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