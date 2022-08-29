<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect to the specified driver
     *
     * @param string $driver
     * 
     * @return void
     * 
     */
    public function redirect(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Retrieve user's data from driver
     *
     * @return void
     * 
     */
    public function handle(string $driver)
    {
        $user_from_driver = Socialite::driver($driver)->user();
        $user = User::whereEmail($user_from_driver->getEmail())->first();
        if (!$user) {
            flash('You don\'t have an account in our records with your ' . ucfirst($driver) . ' email.', 'error');
            return back();
        }
        Auth::login($user);
    
        return redirect()->intended();
    }
}