<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Models\Artist;
use App\Models\Dj;
use App\Models\Song;
use App\Models\User;
use App\Models\ArtistSong;
use App\Models\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Http\Middleware\HandleInertiaRequests;

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

Route::get('/songs', function () {
    return Inertia::render('SongVueFile', [
        'songs' => Song::all(),
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




Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::delete('/requests/{id}', [RequestController::class, 'destroy'])->name('requests.destroy');
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
