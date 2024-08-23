<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

//Retrieve Jobs

Route::get('/jobs', function (){
    
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs.index', [ 
        'jobs' =>  $jobs
    ]);
});


//Open Create Job Page

Route::get('/jobs/create', function(){
    return view('jobs.create');
});

//Open Specific Job Page (Based on ID)

Route::get('/jobs/{id}', function ($id){
    $job = Job::find($id);
    
    return view('jobs.show', ['job' => $job]);
});

//Submit a Job via Create Job

Route::post('/jobs/create', function () {
    request()->validate([

        'title' => ['required', 'min:3'],
        'salary' => ['required']

    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);

    return redirect('/jobs');

});

//Update a Job via Edit Job

Route::patch('/jobs/{id}/edit', function ($id){
    //validate
    request()->validate([

        'title' => ['required', 'min:3'],
        'salary' => ['required']

    ]);

    //authorize (on hold...)

    //update the job
    $job = Job::findOrfail($id);


    //same thing
    // $job->title = request('title');
    // $job->salary = request('salary');
    // $job->save();

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);
    //and persist
    //redirect to the job page

    return redirect('/jobs/'.$job->id);
});

// Destroy a Job

Route::delete('/jobs/{id}', function ($id){
    //authorize (on hold...)
    // delete the job
    Job::findOrFail($id)->delete();

    return redirect('/jobs');
});

// Open a Job to Edit

Route::get('/jobs/{id}/edit', function ($id){
    $job = Job::find($id);
    
    return view('jobs.edit', ['job' => $job]);
});

// Open a Contact Page

Route::get('/contact', function () {
    return view('contact');
});