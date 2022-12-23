@extends('layouts.front')

@section('subtitle', 'Jobs | ' . $job->title)

@section('content')

    <!-- Titlebar ================================================== -->
    <div id="titlebar" class="photo-bg" style="background: url(images/job-page-photo.jpg)">
        <div class="container">
            <div class="ten columns">
                <span>{{ $job->subCategory->category->name }} / <a href="{{ route('category.jobs', $job->slug) }}">{{ $job->subCategory->name }}</a></span>
                <h2>{{ ucwords($job->title) }} <span class="{{ $job->type_class }}">{{ $job->type }}</span></h2>
            </div>
    
            <div class="six columns">
                <button class="button" style="background-color: {{ $job->statuses->last()->color }}; margin-left: 55px" aria-disabled="true"> {{ $job->statuses->last()->name }}</button>
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
                    <span>No requirement for this job.</span>
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
                                <strong>Duration: {{ $job->duration }}</strong>
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
                                <strong>Category: <a href="{{ route('category.jobs', $subCategory->slug) }}">{{ $subCategory->name }}</a>, {{ $subCategory->category->name }}</strong>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-tags"></i>
                            <div>
                                <strong>Tags: {{ implode(', ', $job->tags->pluck('name')->toArray()) }}</strong>
                            </div>
                        </li>
                    </ul>
    
                    @if ((auth()->check() && auth()->user()->role_id === 3) || !auth()->check())
                        <x-job.apply-button slug="{{ $job->slug }}" id="{{ $job->id }}" />
                    @endif
    
                </div>
    
            </div>
    
        </div>
        <!-- Widgets / End -->
    
    
    </div>

@endsection