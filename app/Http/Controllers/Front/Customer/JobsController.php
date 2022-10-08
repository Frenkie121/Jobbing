<?php

namespace App\Http\Controllers\Front\Customer;

use App\Http\Controllers\Controller;
use App\Models\{Job, User};

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
}
