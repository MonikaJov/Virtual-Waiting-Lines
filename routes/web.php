<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\QueuesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/events', [EventController::class, 'index'])->name('events');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}/delete', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/join-queue', [EventController::class, 'joinQueue'])->name('events.joinQueue');
    Route::post('/events/{event}/leave-queue', [EventController::class, 'leaveQueue'])->name('events.leaveQueue');
    Route::get('/events/{event}/manage', [EventController::class, 'manage'])->name('events.manage');
    Route::get('/queues', [QueuesController::class, 'index'])->name('queues');
    Route::put('/events/{event}/manage-toggle', [EventController::class, 'toggleEvent'])->name('events.manage.toggle');

});

//Route::get('/queues', function () {
//    return view('queues.index');
//})->middleware(['auth', 'verified'])->name('queues');

require __DIR__.'/auth.php';
