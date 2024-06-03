<?php

namespace App\Http\Controllers;

use App\Notifications\NewLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmailController;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {

            $emailController = new EmailController();
            $emailController->SendWelcomeEmail();

            $user = auth()->user();
            $userName = $user->name;
            // $message = "my test message";
            // $user->notify(new NewLogin($userName));

            $user = auth()->user();
            $user->notify(new NewLogin($user));
            // dd($response);

            return redirect()->intended('/')->with('success', 'Welcome back ' . $userName . '😃');
        } else {
            return redirect()->back()->with('error', 'invalid credentials');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
