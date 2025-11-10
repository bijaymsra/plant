<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProposerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EventController;

// for all routes
Route::get('/', [LandingController::class, 'dashboard']);
Route::get('/home', [LandingController::class, 'dashboard']);
Route::get('/dashboard', [LandingController::class, 'dashboard']);
Route::get('/login', [LoginsController::class, 'showLoginForm'])->name('login');

Route::get('/proposer', [ProposerController::class, 'showProposer'])->name('proposer');
Route::get('/admin', [AdminController::class, 'showAdmin'])->name('admin');
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login.custom');
Route::post('/events', [EventController::class, 'store'])->middleware('auth')->name('events.store');


// proposer section only
// filter-events
Route::get('/events/filter/{status}', [EventController::class, 'filter'])->name('events.filter');
// navbar-search
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
// Now the resource route (comes after)
Route::resource('events', EventController::class);


Route::get('/proposer/profile', function () {
    return view('proposer/details/profile'); // Make sure you have a profile.blade.php view
})->name('proposer.profile');


Route::get('/proposer/change-password', function () {
    return view('proposer/details/change-password'); // or any view you want
})->name('proposer.change.password');


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');



// user-section

Route::get('/user', [UserController::class, 'showUser'])->name('user');



// admin-section
Route::get('/admin', [AdminController::class, 'showUsers'])->name('admin');
Route::get('/admin/filter-events', [AdminController::class, 'filterEvents']);

// toggle and bookmark
Route::post('/events/{id}/toggle-participation', [UserController::class, 'toggleParticipation'])->middleware('auth');
Route::post('/events/{event}/toggle-bookmark', [EventController::class, 'toggleBookmark'])->middleware('auth');




// change status 

// from pending to approved
Route::post('/admin/events/{event}/approve', [AdminController::class, 'approveEvent'])->name('admin.events.approve');


// from approved to pending
Route::post('/admin/events/{event}/pause', [AdminController::class, 'pauseEvent'])->name('admin.events.pending');


// form approved to rejected
Route::post('/admin/events/{event}/reject', [AdminController::class, 'rejectEvent'])->name('admin.events.reject');


Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});