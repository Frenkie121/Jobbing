<?php

namespace App\Services\Job;

use App\Http\Requests\JobRequest;
use App\Models\{Job, User};

class CreateJobService
{
    public User $user;
    public array $session;

    public function __construct()
    {
        $this->user = User::query()->findOrFail(auth()->id());
        $this->session = session()->get('data');
    }

    public function createJob(): Job
    {
        $data = session()->get('data');
        unset($data['company'], $data['tags'], $data['sub_category']);

        return Job::query()->create(
            $data + [
                'customer_id' => $this->user->userable->id,
                'sub_category_id' => $this->session['sub_category'],
                'company_name' => $this->session['company']['name'],
                'company_url' => $this->session['company']['url'],
                'company_description' => $this->session['company']['description'],
            ]
        );
    }

    public function attachTags(Job $job)
    {
        $job->tags()->attach($this->session['tags']);
    }

    public function saveRequirements(Job $job)
    {
        foreach (array_filter($this->session['requirement']) as $requirement) {
            $job->requirements()->create(['content' => $requirement]);
        }
    }

    public function addStatus(Job $job)
    {
        // Init status with "PENDING"
        $job->statuses()->attach(1);
    }
}
