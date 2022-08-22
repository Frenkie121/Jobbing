<?php

namespace App\Http\Controllers\Front\Freelance;

use App\Models\{Experience, Link, User};
use App\Http\Controllers\Controller;
use App\Http\Requests\FreelanceProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->id());
        $freelance = $user->userable;

        return view('front.freelance.profile', [
            'user' => $user,
            'freelance' => $freelance,
            'links' => $freelance->links,
            'experiences' => $freelance->experiences,
        ]);
    }

    public function update(FreelanceProfileRequest $request)
    {
        $user = User::find(auth()->id());
        // 1. Update user's info
        $user->update($request->only(['name', 'email', 'avatar']));

        // 2. Update freelance main info
        $user->userable()->update($request->only(['profession', 'location', 'description', 'salary']));

        // 3. Update/Create freelance urls links
        foreach (array_filter($request->link_name) as $key => $link) {
            Link::updateOrCreate([
                'freelance_id' => $user->userable->id,
                'name' => $link,
                'url' => $request->link_url[$key]
            ]);
        }

        // 4. Update/Create freelance experiences
        foreach (array_filter($request->company) as $key => $experience) {
            Experience::updateOrCreate([
                'freelance_id' => $user->userable->id,
                'company' => $experience,
                'job_title' => $request->job_title[$key],
                'started_at' => $request->start_at[$key],
                'ended_at' => $request->end_at[$key],
            ], [
                'job_description' => $request->job_description[$key],
            ]);
        }

        return back()->with('success', 'Profile successfully updated');
    }
}
