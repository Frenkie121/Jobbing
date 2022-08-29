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

		<p class="margin-bottom-25">Your listings are shown in the table below. Expired listings will be automatically removed after 30 days.</p>

		<table class="manage-table responsive-table">

			<tr>
				<th><i class="fa fa-file-text"></i> Title</th>
				<th><i class="fa fa-check-square-o"></i> Filled?</th>
				<th><i class="fa fa-calendar"></i> Date Posted</th>
				<th><i class="fa fa-calendar"></i> Date Expires</th>
				<th><i class="fa fa-user"></i> Applications</th>
				<th></th>
			</tr>

			@forelse ($jobs as $job)
                <tr>
                    <td class="title"><a href="#">{{ $job->title }}</a></td>
                    <td class="centered">
                        @if ($job->ends_at)
                            <i class="fa fa-check"></i>
                        @elseif ($job->starts_at)
                            <i class="fa fa-minus"></i>
                        @else
                            <i class="fa fa-times"></i>
                        @endif
                    </td>
                    <td>{{ $job->created_at }}</td>
                    <td>{{ $job->deadline }}</td>
                    <td class="centered">
                        @if ($job->freelances->isNotEmpty())
                            <a href="#" class="button">Show ($job->freelances->count())</a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="action">
                        <a href="#"><i class="fa fa-pencil"></i> Edit</a>
                        @if ($job->starts_at)
                            <a href="#"><i class="fa fa-check "></i> Mark Filled</a>
                        @else
                            <a href="{{ route('jobs.destroy', $job->slug) }}" class="delete"
                                onclick="event.preventDefault();
                                document.querySelector('#d{{ $job->id }}lete').submit();"><i class="fa fa-remove"></i> Delete</a>
                            <form action="{{ route('jobs.destroy', $job->slug) }}" method="post" style="display: none" id="d{{ $job->id }}lete">
                                @csrf
                                @method('DELETE')
                                {{-- <button type="submit"><i class="fa fa-remove"></i> Delete</button> --}}
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <span>You don't have job any job for the moment. You can create one by clicking on the link below.</span>
            @endforelse

		</table>

		<br>
		<a href="{{ route('jobs.create') }}" class="button">Add Job</a>

	</div>

</div>

@endsection