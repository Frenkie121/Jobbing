@extends('layouts.front')

@section('subtitle', 'Email Verification')

@section('content')
    
    <!-- Titlebar ================================================== -->
    <x-front.title-bar title="Email Verification" previous="Home" previousUrl="{{ route('home') }}" />

    <!-- Content ================================================== -->

    <!-- Container -->
    <div class="container">

        <div class="my-account">

            <div class="tabs-container">
                <!-- Login -->
                <div class="tab-content" id="tab1" style="display: none;">

                    <h3 class="margin-bottom-10 margin-top-10">Email Verification</h3>

                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session()->get('message') }}</div>
                    @endif
                    
                    @if (session()->has('error'))
                        <div class="alert alert-danger h6">
                            <small>{{ session()->get('error') }}</small>
                        </div>
                    @endif
                    <span class="mt-2 mb-4 h6">Fill the form with authenticating email that are using now and we'll send you an email for verification.</span>
                    <form method="post" action="{{ route('verification.send') }}" class="login">
                        @csrf
                        @method('POST')
                        
                        <p class="form-row form-row-wide">
                            <label for="email">Email Address:</label>
                            <input type="email" class="input-text @error('email') is-invalid @else is-valid @enderror" name="email" id="email" value="{{ old('email') }}" />
                        </p>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="d-flex justify-content-between">
                            <div></div>
                            <p class="form-row">
                                <input type="submit" class="button" name="login" value="Resend Link" />
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection