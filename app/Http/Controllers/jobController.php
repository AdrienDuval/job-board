<?php

namespace App\Http\Controllers;

use App\Models\job;
use Illuminate\Http\Request;

class jobController extends Controller
{
    /**npm run dev
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('job.index', ['jobs' => job::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(job $job)
    {
        //We use this compact as we only have one variable to poss to the view
        return view('job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}