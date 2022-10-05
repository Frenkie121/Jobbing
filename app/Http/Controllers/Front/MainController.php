<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{Category, Job, SubCategory};

class MainController extends Controller
{
    public function home()
    {
        return view('front.home', [
            'sub_categories' => SubCategory::query()->whereHas('jobs')->get(['slug', 'name'])->take(8),
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
            'jobs' => Job::select('*')->where('sub_category_id', $subCategory->id)->orderBy('created_at', 'DESC')->paginate(5),
            'types' => Job::TYPES,
        ]);
    }
}
