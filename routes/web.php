<?php

use Illuminate\Support\Facades\Route;

// Meetup Home Page
Route::get('/', function () {
    return view('index');
})->name('index');

// Profile Page
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Event Detail Page
Route::get('/event/{id}', function ($id) {
    return view('event-detail', ['eventId' => $id]);
})->name('event.detail');
