<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
use App\Models\Event;

// Meetup Home Page
Route::get('/', [HomeController::class, 'index'])->name('index');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Groups Routes
Route::get('/groups', [GroupController::class, 'index'])->name('groups');
Route::get('/groups/{id}', [GroupController::class, 'show'])->name('group.detail');
Route::post('/groups/{id}/join', [GroupController::class, 'join'])->name('group.join')->middleware('auth');
Route::post('/groups/{id}/leave', [GroupController::class, 'leave'])->name('group.leave')->middleware('auth');

// Events Routes
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/events/{id}', [EventController::class, 'show'])->name('event.detail');
Route::post('/events/{id}/rsvp', [EventController::class, 'rsvp'])->name('event.rsvp')->middleware('auth');
Route::post('/events/{id}/cancel-rsvp', [EventController::class, 'cancelRsvp'])->name('event.cancel-rsvp')->middleware('auth');

// Category Routes
Route::get('/explore/category/{category}', [CategoryController::class, 'explore'])->name('explore.category');

// Reviews Listing Page
Route::get('/reviews', [HomeController::class, 'reviews'])->name('reviews');

// Profile Page
Route::get('/profile', function () {
    return view('profile');
})->name('profile')->middleware('auth');
