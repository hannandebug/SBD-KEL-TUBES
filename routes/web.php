<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\Event;

// Meetup Home Page
Route::get('/', [HomeController::class, 'index'])->name('index');

// Groups Listing Page
Route::get('/groups', [HomeController::class, 'groups'])->name('groups');

// Events Listing Page
Route::get('/events', [HomeController::class, 'events'])->name('events');

// Reviews Listing Page
Route::get('/reviews', [HomeController::class, 'reviews'])->name('reviews');

// Profile Page
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Event Detail Page
Route::get('/event/{id}', function ($id) {
    $event = Event::with(['group', 'detail'])->findOrFail($id);
    return view('event-detail', ['event' => $event]);
})->name('event.detail');
