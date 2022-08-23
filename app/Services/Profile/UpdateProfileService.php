<?php

namespace App\Services\Profile;

use App\Http\Requests\FreelanceProfileRequest;
use App\Models\{Experience, Link, User};

class UpdateProfileService
{
    public User $user;
    public $request;

    public function __construct(FreelanceProfileRequest $request)
    {
        $this->user = auth()->user();
        $this->request = $request;
    }

    public function updateMainInfo()
    {
        $this->user->update($this->request->only(['name', 'email', 'avatar']));
        $this->user->userable()->update(
            $this->request->only(['profession', 'location', 'description', 'salary'])
        );
        return;
    }

    public function updateLinks()
    {
        foreach (array_filter($this->request->link_name) as $key => $link) {
            Link::updateOrCreate([
                'freelance_id' => $this->user->userable->id,
                'name' => $link,
                'url' => $this->request->link_url[$key]
            ]);
        }
    }

    public function updateExperiences()
    {
        foreach (array_filter($this->request->company) as $key => $experience) {
            Experience::query()->updateOrCreate([
                'freelance_id' => $this->user->userable->id,
                'company' => $experience,
                'job_title' => $this->request->job_title[$key],
                'started_at' => $this->request->start_at[$key],
                'ended_at' => $this->request->end_at[$key],
            ], [
                'job_description' => $this->request->job_description[$key],
            ]);
        }
    }
}
