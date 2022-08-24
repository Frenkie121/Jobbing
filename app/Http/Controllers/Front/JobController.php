<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Controllers\Controller;
use App\Models\{Job, SubCategory, Tag};

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.jobs.index', [
            'jobs' => Job::select('*')->orderBy('created_at', 'DESC')->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Job::class);

        return view('front.jobs.create', [
            'tags' => Tag::all(),
            'sub_categories' => SubCategory::all(),
            'types' => Job::TYPES
        ]);
    }

    /**
     * Store data to session before storage in database
     *
     * @param JobRequest $jobRequest
     * 
     * @return @return \Illuminate\Http\Response
     * 
     */
    public function submit(JobRequest $jobRequest)
    {
        $this->authorize('create', Job::class);

        session()->put('data', $jobRequest->validated());

        return redirect()->route('jobs.preview');
    }

    /**
     * Store data to session before storage in database
     *
     * @param JobRequest $jobRequest
     * 
     * @return @return \Illuminate\Http\Response
     * 
     */
    public function preview()
    {
        $this->authorize('create', Job::class);
        
        return view('front.jobs.preview', [
            'data' => session()->get('data'),
            'tags' => Tag::all(),
            'sub_categories' => SubCategory::all(),
            'types' => Job::TYPES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->authorize('create', Job::class);

        $data = session()->get('data');
        
        if (!$data) {
            return redirect()->route('jobs.create')
                ->with('data_lost', 'Data have been lost. You have to re-fill the form');
        }

        // Remove 'extra' keys for matching columns in DB
        unset($data['company'], $data['tags'], $data['sub_category']);

        $user = User::query()->findOrFail(auth()->id());
        $session = session()->get('data');  
        
        // 1. Create Job for the Customer
        $job = Job::query()->create(
            $data + [
                'customer_id' => $user->userable->id,
                'sub_category_id' => $session['sub_category'],
                'company_name' => $session['company']['name'],
                'company_url' => $session['company']['url'],
                'company_description' => $session['company']['description'],
            ]
        );

        // 2. Attach tags with created job
        $job->tags()->attach($session['tags']);

        // 3. Add requirements for this Job
        foreach (array_filter($session['requirement']) as $requirement) {
            $job->requirements()->create(['content' => $requirement]);
        }

        // 4. Destroy data variable from session
        session()->forget('data');

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return view('front.jobs.show', [
            'job' => $job,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }
}
