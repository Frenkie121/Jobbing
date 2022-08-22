<?php

namespace App\Http\Controllers\Auth;

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
            return back()->withInput()
                        ->with('account_disabled', 'Your account has been disabled. Please contact admin.');
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->rememberme)) {
            
            $redirect = match($user->role_id){
                3 => 'profile',
                // default => '/'
            };

            $request->session()->regenerate();
 
            return redirect()->intended($redirect);
        }

        return back()->withInput()
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.'
                ]);
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
