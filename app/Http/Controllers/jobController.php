<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class jobController extends Controller
{
    /**npm run dev
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', job::class); // Policy Class 
        $filters = request()->only('search', 'min_salary', 'max_salary', 'experience', 'category');
        $user = auth()->user();
        $notifications = $user->notifications;
        $unreadNotifications = $user->unreadNotifications;
        return view('job.index', ['jobs' => Job::with('employer')->latest()->filter($filters)->get(), 'notifications' => $notifications, 'unreadNotifications' => $unreadNotifications]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //We use this compact as we only have one variable to poss to the view
        $this->authorize('view', $job);
        return view(
            'job.show',
            ['job' => $job->load('employer.jobs')]
        );
    }
}
