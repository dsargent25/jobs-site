<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

Route::get('/jobs', function (){
    
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs.index', [ 
        'jobs' =>  $jobs
    ]);
});

Route::get('/jobs/create', function(){
    return view('jobs.create');
});

Route::get('/jobs/{id}', function ($id){
    $job = Job::find($id);
    
    return view('jobs.show', ['job' => $job]);
});

Route::post('/jobs', function () {
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



Route::patch('/jobs/{id}', function ($id){
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
        'title' => request('salary'),
    ]);
    //and persist
    //redirect to the job page

    return redirect('/jobs/' . $job->id);
});



Route::delete('/jobs/{id}', function ($id){
    //authorize (on hold...)
    // delete the job
    Job::findOrFail($id)->delete();
});


Route::get('/jobs/{id}/edit', function ($id){
    $job = Job::find($id);
    
    return view('jobs.edit', ['job' => $job]);
});


Route::get('/contact', function () {
    return view('contact');
});

//Rollback to Ep 16 