<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
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

    Route::get('/events-list', [EventController::class, 'index'])->name('events.index'); // Etkinlikleri listele
    Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
    Route::post('/events/{eventId}/comments', [CommentController::class, 'store'])->name('event.comments.store');


    Route::middleware('admin')->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/data', [UserController::class, 'getData'])->name('admin.users.data');
        Route::post('/admin/users/{id}/update-role', [UserController::class, 'updateRole'])->name('admin.users.update-role');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create'); // Etkinlik ekle formu
        Route::post('/eventspost', [EventController::class, 'store'])->name('events.store'); // Etkinlik kaydet
        Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');
        Route::get('/communities/{id}/edit', [CommunityController::class, 'edit'])->name('communities.edit');
        Route::post('/communities/{id}', [CommunityController::class, 'update'])->name('communities.update');
        Route::post('/communities/{id}', [CommunityController::class, 'destroy'])->name('communities.destroy');


    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware(['auth'])
        ->name('logout');
});
