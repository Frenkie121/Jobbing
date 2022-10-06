@extends('layouts.front')

@section('subtitle', 'Profile')

@section('content')

@push('css') <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"> @endpush

<!-- Titlebar
================================================== -->
<x-front.title-bar title="My Profile" previous="Home" previousUrl="{{ route('home') }}" />


<!-- Content
================================================== -->
<div class="container">
	
	<!-- Submit Page -->
	<div class="sixteen columns">
        @if (session()->has('success'))
            <div class="alert alert-success text-center">{{ session()->get('success') }}</div>
        @endif
        
        @if ($errors->any())
            @dump($errors)
            <div class="alert alert-danger text-center">Update failed! Please check the form again to see error(s).</div>
        @endif
        
		<div class="submit-page">

			<form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Email -->
                <div class="form">
                    <h5>Your Name</h5>
                    <input class="search-field" type="text" name="name" placeholder="Your full name" value="{{ old('name') ?? $user->name }}"/>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form">
                    <h5>Your Email</h5>
                    <input class="search-field" type="text" name="email" placeholder="mail@example.com" value="{{ old('email') ?? $user->email }}"/>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title -->
                <div class="form">
                    <h5>Professional Title</h5>
                    <input class="search-field" type="text" name="profession" placeholder="e.g. Web Developer" value="{{ old('profession') ?? $freelance->profession }}"/>
                    @error('profession')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Location -->
                <div class="form">
                    <h5>Location</h5>
                    <input class="search-field" type="text" name="location" placeholder="e.g. London, UK" value="{{ old('location') ?? $freelance->location }}"/>
                    @error('location')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Salary -->
                <div class="form">
                    <h5>Desired salary (XAF)</h5>
                    <input class="search-field" type="number" name="salary" placeholder="e.g. 55,000" value="{{ old('salary') ?? $freelance->salary }}"/>
                    @error('salary')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Logo -->
                <div class="form">
                    <h5>Photo <span>(optional)</span></h5>
                    <label class="upload-btn">
                        <input type="file" name="avatar" />
                        <i class="fa fa-upload"></i> Browse
                    </label>
                    <span class="fake-input">No file selected</span>
                    @error('avatar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form">
                    <h5>Description</h5>
                    <textarea class="WYSIWYG" name="description" cols="40" rows="3" id="summary" spellcheck="true">{{ old('description') ?? $freelance->description }}</textarea>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Add URLs -->
                <div class="form with-line">
                    <h5>URL(s) <span>(optional)</span></h5>
                    <div class="form-inside">
                        @if (old('link_name'))
                            @foreach (array_filter(old('link_name')) as $key => $name)
                                <div class="form boxed url-box">
                                    <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                                    <input class="search-field" type="text" placeholder="Name" name="link_name[]" value="{{ $name }}"/>
                                    {{-- @if ($loop->index == ) --}}
                                        @error('link_name.*')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    {{-- @endif --}}
                                    <input class="form-control" type="url" placeholder="http://" name="link_url[]" value="{{ old('link_url')[$key] }}"/>
                                    @error('link_url.*')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        @endif

                        
                        <!-- Adding URL(s) -->
                        <div class="form boxed box-to-clone url-box">
                            <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                            <input class="search-field" type="text" placeholder="Name" name="link_name[]" value=""/>
                            <input class="search-field" type="url" placeholder="http://" name="link_url[]" value=""/>
                        </div>

                        <a href="#" class="button gray add-url add-box"><i class="fa fa-plus-circle"></i> Add URL</a>
                        <p class="note">Optionally provide links to any of your websites or social network profiles.</p>
                    </div>
                    
                    @empty(old('link_name'))
                        @forelse ($links as $link)
                            <div class="form boxed url-box">
                                <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                                <input class="search-field" type="text" placeholder="Name" name="link_name[]" value="{{ old('link_name.*') ?? $link->name }}"/>
                                <input class="search-field" type="url" placeholder="http://" name="link_url[]" value="{{ old('link_url.*') ?? $link->url }}"/>
                            </div>
                        @empty
                        @endforelse
                    @endempty
                    
                </div>

                <!-- Experience  -->
                <div class="form with-line">
                    <h5>Experience <span>(optional)</span></h5>
                    <div class="form-inside">

                        @if (old('company'))
                            @php 
                                $companies = old('company');
                                array_pop($companies); 
                            @endphp
                            @foreach ($companies as $key => $company)
                                <div class="form boxed box-to-clone experience-box">
                                    <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                                    <input class="search-field" type="text" placeholder="Company" name="company[]" value="{{ $company }}" />
                                    <input class="search-field" type="text" placeholder="Job Title" name="job_title[]" value="{{ old('job_title')[$key] }}" />
                                    <input class="search-field" type="date" placeholder="Start date" name="start_at[]" value="{{ old('start_at')[$key] }}" />
                                    <input class="search-field" type="date" placeholder="Start date" name="end_at[]" value="{{ old('end_at')[$key] }}" />
                                    <textarea name="job_description[]" id="desc1" cols="30" rows="10" placeholder="Notes (optional)">{{ old('job_description')[$key] }}</textarea>
                                </div>
                            @endforeach
                        @endif
                        <!-- Add Experience -->
                        <div class="form boxed box-to-clone experience-box">
                            <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                            <input class="search-field" type="text" placeholder="Company" name="company[]" value="" />
                            <input class="search-field" type="text" placeholder="Job Title" name="job_title[]" value />
                            <input class="search-field" type="date" placeholder="Start date" name="start_at[]" value />
                            <input class="search-field" type="date" placeholder="End date" name="end_at[]" value="" />
                            <textarea name="job_description[]" id="desc1" cols="30" rows="10" placeholder="Notes (optional)"></textarea>
                        </div>

                        <a href="#" class="button gray add-experience add-box"><i class="fa fa-plus-circle"></i> Add Experience</a>
                    </div>

                    @forelse ($experiences as $experience)
                        <div class="form boxed experience-box">
                            <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                            <input class="search-field" type="text" placeholder="Company" name="company[]" value="{{ old('company.*') ?? $experience->company }}" />
                            <input class="search-field" type="text" placeholder="Job Title" name="job_title[]" value="{{ old('job_title.*') ?? $experience->job_title }}" />
                            <input class="search-field" type="date" placeholder="Start date" name="start_at[]" value="{{ old('start_at.*') ?? $experience->started_at }}" />
                            <input class="search-field" type="date" placeholder="Start date" name="end_at[]" value="{{ old('end_at.*') ?? $experience->ended_at }}" />
                            <textarea name="job_description[]" id="desc1" cols="30" rows="10" placeholder="Notes (optional)">{{ old('job_description.*') ?? $experience->job_description }}</textarea>
                        </div>
                    @empty
                    @endforelse
                </div>

                <div class="divider margin-top-0 padding-reset"></div>
                <input type="submit" value="Save Changes" class="button big margin-top-5">

            </form>

		</div>
	</div>

</div>
@endsection