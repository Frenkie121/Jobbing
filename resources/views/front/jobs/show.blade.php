@extends('layouts.front')

@section('subtitle', 'Jobs | ' . $job->title)

@section('content')

    <!-- Titlebar ================================================== -->
    <div id="titlebar" class="photo-bg" style="background: url(images/job-page-photo.jpg)">
        <div class="container">
            <div class="ten columns">
                {{-- <span><a href="browse-jobs.html">Restaurant / Food Service</a></span> --}}
                <h2>{{ ucwords($job->title) }} <span class="{{ $job->type_class }}">{{ $job->type }}</span></h2>
            </div>
    
            <div class="six columns">
                <a href="#" class="button white"><i class="fa fa-star"></i> Bookmark This Job</a>
            </div>
    
        </div>
    </div>
    
    
    <!-- Content
    ================================================== -->
    <div class="container">
        
        <!-- Recent Jobs -->
        <div class="eleven columns">
        <div class="padding-right">
            
            <!-- Company Info -->
            <div class="company-info">
                <img src="{{ $job->image }}" alt="{{ $job->title }}">
                <div class="content">
                    @if ($job->company_name)
                        <h4>{{ ucfirst($job->company_name) }}</h4>
                        @if ($job->company_description)
                            <h6>{{ ucfirst($job->company_description) }}</h6>
                        @endif
                    @else
                        <h4>{{ ucfirst($job->customer->user->name) }}</h4>
                    @endif
                    <span><a href="{{ $job->company_url ?? '#' }}"><i class="fa fa-link"></i> Website</a></span>
                    <span><a href="#"><i class="fa fa-twitter"></i> {{ '@' . fake()->word }}</a></span>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <h4 class="margin-bottom-10"><strong><u>Description</u></strong></h4>
            <p class="margin-reset">
                {{ $job->description }}
            </p>
    
            {{-- <br>
            <p>The <strong>Food Service Specialist</strong> will have responsibilities that include:</p>
    
            <ul class="list-1">
                <li>Executing the Food Service program, including preparing and presenting our wonderful food offerings
                to hungry customers on the go!
                </li>
                <li>Greeting customers in a friendly manner and suggestive selling and sampling items to help increase sales.</li>
                <li>Keeping our Store food area looking terrific and ready for our valued customers by managing product 
                inventory, stocking, cleaning, etc.</li>
                <li>We’re looking for associates who enjoy interacting with people and working in a fast-paced environment!</li>
            </ul> --}}
            
            <br>
    
            <h4 class="margin-bottom-10"><strong><u>Job Requirements</u></strong></h4>
    
            <ul class="list-1">
                @forelse ($job->requirements as $requirement)
                    <li>{{ $requirement->content }}</li>
                @empty
                    <span>NO requirement for this job.</span>
                @endforelse
            </ul>
    
        </div>
        </div>
    
    
        <!-- Widgets -->
        <div class="five columns">
    
            <!-- Sort by -->
            <div class="widget">
                <h4>Overview</h4>
    
                <div class="job-overview">
                    
                    <ul>
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <div>
                                <strong>Location: {{ $job->location }}</strong>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-clock-o"></i>
                            <div>
                                <strong>Hours: {{ $job->duration }}</strong>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-money"></i>
                            <div>
                                <strong>Rate: {{ $job->salary }}</strong>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-clock-o"></i>
                            <div>
                                <strong>Deadline: {{ $job->deadline }}</strong>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-columns"></i>
                            <div>
                                @php $subCategory = $job->subCategory; @endphp
                                <strong>Category: <a href="{{ route('category', $subCategory->slug) }}">{{ $subCategory->name }}</a>, {{ $subCategory->category->name }}</strong>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-tags"></i>
                            <div>
                                <strong>Tags: {{ implode(', ', $job->tags()->get()->pluck('name')->toArray()) }}</strong>
                            </div>
                        </li>
                    </ul>
    
    
                    <a href="#small-dialog" class="popup-with-zoom-anim button">Apply For This Job</a>
    
                    <div id="small-dialog" class="zoom-anim-dialog mfp-hide apply-popup">
                        <div class="small-dialog-headline">
                            <h2>Apply For This Job</h2>
                        </div>
    
                        <div class="small-dialog-content">
                            <form action="#" method="get" >
                                <input type="text" placeholder="Full Name" value=""/>
                                <input type="text" placeholder="Email Address" value=""/>
                                <textarea placeholder="Your message / cover letter sent to the employer"></textarea>
    
                                <!-- Upload CV -->
                                <div class="upload-info"><strong>Upload your CV (optional)</strong> <span>Max. file size: 5MB</span></div>
                                <div class="clearfix"></div>
    
                                <label class="upload-btn">
                                    <input type="file" multiple />
                                    <i class="fa fa-upload"></i> Browse
                                </label>
                                <span class="fake-input">No file selected</span>
    
                                <div class="divider"></div>
    
                                <button class="send">Send Application</button>
                            </form>
                        </div>
                        
                    </div>
    
                </div>
    
            </div>
    
        </div>
        <!-- Widgets / End -->
    
    
    </div>

@endsection