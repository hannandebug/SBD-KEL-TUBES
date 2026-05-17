<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Models\Event;

// Meetup Home Page
Route::get('/', [HomeController::class, 'index'])->name('index');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Search
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Groups Routes
Route::get('/groups', [GroupController::class, 'index'])->name('groups');
Route::get('/groups/create', [GroupController::class, 'create'])->name('group.create')->middleware('auth');
Route::post('/groups', [GroupController::class, 'store'])->name('group.store')->middleware('auth');
Route::get('/groups/{id}', [GroupController::class, 'show'])->name('group.detail');
Route::post('/groups/{id}/join', [GroupController::class, 'join'])->name('group.join')->middleware('auth');
Route::post('/groups/{id}/leave', [GroupController::class, 'leave'])->name('group.leave')->middleware('auth');
Route::get('/groups/{id}/album', [GroupController::class, 'album'])->name('group.album');
Route::get('/my-groups', [GroupController::class, 'myGroups'])->name('my.groups')->middleware('auth');

// Events Routes
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/events/create', [EventController::class, 'create'])->name('event.create')->middleware('auth');
Route::post('/events', [EventController::class, 'store'])->name('event.store')->middleware('auth');
Route::get('/events/{id}', [EventController::class, 'show'])->name('event.detail');
Route::post('/events/{id}/rsvp', [EventController::class, 'rsvp'])->name('event.rsvp')->middleware('auth');
Route::post('/events/{id}/cancel-rsvp', [EventController::class, 'cancelRsvp'])->name('event.cancel-rsvp')->middleware('auth');
Route::get('/my-events', [EventController::class, 'myEvents'])->name('my.events')->middleware('auth');

// Reviews Routes
Route::post('/reviews', [HomeController::class, 'storeReview'])->name('review.store')->middleware('auth');

// Category Routes
Route::get('/explore/category/{category}', [CategoryController::class, 'explore'])->name('explore.category');

// Search by topic
Route::get('/search/topic/{topic}', [GroupController::class, 'searchByTopic'])->name('search.topic');

// Reviews Listing Page
Route::get('/reviews', [HomeController::class, 'reviews'])->name('reviews');

// Profile Page
Route::get('/profile', [HomeController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/profile/{id}', [HomeController::class, 'profileById'])->name('profile.id');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::put('/groups/{id}', [AdminController::class, 'updateGroup'])->name('group.update');
    Route::delete('/groups/{id}', [AdminController::class, 'deleteGroup'])->name('group.delete');
    Route::put('/events/{id}', [AdminController::class, 'updateEvent'])->name('event.update');
    Route::delete('/events/{id}', [AdminController::class, 'deleteEvent'])->name('event.delete');
});
