<?php

namespace App\Http\Controllers\Auth;

use App\Events\Logged;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login', [
            'drivers' => [
                'github' => 'github',
                'gplus' => 'google',
            ]
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        
        $user = User::whereEmail($request->email)->first();
        if ($user && !$user->is_active) {
            flash('Your account has been disabled. Please contact admin.', 'warning');
            return back()->withInput();
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->rememberme)) {
            
            $redirect = match($user->role_id){
                1 => '/',
                2 => fn() => $user->userable->jobs->isEmpty() ? 'jobs/create' : 'my-jobs/dashboard',
                3 => fn() => $user->userable->experiences->isEmpty() ? 'profile' : 'jobs',
                default => '/'
            };

            event(new Logged($user));

            $request->session()->regenerate();
 
            return redirect()->intended($redirect);
        }

        flash('The provided credentials do not match our records.', 'error');

        return back()->withInput();
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
