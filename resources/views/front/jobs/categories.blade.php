@extends('layouts.front')

@section('subtitle', 'Categories')

@section('content')

<!-- Titlebar
================================================== -->
<div id="titlebar" class="photo-bg" style="background-image: url(images/all-categories-photo.jpg);">
	<div class="container">
		<div class="ten columns">
			<h2>All Categories</h2>
		</div>

		<div class="six columns">
			<a href="add-job.html" class="button">Post a Job, It’s Free!</a>
		</div>

	</div>
</div>


<!-- Content
================================================== -->
<div id="categories">
	<!-- Categories Group -->
	@foreach ($categories as $category)
        <div class="categories-group">
            <div class="container">
                <div class="four columns"><h4>{{ $category->name }}</h4></div>
                <div class="four columns">
                    <ul>
                        @foreach ($category->subCategories as $subCategory)
                            <li><a href="{{ route('category', $subCategory->slug) }}">{{ $subCategory->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach

</div>

@endsection