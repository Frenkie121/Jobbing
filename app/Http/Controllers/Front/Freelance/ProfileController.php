<?php

namespace App\Http\Controllers\Front\Freelance;

use App\Models\{Experience, Link, User};
use App\Http\Controllers\Controller;
use App\Http\Requests\FreelanceProfileRequest;
use App\Services\Profile\UpdateProfileService;

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

    public function update(UpdateProfileService $updateProfileService)
    {
        // 1. Update user's and freelance main info
        $updateProfileService->updateMainInfo();

        // 3. Update/Create freelance urls links
        $updateProfileService->updateLinks();

        // 4. Update/Create freelance experiences
        $updateProfileService->updateExperiences();

        flash('Profile successfully updated', 'success');

        return redirect()->route('jobs.index');
    }
}
