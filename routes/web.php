<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/communities', function () {
    return view('pages.communities');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('events.index');
    })->name('dashboard');

    Route::get('/events', [EventController::class, 'index'])->name('events.index'); // Etkinlikleri listele

    Route::middleware('admin')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create'); // Etkinlik ekle formu
        Route::post('/events', [EventController::class, 'store'])->name('events.store'); // Etkinlik kaydet
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware(['auth'])
        ->name('logout');
});
