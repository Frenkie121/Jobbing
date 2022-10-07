@extends('layouts.front')

@section('subtitle', 'Dashboard')

@section('content')

    <!-- Titlebar
================================================== -->
<x-front.title-bar title="Dashboard" previous="Home" previousUrl="{{ route('home') }}" />


<!-- Content
================================================== -->
<div class="container">
	
	<!-- Table -->
	<div class="sixteen columns">

		{{-- <p class="margin-bottom-25">Your listings are shown in the table below. Expired listings will be automatically removed after 30 days.</p> --}}

		<table class="manage-table responsive-table">

			<tr>
				<th><i class="fa fa-file-text"></i> Title</th>
				<th><i class="fa fa-calendar"></i> Date Applied</th>
				<th><i class="fa fa-check-square-o"></i> Hired?</th>
				<th><i class="fa fa-calendar"></i> Date Expires</th>
				<th><i class="fa fa-user"></i> Applications</th>
				<th></th>
			</tr>

			@forelse ($jobs as $job)
                <tr>
                    <td class="title"><a href="#">{{ $job->title }}</a></td>
                    <td>{{ date_format(Carbon\Carbon::make($job->pivot->created_at), 'F d, Y') }}</td>
                    <td class="centered">
                        @if ($job->hasHired())
                            @if ($freelance->hasBeenHired($job->id))
                                <i class="fa fa-check"></i>
                                @if ($job->starts_at) (Started at ...) @endif
                            @else
                                <i class="fa fa-remove"></i>
                            @endif
                        @else
                            <i style="color: rgb(13, 211, 201)">Waiting ...</i>
                        @endif
                    </td>
                    <td>{{ $job->deadline }}</td>
                    <td class="action">
                        @if ($freelance->hasBeenHired($job->id) && $job->starts_at)
                            <a href="#"><i class="fa fa-check "></i> Mark As Done</a>
                        @else
                            <a href="{{ route('freelance.cancel', $job->slug) }}" class="delete"
                                onclick="event.preventDefault();
                                document.querySelector('#cancel-{{ $job->id }}').submit();"><i class="fa fa-remove"></i> Cancel</a>
                            <form action="{{ route('freelance.cancel', $job->slug) }}" method="post" style="display: none" id="cancel-{{ $job->id }}">
                                @csrf
                                @method('PATCH')
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">You haven't apply to any job for the moment.</td>
                </tr>
            @endforelse

		</table>

		<br>
		<a href="{{ route('jobs.index') }}" class="button">Find Job</a>

	</div>

</div>

@endsection