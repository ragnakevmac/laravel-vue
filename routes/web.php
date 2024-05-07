<?php

use App\Http\Controllers\ProfileController;
use App\Models\Artist;
use App\Models\Dj;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/djs', function () {
    return Inertia::render('DjVueFile', [
        'djs' => Dj::all(),
    ]);
});

Route::get('/users', function () {
    return Inertia::render('UserVueFile', [
        'users' => User::all(),
    ]);
});

Route::get('/artists', function () {
    return Inertia::render('ArtistVueFile', [
        'artists' => Artist::all(),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
