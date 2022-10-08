<?php

namespace App\Http\Controllers\Front\Freelance;

use App\Http\Controllers\Controller;
use App\Models\{Job};
use App\Notifications\{CancelJobApplicationNotification, NewJobApplicationNotification};
use Illuminate\Support\Facades\Notification;

class JobsController extends Controller
{
    public function getFreelance()
    {
        return auth()->user()->userable;
    }

    public function index()
    {
        if (is_null($this->getFreelance()->profession)) {
            flash('You must complete your profile before accessing this page.', 'info');
            return redirect()->route('profile.index');
        }
        
        return view('front.freelance.index', [
            'jobs' => $this->getFreelance()->jobs->load('freelances'),
            'freelance' => $this->getFreelance(),
        ]);
    }

    public function apply(Job $job)
    {
        if (is_null($this->getFreelance()->profession)) {
            flash('You must complete your profile before apply to a job.', 'warning');
            return redirect()->route('profile.index');
        } elseif ($this->getFreelance()->hasAppliedToJob($job->id)) {
            flash('You have already applied to this job.', 'warning');
            return back();
        }

        $job->freelances()->attach($this->getFreelance());

        // Email to userables
        Notification::send([$this->getFreelance()->user, $job->customer->user], new NewJobApplicationNotification($job, $this->getFreelance()));

        flash('You have successfully applied to a job. You will receive an email in few seconds.');

        return redirect()->route('jobs.show', $job->slug);
    }

    public function cancel(Job $job)
    {
        $job->freelances()->detach(auth()->user()->userable->id);

        // Email to userables
        Notification::send([$this->getFreelance()->user, $job->customer->user], new CancelJobApplicationNotification($job, $this->getFreelance()));

        flash('You have canceled your application for job ' . $job->title . ' successfully.', 'success');

        return back();
    }
}
