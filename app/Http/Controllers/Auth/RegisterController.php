<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Freelance;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function registerView()
    {
        return view('auth.register', [
            'roles' => Role::all(['id', 'name'])->except(1),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:75',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:2,3'
        ]);
        
        $role = (int) $request->role;
        $credentials = $request->only(['name', 'email', 'password']) + ['role_id' => $role];
        if ($role === 2) {
            $customer = Customer::create();
            $user = $customer->user()->create($credentials);
        } elseif ($role === 3) {
            $freelance = Freelance::create();
            $user = $freelance->user()->create($credentials);
        }

        // Mail
        Auth::login($user);
        
        return redirect()->route('home');
    }
}
