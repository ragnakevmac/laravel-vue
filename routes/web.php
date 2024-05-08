<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/requests', function () {

    $requests = Request::with(['users', 'artist_song.songs'])->get();

    // foreach ($requests as $request) {
    //     echo 'Request ID: ' . $request->id . '<br>';
    //     echo 'Username: ' . ($request->users ? $request->users->username : 'No User') . '<br>';
    //     echo 'Song Name: ' . ($request->artist_song && $request->artist_song->songs ? $request->artist_song->songs->name : 'No Song') . '<br>';
    //     echo '<hr>';
    // }

    // $requests2 = DB::table('requests')
    //     ->join('users', 'users.id', '=', 'requests.user_id')
    //     ->join('artist_song', 'artist_song.id', '=', 'requests.artist_song_id')
    //     ->join('songs', 'songs.id', '=', 'artist_song.song_id')
    //     ->select('requests.*', 'users.username', 'songs.name')
    //     ->get();


    return Inertia::render('RequestVueFile', [
        'requests' => $requests,
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
