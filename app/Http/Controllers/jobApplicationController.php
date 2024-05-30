<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Notifications\JobApplied;
use Illuminate\Http\Request;

class jobApplicationController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Job $job)
    {
        $this->authorize('apply', $job);
        return view('job_application.create', ['job' => $job]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Job $job, Request $request)
    {
        // $this->authorize('apply', $job);
        $jobLink = route('jobs.show', $job);
        $jobTitle = $job->title;
        $jobId = $job->id;
        $userApplications = route('my-job-applications.index');

        $validatedData = $request->validate([
            'expected_salary' => 'required|min:1|max:1000000',
            'Years_of_Experience' => 'required|min:0',
            'Email_address' => 'required|email',
            'Phone_number' => 'required',
            'Resume' => 'nullable',
            'cv' => 'required|file|mimes:pdf|max:2048', // max 2MB
        ], [
            'Email_address.required' => 'Oh no! The email field is feeling lonely and needs some attention. Please provide your email address.',
            'Email_address.email' => 'Oopsie-doodle! It seems like you\'ve entered something that doesn’t quite resemble an email. Please double-check and try again.',
            'phone_number.required' => 'Our office phone is ringing off the hook, and we need your number to join the party! Even if it\'s a banana phone, we\'re cool with that.',
            'phone_number.regex' => 'Hold the banana! Your phone number looks a bit wonky. Please enter a 10-digit number, or grab a banana and try our banana phone hotline instead.',
            'Years_of_Experience.required' => 'Time flies when you’re having fun, but we need to know how much fun you’ve had! Please tell us your years of experience, even if it includes mastering the art of Netflix and chill.',
            'Years_of_Experience.integer' => 'Whoopsie-daisy! We need a whole number for your years of experience, not a fraction or imaginary number. Unless you\'ve been coding in your dreams, then we\'re impressed!',
            'Years_of_Experience.min' => 'Well, we appreciate honesty! But come on, you must have at least 0 years of experience. Unless you just crawled out of the coding womb, then welcome to the world of programming!'

        ]);

        $file = $request->file('cv');
        $path = $file->store('cvs', 'private');

        $job->JobApplications()->create([
            'user_id' => $request->user()->id,
            'Full_Name' => $request->user()->name,
            'expected_salary' => $validatedData['expected_salary'],
            'Years_of_Experience' => $validatedData['Years_of_Experience'],
            'Email_address' => $validatedData['Email_address'],
            'Phone_number'  => $validatedData['Phone_number'],
            'Resume' => $validatedData['Resume'],
            'cv'      => $path,

        ]);

        $emailController = new EmailController();
        $emailController->SendJobApplicationEmail($jobLink, $jobTitle, $userApplications);

        $user = auth()->user();
        $user->notify(new JobApplied($job));
        return redirect()->route('jobs.show', $job)->with('success', 'job application submitted');
    }

    public function showNotifications()
    {
        $user = auth()->user();
        $notifications = $user->notifications;

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
