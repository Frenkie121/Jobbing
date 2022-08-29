<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Controllers\Controller;
use App\Models\{Job, SubCategory, Tag};
use App\Services\Job\CreateJobService;

class JobController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:2')->except(['index', 'show']);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.jobs.index', [
            'jobs' => Job::orderBy('created_at', 'DESC')->paginate(5),
            'types' => Job::TYPES,
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
            'sub_categories' => SubCategory::with(['category'])->get(),
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
    public function store(CreateJobService $createJobService)
    {
        $this->authorize('create', Job::class);

        $data = session()->get('data');
        
        if (!$data) {
            flash('Data have been lost. You have to re-fill the form', 'warning');
            return redirect()->route('jobs.create');
        }

        // Remove 'extra' keys for matching columns in DB
        unset($data['company'], $data['tags'], $data['sub_category']);
         
        // 1. Create Job for the Customer
        $job = $createJobService->createJob();
        // Attach first status
        $createJobService->addStatus($job);

        // 2. Attach tags with created job
        $createJobService->attachTags($job);

        // 3. Add requirements for this Job
        $createJobService->saveRequirements($job);

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
        $this->authorize('create', Job::class);
        
        if ($job->starts_at) {
            flash('You cannot delete an ongoing job.', 'error');
        }else {
            flash('Job has been successfully deleted.', 'success');
            $job->delete();
        }
        return back();
    }
}