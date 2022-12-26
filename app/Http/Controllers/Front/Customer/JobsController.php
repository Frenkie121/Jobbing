<?php

namespace App\Http\Controllers\Front\Customer;

use App\Http\Controllers\Controller;
use App\Models\{Freelance, Job, User};
use App\Notifications\LaunchJobNotification;
use App\Notifications\SelectApplicantNotification;
use Illuminate\Support\Facades\Notification;

class JobsController extends Controller
{
    public function index()
    {
        $customer = User::query()->findOr(auth()->id())->userable;
        
        return view('front.customer.index', [
            'jobs' => $customer->jobs->load('freelances')->sortByDesc('updated_at'),
        ]);
    }

    public function showApplications(Job $job)
    {
        return view('front.customer.applications', [
            'job' => $job->load(['freelances', 'freelances.user']),
        ]);
    }

    /**
     * Select/Unselect freelance for the specified job
     *
     * @param Job $job
     * @param Freelance $freelance
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function select(Job $job, Freelance $freelance)
    {
        $is_hired = $freelance->jobs()->wherePivot('job_id', $job->id)->first()->pivot->is_hired;
        if ($is_hired) {
            $job->freelances()->updateExistingPivot($freelance, ['is_hired' => false]);
            $message = 'unselected';
            $selected = false;
        } else {
            $job->freelances()->updateExistingPivot($freelance, ['is_hired' => true]);
            $message = 'selected';
            $selected = true;
        }
        
        Notification::send([$freelance->user, auth()->user()], new SelectApplicantNotification($job, $freelance, $selected));

        flash("You have {$message} freelance {$freelance->user->name} for job " . $job->title . '.', 'success');

        return redirect()->route('customer.index');
    }

    /**
     * Launch the specified job resource
     *
     * @param Job $job
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function launch(Job $job)
    {
        $job->starts_at = now();
        $job->save();
        $job->statuses()->attach(3);

        Notification::send([auth()->user(), $job->freelances()->wherePivot('is_hired', true)->first()->user], new LaunchJobNotification($job));

        flash("The job {$job->title} has been successfully launched.", 'success');

        return back();
    }

}
