<?php

namespace App\Http\Controllers\Front\Customer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index()
    {
        $customer = User::query()->findOr(auth()->id())->userable;

        return view('front.customer.index', [
            'jobs' => $customer->jobs->load('freelances'),
        ]);
    }
}
