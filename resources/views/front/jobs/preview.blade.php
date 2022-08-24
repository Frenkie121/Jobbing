@extends('layouts.front')

@section('subtitle', 'Job Preview')

@section('content')

@push('css') <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"> @endpush

<!-- Titlebar
================================================== -->
<x-front.title-bar title="Add Job (Preview)" previous="Home" previousUrl="{{ route('home') }}" />

<div class="container">
    <!-- Submit Page -->
	<div class="sixteen columns">

        <div class="alert alert-success text-center">Last step! Welcome to preview of creating your job. Just re-check the form before submit it or going back if something to change.</div>

		<form action="{{ route('jobs.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="submit-page">

                <!-- Title -->
                <div class="form">
                    <h5>Job Title</h5>
                    <input class="search-field" name="title" type="text" placeholder="e.g. E-commerce backend building" value="{{ $data['title'] }}" readonly />
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Location -->
                <div class="form">
                    <h5>Location <span>(optional)</span></h5>
                    <input class="search-field" name="location" type="text" placeholder="e.g. London" value="{{ $data['location'] }}" readonly />
                    @error('location')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <p class="note">Leave this blank if the location is not important</p>
                </div>
    
                <!-- Job Type -->
                <div class="form">
                    <h5>Job Type</h5>
                    <select data-placeholder="Select a Job Type" name="type" class="chosen-select-no-single" disabled>
                        <option disabled>Select a Job Type</option>
                        @foreach ($types as $key => $type)
                            <option
                                @selected($data['type'] == $type)
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
                        <select data-placeholder="Choose Category" name="sub_category" class="chosen-select-no-single" disabled>
                            <option disabled>Select a Job Category</option>
                            @foreach ($sub_categories as $sub_category)
                                <option 
                                    @selected($data['sub_category'] == $sub_category->id)
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
                        <select data-placeholder="Choose Tags" name="tags[]" class="chosen-select" multiple disabled>
                            @foreach ($tags as $tag)
                                <option
                                    @selected(in_array($tag->id, $data['tags']))
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
                    <textarea class="WYSIWYG" name="description" cols="40" rows="3" id="summary" spellcheck="true" readonly>{{ $data['description'] }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Salary -->
                <div class="form">
                    <h5>Salary</h5>
                    <input type="number" name="salary" placeholder="Enter a salary in XAF" value="{{ $data['salary'] }}" readonly>
                    @error('salary')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Duration -->
                <div class="form">
                    <h5>Duration</h5>
                    <input type="number" name="duration" placeholder="Enter a duration in week(s)" value="{{ $data['duration'] }}" readonly>
                    @error('duration')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- TClosing Date -->
                <div class="form">
                    <h5>Closing Date <span>(optional)</span></h5>
                    <input data-role="date" type="date" name="deadline" placeholder="yyyy-mm-dd" value="{{ $data['deadline'] }}" readonly>
                    <p class="note">Deadline for new applicants.</p>
                    @error('deadline')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Image -->
                {{-- <div class="form">
                    <h5>Custom Image <span>(optional)</span></h5>
                    @isset ($data['image'])
                        <img src="{{ '' }}" alt="{{ $data['title'] }}">
                    @endisset
                </div> --}}

                <!-- Add Requirements -->
                <div class="form with-line">
                    <h5>Requirements</h5>
                    <div class="form-inside">
                        @foreach (array_filter($data['requirement']) as $requirement)
                            <div class="form boxed url-box">
                                {{-- <a href="#" class="close-form remove-box button"><i class="fa fa-close"></i></a> --}}
                                <input class="search-field" type="text" placeholder="Name" name="requirement[]" value="{{ $requirement }}"/>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Company Details -->
                <div class="divider"><h3>Company Details</h3></div>
    
                <!-- Company Name -->
                <div class="form">
                    <h5>Company Name</h5>
                    <input type="text" name="company[name]" placeholder="Enter the name of the company" value="{{ $data['company']['name'] }}" readonly>
                </div>
    
                <!-- Website -->
                <div class="form">
                    <h5>Website <span>(optional)</span></h5>
                    <input type="url" name="company[url]" placeholder="http://" value="{{ $data['company']['url'] }}" readonly>
                </div>
    
                <!-- Tagline -->
                <div class="form">
                    <h5>Tagline <span>(optional)</span></h5>
                    <input type="text" name="company[description]" placeholder="Briefly describe your company" value="{{ $data['company']['description'] }}" readonly>
                </div>
    
                <div class="divider margin-top-0"></div>
                <div class="justify-content-between row">
                    <button id="back-to-edit" class="btn btn-secondary col-md-4"><i class="fa fa-arrow-circle-left"></i> Back To Edit</button>
                    <button type="submit" class="btn btn-success col-md-4">Save <i class="fa fa-arrow-circle-right"></i></button>
                </div>
    
            </div>
        </form>
	</div>
</div>
@endsection

@push('js')
    <script>
        let btn = $('#back-to-edit').click(function (e) { 
            e.preventDefault();
            $(location).attr('href', "{{ url('jobs/create') }}");
        });
    </script>
@endpush