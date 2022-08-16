<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{Category, Job, SubCategory};

class MainController extends Controller
{
    public function home()
    {
        return view('front.home', [
            'categories' => Category::with(['subCategories'])->get()->take(8),
            'jobs' => Job::orderBy('created_at', 'DESC')->get()->take(5)
        ]);
    }

    public function categories()
    {
        return view('front.jobs.categories', [
            'categories' => Category::with(['subCategories'])->get(),
        ]);
    }

    public function category(SubCategory $subCategory)
    {
        return view('front.jobs.index', [
            'subCategory' => $subCategory,
            'jobs' => $subCategory->jobs,
        ]);
    }
}
