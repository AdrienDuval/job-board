<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\jobApplicationController;
use App\Http\Controllers\jobController;
use App\Http\Controllers\MyJobApplicationController;
use App\Http\Controllers\MyJobController;
use App\Http\Controllers\Notifications;
use App\Models\User;
use App\Notifications\NewLogin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', fn () => to_route('jobs.index'));

Route::resource('jobs', jobController::class)->only(['index', 'show']);

Route::get('login', fn () => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)->only(['create', 'store']);
Route::delete('logout', fn () => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])->name('auth.destroy');

Route::middleware('auth')->group(function () {
    Route::resource('jobs.application', jobApplicationController::class)->only(['create', 'store', 'showNotifications']);
    Route::resource('my-job-applications', MyJobApplicationController::class)->only(['index', 'destroy']);

    Route::resource('employer', EmployerController::class)->only(['create', 'store']);

    Route::middleware('employer')->resource('my-jobs', MyJobController::class);

    // Route::put('notifications/{notifications}', Notifications::class)->only(['index', 'update']);
    Route::put('notifications/{notification}', [Notifications::class, 'update'])->name('notifications.update');
    Route::post('notifications/mark-all-read', [Notifications::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    // Route::get('notifications', Notifications::class);
    // Route::resource('notifications', Notifications::class);
});


Route::get('/test-email', function () {
    $user = User::find(1);
    $userName = $user->name;
    $user->notify(new NewLogin($userName));
    dd('test email');
});

Route::get('send-mail', [EmailController::class, 'SendWelcomeEmail']);
