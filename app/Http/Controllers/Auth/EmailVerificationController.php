<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    
    /**
     * Return view instructing the user to click the email verification link that was emailed after registration
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * 
     */
    public function emailVerifyView()
    {
        return view('auth.verify-email');
    }

    /**
     * Handle requests generated when the user clicks the email verification link
     *
     * @param EmailVerificationRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        
        return redirect()->route('home');
    }

    /**
     * Retrun form for email verification link resend
     *
     * @param Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function resend()
    {
        return view('auth.resend-link');
    }

    /**
     * Resend email verification link
     *
     * @param Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function resendVerificationLink(Request $request)
    {
        if ($request->email !== auth()->user()->email) {
            return back()
                    ->withInput()
                    ->with('error', 'Provided email must be the one that you are authenticating with.');
        }

        $request->user()->sendEmailVerificationNotification();
 
        return back()->with('message', 'Verification link sent!');
    }
}
