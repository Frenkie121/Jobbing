@extends('layouts.front')

@section('subtitle', 'Add Job')

@section('content')

@push('css') <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"> @endpush

@php
    $session = session()->has('data');
    if ($session) {
        $data = session()->get('data');
    }
@endphp

<!-- Titlebar
================================================== -->
<x-front.title-bar title="Add Job {{ $session ? '(Edit)' : '' }}" previous="Home" previousUrl="{{ route('home') }}" />

<div class="container">
    <!-- Submit Page -->
	<div class="sixteen columns">
        
        @if ($errors->any())
            <div class="alert alert-danger text-center">Something was wrong! Please check the form again to see error(s).</div>
        @elseif (session()->has('data'))
            <div class="alert alert-info text-center">You have requested to back here. Edit the form and submit it again for the preview.</div>
        @elseif (session()->has('data_lost'))
            <div class="alert alert-info text-center">{{ session()->get('data_lost') }}</div>
        @endif

		<form action="{{ route('jobs.submit') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="submit-page">

                <!-- Title -->
                <div class="form">
                    <h5>Job Title</h5>
                    <input class="search-field" name="title" type="text" placeholder="e.g. E-commerce backend building" value="{{ old('title') ?? ($session ? $data['title'] : '') }}" />
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Location -->
                <div class="form">
                    <h5>Location <span>(optional)</span></h5>
                    <input class="search-field" name="location" type="text" placeholder="e.g. London" value="{{ 
                        old('location') ??
                        ($session && $data['location'] ? $data['location'] : '') }}"
                    />
                    @error('location')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <p class="note">Leave this blank if the location is not important</p>
                </div>
    
                <!-- Job Type -->
                <div class="form">
                    <h5>Job Type</h5>
                    <select data-placeholder="Select a Job Type" name="type" class="chosen-select-no-single">
                        <option disabled>Select a Job Type</option>
                        @foreach ($types as $key => $type)
                            <option
                                @selected(old('type') == $key || $session && $data['type'] == $key)
                                value="{{ $key }}"
                            >{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Choose Category -->
                <div class="form">
                    <div class="select">
                        <h5>Category</h5>
                        <select data-placeholder="Choose Category" name="sub_category" class="chosen-select-no-single">
                            <option disabled>Select a Job Category</option>
                            @foreach ($sub_categories as $sub_category)
                                <option 
                                    @selected(old('sub_category') == $sub_category->id || $session && $data['sub_category'] == $sub_category->id)
                                    value="{{ $sub_category->id }}"
                                >{{ $sub_category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('sub_category')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Choose Tags -->
                <div class="form">
                    <div class="select">
                        <h5>Tags</h5>
                        <select data-placeholder="Choose Tags" name="tags[]" class="chosen-select" multiple>
                            @foreach ($tags as $tag)
                                <option
                                    @selected(
                                        old('tags') && in_array($tag->id, old('tags'))
                                        || $session && in_array($tag->id, $data['tags'])
                                    )
                                    value="{{ $tag->id }}"
                                >{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('tags')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Description -->
                <div class="form">
                    <h5>Description</h5>
                    <textarea class="WYSIWYG" name="description" cols="40" rows="3" id="summary" spellcheck="true">{{ old('description') ?? ($session ? $data['description'] : '') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Salary -->
                <div class="form">
                    <h5>Salary</h5>
                    <input type="number" name="salary" placeholder="Enter a salary in XAF" value="{{ old('salary') ?? ($session ? $data['salary'] : '') }}">
                    @error('salary')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Duration -->
                <div class="form">
                    <h5>Duration</h5>
                    <input type="number" name="duration" placeholder="Enter a duration in week(s)" value="{{ old('duration') ?? ($session ? $data['duration'] : '') }}">
                    @error('duration')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- TClosing Date -->
                <div class="form">
                    <h5>Closing Date <span>(optional)</span></h5>
                    <input data-role="date" type="date" name="deadline" min="{{ today()->addDay()->format('d-m-Y') }}" placeholder="yyyy-mm-dd" value="{{ old('deadline') ?? ($session ? $data['deadline'] : '') }}">
                    <p class="note">Deadline for new applicants.</p>
                    @error('deadline')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Image -->
                {{-- <div class="form">
                    <h5>Custom Image <span>(optional)</span></h5>
                    <label class="upload-btn">
                        <input type="file" name="image" />
                        <i class="fa fa-upload"></i> Browse
                    </label>
                    <span class="fake-input">No file selected</span>
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div> --}}

                <!-- Add Requirements -->
                <div class="form with-line">
                    <h5>Requirements</h5>
                    <div class="form-inside">
                        @if (old('requirement'))
                            @foreach (array_filter(old('requirement')) as $requirement)
                                <div class="form boxed url-box">
                                    <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                                    <input class="search-field" type="text" placeholder="Name" name="requirement[]" value="{{ $requirement }}"/>
                                </div>
                            @endforeach
                            @error('requirement.*')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        @endif
                        
                        <!-- Adding URL(s) -->
                        <div class="form boxed box-to-clone url-box">
                            <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                            <input class="search-field" type="text" placeholder="e.g. Excellent customer service skills, communication skills, and a happy, smiling attitude are essential." name="requirement[]" value=""/>
                        </div>

                        <a href="#" class="button gray add-url add-box"><i class="fa fa-plus-circle"></i> Add Requirement</a>
                    </div>

                    @empty(old('requirement'))
                        @forelse (array_filter($data['requirement']) as $requirement)
                            <div class="form boxed url-box">
                                <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a>
                                <input class="search-field" type="text" placeholder="Name" name="requirement[]" value="{{ $requirement }}"/>
                            </div>
                        @empty
                        @endforelse
                    @endempty
                </div>
                
                <!-- Company Details -->
                <div class="divider"><h3>Company Details</h3></div>
    
                <!-- Company Name -->
                <div class="form">
                    <h5>Company Name <span>(optional)</span></h5>
                    <input type="text" name="company[name]" placeholder="Enter the name of the company" value="{{ old('company.name') ?? ($session ? $data['company']['name'] : '') }}">
                    @error('company.name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Website -->
                <div class="form">
                    <h5>Website <span>(optional)</span></h5>
                    <input type="url" name="company[url]" placeholder="http://" value="{{ old('company.url') ?? ($session ? $data['company']['url'] : '') }}">
                    @error('company.url')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Tagline -->
                <div class="form">
                    <h5>Tagline <span>(optional)</span></h5>
                    <input type="text" name="company[description]" placeholder="Briefly describe your company" value="{{ old('company.description') ?? ($session ? $data['company']['description'] : '') }}">
                    @error('company.description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="divider margin-top-0"></div>
                <button type="submit" class="button big margin-top-5">Save <i class="fa fa-arrow-circle-right"></i></button>
    
            </div>
        </form>
	</div>
</div>
@endsection