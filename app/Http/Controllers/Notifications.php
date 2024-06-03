<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Facades\Vonage;
use Vonage\Client;

class Notifications extends Controller
{
    protected $vonage;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications;
        $unreadNotifications = $user->unreadNotifications;
        $notificationsId = $notifications->pluck('id');

        return dd($notificationsId->id);
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $notificationId)
    {
        $notification = DatabaseNotification::findOrFail($notificationId);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
    public function deleteAll(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $user->notifications()->delete();
        }

        return redirect()->back()->with('success', 'All notifications Deleted');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user)
    {
        $user = auth()->user();
        return $user->notifications()->delete();
    }

}
