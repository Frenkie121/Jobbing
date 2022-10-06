@extends('layouts.front')

@section('subtitle', 'Home')

@section('content')
    
<!-- Banner
================================================== -->
<div id="banner" style="background: url(assets/images/banner-home-01.jpg)">
	<div class="container">
		<div class="sixteen columns">
			@if (session()->has('success'))
				<div class="alert alert-info text-center mt-5">
					<span>Thank you for your registration. An email has been sent to you to verify your email address. <a href="{{ route('verification.resend') }}">Click here if you have not receive the link</a>.</span>
				</div>
			@endif

			@if (session()->has('account_not_found'))
				<div class="alert alert-danger text-center mt-5">{{ session()->get('account_not_found') }}</div>
			@endif

			<div class="search-container">

				<!-- Form -->
				<h2>Find job</h2>
				<input type="text" class="ico-01" placeholder="job title, keywords or company name" value=""/>
				<input type="text" class="ico-02" placeholder="city, province or region" value=""/>
				<button><i class="fa fa-search"></i></button>

				<!-- Browse Jobs -->
				<div class="browse-jobs">
					Browse job offers by <a href="browse-categories.html"> category</a> or <a href="#">location</a>
				</div>
				
				<!-- Announce -->
				<div class="announce">
					We’ve over <strong>15 000</strong> job offers for you!
				</div>

			</div>

		</div>
	</div>
</div>


<!-- Content
================================================== -->

<!-- Categories -->
<div class="container">
	<div class="sixteen columns">
		<h3 class="margin-bottom-25">Popular Categories</h3>
		<ul id="popular-categories">
			@forelse ($sub_categories as $sub_category)
				<li><a href="{{ route('category.jobs', $sub_category->slug) }}"><i class="fa fa-laptop"></i> {{ $sub_category->name }}</a></li>
			@empty
				<div class="text-center text-info">New categories coming very soon...</div>
			@endforelse
		</ul>

		<div class="clearfix"></div>
		<div class="margin-top-30"></div>

		<a href="{{ route('categories') }}" class="button centered">Browse All Categories</a>
		<div class="margin-bottom-50"></div>
	</div>
</div>


<div class="container">
	
	<!-- Recent Jobs -->
	<div class="eleven columns">
		<div class="padding-right">
			<h3 class="margin-bottom-25">Recent Jobs</h3>
			<ul class="job-list">
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
					<div class="text-center text-info">Jobs coming soon...</div>
				@endforelse
			</ul>

			<a href="browse-jobs.html" class="button centered"><i class="fa fa-plus-circle"></i> Show More Jobs</a>
			<div class="margin-bottom-55"></div>
		</div>
	</div>

	<!-- Job Spotlight -->
	<div class="five columns">
		<h3 class="margin-bottom-5">Job Spotlight</h3>

		<!-- Navigation -->
		<div class="showbiz-navigation">
			<div id="showbiz_left_1" class="sb-navigation-left"><i class="fa fa-angle-left"></i></div>
			<div id="showbiz_right_1" class="sb-navigation-right"><i class="fa fa-angle-right"></i></div>
		</div>
		<div class="clearfix"></div>
		
		<!-- Showbiz Container -->
		<div id="job-spotlight" class="showbiz-container">
			<div class="showbiz" data-left="#showbiz_left_1" data-right="#showbiz_right_1" data-play="#showbiz_play_1" >
				<div class="overflowholder">

					<ul>

						@forelse ($jobs_spotlight as $job)
							<li>
								<div class="job-spotlight">
									<a href="{{ route('jobs.show', $job->slug) }}"><h4>{{ $job->title }} <span class="{{ $job->type_class }}">{{ $job->type }}</span></h4></a>
									<span><i class="fa fa-briefcase"></i> Mates</span>
									<span><i class="fa fa-map-marker"></i> {{ $job->location }}</span>
									<span><i class="fa fa-money"></i>{{ $job->salary }} / hour</span>
									<p>{{ $job->description }}</p>
									
									<x-job.apply-button slug="{{ $job->slug }}" id="{{ $job->id }}" />
								</div>
							</li>
						@empty
							<div class="text-center text-info">Jobs spotlights are coming very soon...</div>
						@endforelse


					</ul>
					<div class="clearfix"></div>

				</div>
				<div class="clearfix"></div>
			</div>
		</div>

	</div>
</div>


<!-- Testimonials -->
<div id="testimonials">
	<!-- Slider -->
	<div class="container">
		<div class="sixteen columns">
			<div class="testimonials-slider">
				  <ul class="slides">
				    <li>
				      <p>I have already heard back about the internship I applied through Job Finder, that's the fastest job reply I've ever gotten and it's so much better than waiting weeks to hear back.
				      <span>Collis Ta’eed, Envato</span></p>
				    </li>

				    <li>
				      <p>Nam eu eleifend nulla. Duis consectetur sit amet risus sit amet venenatis. Pellentesque pulvinar ante a tincidunt placerat. Donec dapibus efficitur arcu, a rhoncus lectus egestas elementum.
				      <span>John Doe</span></p>
				    </li>
				    
				    <li>
				      <p>Maecenas congue sed massa et porttitor. Duis placerat commodo ex, ut faucibus est facilisis ac. Donec eleifend arcu sed sem posuere aliquet. Etiam lorem metus, suscipit vel tortor vitae.
				      <span>Tom Smith</span></p>
				    </li>

				  </ul>
			</div>
		</div>
	</div>
</div>


<!-- Infobox -->
<div class="infobox">
	<div class="container">
		<div class="sixteen columns">Start Building Your Own Job Board Now <a href="my-account.html">Get Started</a></div>
	</div>
</div>


<!-- Recent Posts -->
<div class="container">
	<div class="sixteen columns">
		<h3 class="margin-bottom-25">Recent Posts</h3>
	</div>


	<div class="one-third column">

		<!-- Post #1 -->
		<div class="recent-post">
			<div class="recent-post-img"><a href="blog-single-post.html"><img src="images/recent-post-01.jpg" alt=""></a><div class="hover-icon"></div></div>
			<a href="blog-single-post.html"><h4>Hey Job Seeker, It’s Time To Get Up And Get Hired</h4></a>
			<div class="meta-tags">
				<span>October 10, 2015</span>
				<span><a href="#">0 Comments</a></span>
			</div>
			<p>The world of job seeking can be all consuming. From secretly stalking the open reqs page of your dream company to sending endless applications.</p>
			<a href="blog-single-post.html" class="button">Read More</a>
		</div>

	</div>


	<div class="one-third column">

		<!-- Post #2 -->
		<div class="recent-post">
			<div class="recent-post-img"><a href="blog-single-post.html"><img src="images/recent-post-02.jpg" alt=""></a><div class="hover-icon"></div></div>
			<a href="blog-single-post.html"><h4>How to "Woo" a Recruiter and Land Your Dream Job</h4></a>
			<div class="meta-tags">
				<span>September 12, 2015</span>
				<span><a href="#">0 Comments</a></span>
			</div>
			<p>Struggling to find your significant other the perfect Valentine’s Day gift? If I may make a suggestion: woo a recruiter. </p>
			<a href="blog-single-post.html" class="button">Read More</a>
		</div>

	</div>

	<div class="one-third column">

		<!-- Post #3 -->
		<div class="recent-post">
			<div class="recent-post-img"><a href="blog-single-post.html"><img src="images/recent-post-03.jpg" alt=""></a><div class="hover-icon"></div></div>
			<a href="blog-single-post.html"><h4>11 Tips to Help You Get New Clients Through Cold Calling</h4></a>
			<div class="meta-tags">
				<span>August 27, 2015</span>
				<span><a href="#">0 Comments</a></span>
			</div>
			<p>If your dream employer appears on this list, you’re certainly in good company. But it also means you’re up for some intense competition.</p>
			<a href="blog-single-post.html" class="button">Read More</a>
		</div>
	</div>

</div>

@endsection