@extends('layouts.front')

@section('subtitle', 'Must Verify Email')

@section('content')
    
    <!-- Titlebar ================================================== -->
    <x-front.title-bar title="Must Verify Email" previous="Home" previousUrl="{{ route('home') }}" />

    <!-- Content ================================================== -->

    <!-- Container -->
    <div class="container">

        <div class="my-account">

            <div class="tabs-container">
                <!-- Login -->
                <div class="tab-content" id="tab1" style="display: none;">

                    <h3 class="margin-bottom-10 margin-top-10">Must Verify Email</h3>

                    <div class="text-center">Check your email and click on the link within to verify your email. <a href="{{ route('verification.resend') }}">Click here if you have not receive the link</a>.</div>

                </div>
            </div>
        </div>
    </div>

@endsection