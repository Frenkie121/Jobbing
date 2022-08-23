<?php

namespace App\Services\Profile;

use App\Models\User;
use Illuminate\Http\Request;

class UpdateService
{
    public function handle(User $user, Request $request)
    {
        return $user->update($request->only([
            'profession',
            'location',
            'description',
            'salary'
        ]));
    }
}