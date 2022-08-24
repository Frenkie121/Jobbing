@extends('layouts.front')

@section('subtitle', 'Jobs')

@section('content')

<!-- Titlebar ================================================== -->
<x-front.title-bar title="Jobs" previous="Home" previousUrl="{{ route('home') }}">
	@isset($subCategory)
		<li>{{ $subCategory->name }}</li>
	@endisset
</x-front.title-bar>

<div class="container">
	<!-- Recent Jobs -->
	<div class="eleven columns">
	<div class="padding-right">
		
		<form action="#" method="get" class="list-search">
			<button><i class="fa fa-search"></i></button>
			<input type="text" placeholder="job title, keywords or company name" value=""/>
			<div class="clearfix"></div>
		</form>

		<ul class="job-list full">

			@forelse ($jobs as $job)
                <x-job.single-job 
                    classType="{{ $job->type_class }}"
                    title="{{ $job->title }}" 
                    type="{{ $job->type }}" 
                    location="{{ $job->location }}"
                    salary="{{ $job->salary }}"
                    description="{{ $job->description }}"
                    url="{{ route('jobs.show', $job->slug) }}"
                    image="{{ $job->image }}"
                />   
            @empty
                <span>Jobs are coming very soon ...</span>
            @endforelse

		</ul>
		<div class="clearfix"></div>

        {{ $jobs->links('vendor.pagination.custom') }}

	</div>
	</div>


	<!-- Widgets -->
	<div class="five columns">

		<!-- Sort by -->
		<div class="widget">
			<h4>Sort by</h4>

			<!-- Select -->
			<select data-placeholder="Choose Category" class="chosen-select-no-single">
				<option selected="selected" value="recent">Newest</option>
				<option value="oldest">Oldest</option>
				<option value="expiry">Expiring Soon</option>
				<option value="ratehigh">Hourly Rate – Highest First</option>
				<option value="ratelow">Hourly Rate – Lowest First</option>
			</select>

		</div>

		<!-- Location -->
		<div class="widget">
			<h4>Location</h4>
			<form action="#" method="get">
				<input type="text" placeholder="State / Province" value=""/>

				<button class="button">Filter</button>
			</form>
		</div>

		<!-- Job Type -->
		<div class="widget">
			<h4>Job Type</h4>

			<ul class="checkboxes">
				<li>
					<input id="check-10" type="checkbox" name="check" value="0" checked>
					<label for="check-10">Any Type</label>
				</li>
				@foreach ($types as $key => $type)
					<li>
						<input id="check-{{ $key }}" type="checkbox" name="type" value="{{ $key }}">
						<label for="check-{{ $key }}">{{ $type }} <span>({{ App\Models\Job::byType($key)->count() }})</span></label>
					</li>
				@endforeach
			</ul>

		</div>

		<!-- Rate/Hr -->
		<div class="widget">
			<h4>Rate / Hr</h4>

			<ul class="checkboxes">
				<li>
					<input id="check-6" type="checkbox" name="check" value="check-6" checked>
					<label for="check-6">Any Rate</label>
				</li>
				<li>
					<input id="check-7" type="checkbox" name="check" value="check-7">
					<label for="check-7">$0 - $25 <span>(231)</span></label>
				</li>
				<li>
					<input id="check-8" type="checkbox" name="check" value="check-8">
					<label for="check-8">$25 - $50 <span>(297)</span></label>
				</li>
				<li>
					<input id="check-9" type="checkbox" name="check" value="check-9">
					<label for="check-9">$50 - $100 <span>(78)</span></label>
				</li>
				<li>
					<input id="check-10" type="checkbox" name="check" value="check-10">
					<label for="check-10">$100 - $200 <span>(98)</span></label>
				</li>
				<li>
					<input id="check-11" type="checkbox" name="check" value="check-11">
					<label for="check-11">$200+ <span>(21)</span></label>
				</li>
			</ul>

		</div>



	</div>
	<!-- Widgets / End -->


</div>
@endsection