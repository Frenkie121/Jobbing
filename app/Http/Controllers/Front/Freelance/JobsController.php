<?php

namespace App\Http\Controllers\Front\Freelance;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index()
    {
        $freelance = auth()->user()->userable;
        
        return view('front.freelance.index', [
            'jobs' => $freelance->jobs->load('freelances'),
            'freelance' => $freelance,
        ]);
    }

    public function apply(Job $job)
    {
        $freelance = auth()->user()->userable;
        
        if (is_null($freelance->profession) || $freelance->experiences->isEmpty()) {
            flash('You must complete your profile before apply to a job.', 'warning');
            return redirect()->route('profile.index');
        } elseif ($freelance->hasAppliedToJob($job->id)) {
            flash('You have already applied to this job.', 'warning');
            return back();
        }

        $job->freelances()->attach($freelance);

        // Email to userables

        flash('You have successfully applied to a job. You will receive an email in few seconds.');

        return redirect()->route('jobs.show', $job->slug);
    }

    public function cancel(Job $job)
    {
        $job->freelances()->detach(auth()->user()->userable->id);

        // Email to userables

        flash('You have canceled your application for job ' . $job->title . ' successfully.', 'success');

        return back();
    }
}
