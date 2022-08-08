<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{Category, Job};
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        return view('front.home', [
            'categories' => Category::with(['subCategories'])->get()->take(8),
            'jobs' => Job::orderBy('created_at', 'DESC')->get()->take(5)
        ]);
    }
}
